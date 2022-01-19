<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Aquisicao;
use App\Bilhete;
use App\Pkey;
use GuzzleHttp\Client as HttpClient;

class PaymentController extends Controller
{

    public $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }

    public function index()
    {
        return view('payment');
    }

    public function setPaymentMethod(Request $request)
    {

        $bilhete = Bilhete::where("id", "=", $request->id_bilhete)->first();

        if ($request->quantidade > $bilhete->quantidade) {
            return redirect()->route('requisicao', ['id_evento' => $request->id_evento, 'error_status' => true]);
        } else {
            //TODO
            if ($request->pagamento == 'PAYPALL') {
                $this->charge($request);
                //return $request->pagamento;
            } else if ($request->pagamento == 'MPESA') {
                return view('requisicao/mpesaForm')->with(["dadosPagamento" => $request]);
            }
            return 'error payment';
        }
    }

    public function charge(Request $request)
    {
        //prepare payment value
        $bilheteMain = Bilhete::where("id", "=", $request->id_bilhete)->first();
        $valorDePagamento = $bilheteMain->preco * $request->quantidade;

        // $amountAux = $request->valor_pagar;
        $amountAux = $valorDePagamento;
        $cambio = 65;

        $amount = ceil($amountAux / $cambio);
        $quantidade = $request->quantidade;
        $id_evento = $request->id_evento;
        $id_bilhete = $request->id_bilhete;
        $id_cliente = session('idCliente');
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('paypalsuccess/' . $amount . '/' . $quantidade . '/' . $id_evento . '/' . $id_bilhete . '/' . $id_cliente),
                'cancelUrl' => url('paypalerror'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect(); // this will automatically forward the customer
            } else {
                // not successful
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function payment_success(Request $request, $amount, $quantidade, $id_evento, $id_bilhete, $id_cliente)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();

                // Insert transaction data into the database              
                $id = new Pkey();
                $aquisicao = new Aquisicao();
                $aquisicao->id = $id->idGenerator();
                $aquisicao->quantidade = $quantidade;
                $aquisicao->valor = $amount;
                $aquisicao->eventoId = $id_evento;
                $aquisicao->bilheteId = $id_bilhete;
                $aquisicao->clienteId = $id_cliente;
                $aquisicao->created_at = date('Y-m-d h:i:s');
                $aquisicao->estado = "PENDENTE";
                $aquisicao->metodoPagamentoId = "l6FDGoOT001";

                $aquisicao->save();

                $bilhete = Bilhete::where("id", "=", $aquisicao->bilheteId)->first();
                $quantidade = $bilhete->quantidade;
                $bilhete->quantidade = $quantidade - $aquisicao->quantidade;
                $bilhete->save();

                // return json_encode($aquisicao);

                // return "Payment is successful. Your transaction id is: " . $arr_body['id'];
                return redirect('perfil')->with('success', 'paymanetSuccess');
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }

    public function payment_error()
    {
        return 'User is canceled the payment.';
    }

    public function sendToPromoter($amount)
    {
        
        $ch = curl_init();
        $clienteId = "";
        $secretKey = "";
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, env('PAYPAL_CLIENT_ID') . ":" . env('PAYPAL_CLIENT_SECRET'));

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Accept-Language: en_US";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $results = curl_exec($ch);
        $getresult = json_decode($results);

        // echo json_encode($getresult);
        // PayPal Payout API for Send Payment from PayPal to PayPal account
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $array = array(
            'sender_batch_header' => array(
                "sender_batch_id" => time(),
                "email_subject" => "You have a payout!",
                "email_message" => "You have received a payout."
            ),
            'items' => array(array(
                "recipient_type" => "EMAIL",
                "amount" => array(
                    "value" => $amount * 0.9,
                    "currency" => "USD"
                ),
                "note" => "Thanks for the payout!",
                "sender_item_id" => time(),
                "receiver" => 'domcalodcd@gmail.com'
            ))
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer $getresult->access_token";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $payoutResult = curl_exec($ch);
        //print_r($result);
        $getPayoutResult = json_decode($payoutResult);
        if (curl_errno($ch)) {
            // echo 'Error:' . curl_error($ch);
            return false;
        }
        curl_close($ch);
        // echo json_encode($getPayoutResult);
        return true;
    }


    public function mpesaPayment(Request $request)
    {
        //prepare payment amount
        $bilheteMain = Bilhete::where("id", "=", $request->input('id_bilhete'))->first();
        $valorDePagamento = $bilheteMain->preco * $request->quantidade;

        $number = "258" . $request->input('numTelefone');
        // $valor = $request->input('valorPagar');
        $valor = $valorDePagamento;

        $publicKey = env('MPESA_PUBLIC_KEY');
        $apiKey = env('MPESA_API_KEY');
        $shortCode = env('MPESA_SHORTCODE');
        $mainUrl = env('MPESA_URL');

        $mainToken = null;
        if (!empty($publicKey) && !empty($apiKey)) {
            $key = "-----BEGIN PUBLIC KEY-----\n";
            $key .= wordwrap($publicKey, 60, "\n", true);
            $key .= "\n-----END PUBLIC KEY-----";
            $pk = openssl_get_publickey($key);
            openssl_public_encrypt($apiKey, $token, $pk, OPENSSL_PKCS1_PADDING);

            $mainToken = base64_encode($token);
        }


        //request
        $url = "https://" . $mainUrl . ":18352/ipg/v1x/c2bPayment/singleStage/";
        $params = [
            "input_ThirdPartyReference" => "" . time(),
            "input_Amount" => $valor,
            "input_CustomerMSISDN" => $number,
            "input_ServiceProviderCode" => $shortCode,
            "input_TransactionReference" => "" . time()
        ];

        $headers = [
            "Origin" => "*",
            "Authorization" => "Bearer " . $mainToken,
            "Content-Type" => "application/json",
            "Host" => $mainUrl
        ];


        $httpClient = new HttpClient();
        $response = $httpClient->post($url, [
            'json' => $params,
            'headers' => $headers,
            'http_errors' => FALSE
        ]);

        echo $response->getBody()->getContents();
    }

    public function mpesaPaymentSuccess($valor, $quantidade, $bilheteId, $eventoId)
    {
        //prepare payment amount
        $bilheteMain = Bilhete::where("id", "=", $bilheteId)->first();
        $valorDePagamento = $bilheteMain->preco * $quantidade;

        $valor = $valorDePagamento;

        // Insert transaction data into the database              
        $id = new Pkey();
        $aquisicao = new Aquisicao();
        $aquisicao->id = $id->idGenerator();
        $aquisicao->quantidade = $quantidade;
        $aquisicao->valor = $valor;
        $aquisicao->eventoId = $eventoId;
        $aquisicao->bilheteId = $bilheteId;
        $aquisicao->clienteId = session('idCliente');
        $aquisicao->created_at = date('Y-m-d h:i:s');
        $aquisicao->estado = "PENDENTE";
        $aquisicao->metodoPagamentoId = "l6FDGoOT002";

        $aquisicao->save();

        $bilhete = Bilhete::where("id", "=", $aquisicao->bilheteId)->first();
        $quantidade = $bilhete->quantidade;
        $bilhete->quantidade = $quantidade - $aquisicao->quantidade;
        $bilhete->save();

        return redirect('perfil')->with('success', 'paymanetSuccess');
    }
}

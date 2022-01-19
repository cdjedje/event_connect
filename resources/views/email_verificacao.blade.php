@component('mail::message')
<h3>Saudações,</h3>
<p>Clique no botão abaixo para verificar seu endereço de e-mail.</p>

@component('mail::button', ['url' => url('verificar-email/'.$IdCliente), 'color' => 'primary'])
Verificar email
@endcomponent

<p>Se você não criou uma conta, nenhuma ação adicional é necessária.<br>

Atenciosamente,<br>
EventConnect</p>
<br>
Obrigado
@endcomponent

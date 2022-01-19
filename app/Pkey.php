<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pkey extends Model
{

    public function getEventImagePath()
    {
        return "http://ginga.co.mz/event_img"; //"http://localhost/eventImg";
    }

    public function idGenerator()
    {
        $length = 11;
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }
}

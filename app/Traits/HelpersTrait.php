<?php

namespace App\Traits;

use App\Mail\ResetPasswordMail;
use App\ThirdParty\SmsMasr;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;


trait HelpersTrait
{

    
    public function IsNullOrEmptyString($str)
    {
        return ($str === null || trim($str) === '');
    }

    /**
     * check if keys in array
     * @param array $keys
     * @param array $arr
     * @return bool
     */
    function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

    /**
     * send sms message to verify user phone
     * @param $phone
     * @param $token
     * @param $msg
     * @return bool
     */
    public function sendSmsMessage($phone, $token, $msg = 'Activation code: ', $lang = 2)
    {
        $message = $msg . $token;
        $smsMasr = new SmsMasr($message, [$phone], $lang);
        $smsMasr->sendMessage();
        return true;
    }

    public function sendMail($mail,$code,  $msg = 'Activation code: '){
        
        $data = [ 'msg' => $msg . ' '. $code];
        Mail::to($mail)->send(new ResetPasswordMail($data));
        return true;
    }
}

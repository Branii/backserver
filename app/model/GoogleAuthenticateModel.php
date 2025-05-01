<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

use Google\Authenticator\GoogleQrUrl;

class GoogleAuthenticateModel extends MEDOOHelper
{
   public static function UpdategoogleAuth(string $email){

     $g = new GoogleAuthenticator();
     $secret = $g->generateSecret();
      $params = [
        'email' =>$email,
        'two_factor_enabled' =>"on",
        'otp_secret' =>$secret  
      ];
      
      $sql = "UPDATE system_administrators SET two_factor_enabled = :two_factor_enabled, otp_secret = :otp_secret WHERE email = :email";
       $updated = parent::query($sql, $params);
       if ($updated !== false) {
        $qrUrl = GoogleQrUrl::generate($email, $secret, 'MyApp');
        return [
            'status' => 'success',
            'secret' => $secret,
            'qrUrl' => $qrUrl
        ];
    }

      
   }

}
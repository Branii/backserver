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
      $params = ['email' =>$email,'otp_secret' =>$secret];
      $sql = "UPDATE system_administrators SET otp_secret = :otp_secret WHERE email = :email";
      $updated = parent::query($sql, $params);
      if ($updated !== false) {
        $qrUrl = GoogleQrUrl::generate($email, $secret, 'Enzerhub');
        return ['status' => 'success','qrUrl' => $qrUrl];
      }
      
  }

  public static function UpdatemobileAuth(string $email){
    $params = ['two_factor_enabled'=>"on",'email'=>$email ,'two_factor_method' =>"mobile"];
    $sql = "UPDATE system_administrators SET two_factor_enabled = :two_factor_enabled,two_factor_method =:two_factor_method WHERE email = :email";
    $updated = parent::query($sql, $params);  
    if ($updated !== false) {
        return ['status' => 'success'];
      }
  }

  public static function VerifyOtpCode($email,$otpcode){
    $data = parent::query( "SELECT admin_id,email, otp_secret FROM system_administrators WHERE email = :email",['email' => $email]);
    $secretcode = $data[0]['otp_secret'];
    $g = new GoogleAuthenticator();
    if ($g->checkCode($secretcode, $otpcode)) {
        $params = ['two_factor_enabled' =>"on",'email'=>$email ,'two_factor_method' => "google"];
        $sql = "UPDATE system_administrators SET two_factor_enabled = :two_factor_enabled,two_factor_method =:two_factor_method WHERE email = :email";
        $updated = parent::query($sql, $params);
        return "success";
    } else {
        return "Invalid 2FA code. Try again";
    }
  }

  public static function GetSecreteCode($email,$otpcodes,$flagtype){

     if($flagtype == "mobile"){
          $data = parent::query( "SELECT admin_id,email, otp_secret FROM system_administrators WHERE email = :email",['email' => $email]);
          $secretcode = $data[0]['otp_secret'];
          if($secretcode == $otpcodes){
             $_SESSION['isUserLoggedIn'] = $email;
             $_SESSION['isUserLoggedInId'] = $data[0]['admin_id'];
              return [
                'status' =>'success',
                'url' => '/admin/limvo/admin/home'
              ];
          } else {
            return ['status' =>'Invalid 2FA code. Try again'];
          }
       }else{
          $data = parent::query( "SELECT admin_id,email, otp_secret FROM system_administrators WHERE email = :email",['email' => $email]);
          $secretcode = $data[0]['otp_secret'];
          $g = new GoogleAuthenticator();
          if ($g->checkCode($secretcode, $otpcodes)) {
            $_SESSION['isUserLoggedIn'] = $email;
            $_SESSION['isUserLoggedInId'] = $data[0]['admin_id'];
              return [
                'status' =>'success',
                'url' => '/admin/limvo/admin/home'
              ];
          } else {
            return [
              'status' =>'Invalid 2FA code. Try again' ];
          }
       }
     
  }

  public  static function SignOptionUpdates($email,$code){
      $params = ['email' =>$email,'otp_secret' =>$code];
      $sql = "UPDATE system_administrators SET otp_secret = :otp_secret WHERE email = :email";
      $updated = parent::query($sql, $params);
  }

  public static function SignOptionVerify($email,$otpcodes,$opt){

      if($opt == "mobile"){
          $data = parent::query( "SELECT admin_id,email, otp_secret FROM system_administrators WHERE email = :email",['email' => $email]);
          $secretcode = $data[0]['otp_secret'];
          if($secretcode == $otpcodes){
             $params = ['email' =>$email,'two_factor_method' =>'default'];
             $sql = "UPDATE system_administrators SET two_factor_method = :two_factor_method WHERE email = :email";
             $updated = parent::query($sql, $params);
             $_SESSION['isUserLoggedIn'] = $email;
             $_SESSION['isUserLoggedInId'] = $data[0]['admin_id'];
              return [
                'status' =>'success',
                'url' => '/admin/limvo/admin/home'
              ];
          } else {
            return ['status' =>'Invalid 2FA code. Try again'];
          }
       }else{
        
          $data = parent::query( "SELECT admin_id,email, otp_secret FROM system_administrators WHERE email = :email",['email' => $email]);
          $secretcode = $data[0]['otp_secret'];
          if($secretcode == $otpcodes){
            $params = ['email' =>$email,'two_factor_method' =>'default'];
            $sql = "UPDATE system_administrators SET two_factor_method = :two_factor_method WHERE email = :email";
            $updated = parent::query($sql, $params);
            $_SESSION['isUserLoggedIn'] = $email;
            $_SESSION['isUserLoggedInId'] = $data[0]['admin_id'];
              return [
                'status' =>'success',
                'url' => '/admin/limvo/admin/home'
              ];
          } else {
            return ['status' =>'Invalid 2FA code. Try again'];
          }

      }

  }

  public static function GetOtpCode($email){
    $data = parent::query( "SELECT phone_number FROM system_administrators WHERE email = :email",['email' => $email]);
    return $secretcode = $data[0]['phone_number'];
  }

   public static function CheckotpStatus($email){
    $data = parent::query( "SELECT two_factor_enabled, FROM system_administrators WHERE email = :email",['email' => $email]);
    return $secretcode = $data[0]['phone_number'];
  }
  
   public static function ResetAuthentication($email){
    $params = ['email' =>$email,'two_factor_method' =>'default'];
    $sql = "UPDATE system_administrators SET two_factor_method = :two_factor_method WHERE email = :email";
    $updated = parent::query($sql,$params);
    if ($updated !== false) {
        return ['status' => 'success'];
      }
  }
  

  

}
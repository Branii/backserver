<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailProviderModel  extends GearmanWorker{

    // private  $provider;
    // public function __construct(string $provider){
    //     $this->provider = $provider;
    // }

    // public  function sendsms($mesage,$phonenumber){
    //     return match($this->provider){
    //         'smsonlinegh' => self::sendSmsGonline($mesage, $phonenumber),
    //     };
    // }

    public  function sendEmailDefault($email,$code)
    {
    //    if (filter_var($emails, FILTER_VALIDATE_EMAIL)) {
         $mail = new PHPMailer(true);

        try {
            // SMTP config for Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'pneumalogoss@gmail.com';         // Your Gmail address
            $mail->Password   = 'uxoz rwmj exdm wesl';      // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Email content
            $mail->setFrom('pneumalogoss@gmail.com', 'Enzerhub TestApp');
            $mail->addAddress($email);
            $mail->Subject = 'Your Verification Code';
            $mail->Body    = "Your verification code is: $code";
            $mail->send();
             echo "Verification code sent to your email.";
        } catch (Exception $e) {
            http_response_code(500);
            echo "Email failed: {$mail->ErrorInfo}";
        }
          
    }
}

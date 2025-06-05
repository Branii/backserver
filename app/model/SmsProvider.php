<?php

class SmsProvider  extends GearmanWorker{

    private  $provider;
    public function __construct(string $provider){
        $this->provider = $provider;
    }

    public  function sendsms($params){
        return match($this->provider){
            'smsonlinegh' => self::sendSmsGonline($params['message'], $params['mobile']),
        };
    }

    public  function sendSmsGonline($mesage, $phonenumber)
    {
        $headers = ['Host: api.smsonlinegh.com', 'Content-Type: application/json', 'Accept: application/json', 
        'Authorization: key a49c61c65a8166d35b55fbcdcef25771399768bab912caf0cc987c33216d3b9c'
       ];

        // set up the message data
        $messageData = [
            'text' => $mesage,
            'type' => 0, // GSM default
            'sender' => 'LIMVO APP',
            'destinations' => [$phonenumber],
        ];
        // initialise cURL
        $ch = curl_init('https://api.smsonlinegh.com/v5/sms/send');

        // set cURL optionS
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute for response
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close curl
        curl_close($ch);

        if ($httpCode == 200) {
            return ['OTP sent successfully'];
        } else {
            return ['Could not send OTP'];
        }
    }

    public static function getSmsGHBalance($provider)
    {
        $endPoint = 'https://api.smsonlinegh.com/v5/account/balance';

        $headers = ['Host: api.smsonlinegh.com', 'Content-Type: application/json', 'Accept: application/json', 'Authorization: key a49c61c65a8166d35b55fbcdcef25771399768bab912caf0cc987c33216d3b9c'];

        $ch = curl_init($endPoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        header('Content-Type: application/json');

        if ($httpCode == 200) {
            $data = json_decode($response, true);

            if (!isset($data['data']['balance'])) {
                echo json_encode(['error' => 'No balance data in response']);
                exit();
            }

            $currentBalance = (int) $data['data']['balance'];
            $file = 'sms_total.txt';
            // If not set, initialize it
            if (!file_exists($file)) {
                file_put_contents($file, $currentBalance);
            }

            // Read the original total
            $initialTotal = (int) file_get_contents($file);
            $used = $initialTotal - $currentBalance;
            PLatFormSettingModel::UpdateSms($initialTotal, $used, $currentBalance, $provider);
        } else {
            echo json_encode(['error' => 'Failed to fetch balance']);
        }
    }

    
}

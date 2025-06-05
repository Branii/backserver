<?php
use Kicken\Gearman\Client;

class SmsPromotionWorker extends MEDOOHelper
{
  

    public function rundeposit(): void
    {
        $worker = new \Kicken\Gearman\Worker('127.0.0.1:4730');
        echo "deposit is ready for jobs\n";
     

         $worker->registerFunction('send_new_user_deposit',function(\Kicken\Gearman\Job\WorkerJob $job) {
              $payload = json_decode($job->getWorkload(), true);

              $message =  "Your deposit has been successfully processed. Thank you!";
              $users= $this->SmsDpositinfo($payload);
               echo "Sending [$payload] SMS to " . count($users) . " users...\n";

               foreach ($users as $user) {
                    if (strtolower($user['sms_sent']) !== 'pending') {
                        echo "No users with status 'new'\n";
                        return;
                     }
                    $this->sendSms($user['contact'], $message,$user['user_id']);
                    $sql = ("UPDATE deposit_new SET sms_sent = 'sent' WHERE user_id = :user_id");
                     $data = parent::query($sql, ['user_id' =>$user['user_id']]);
                }
            
        });

        $worker->work();
    }


    public function runwithdrawal(): void
    {
        $worker1 = new \Kicken\Gearman\Worker('127.0.0.1:4730');
        echo "Worker is ready for jobs\n";
     

         $worker1->registerFunction('send_new_user_withdraw',function(\Kicken\Gearman\Job\WorkerJob $job) {
            $payload = json_decode($job->getWorkload(), true);

              $eventTemplates = "Your withdrawal has been processed successfully.";
        
                 $users = $this->SmsWithdrawinfo($payload);
                 echo "Sending [$payload] SMS to " . count($users) . " users...\n";

                foreach ($users as $user) {
                
                    if (strtolower($user['sms_sent']) !== 'pending') {
                        echo "No users with status 'new'\n";
                        return;
                    }
                     $this->sendSms($user['contact'], $eventTemplates);
                     $sql = ("UPDATE withdrawal_manage SET sms_sent = 'sent' WHERE uid = :uid");
                     $data = parent::query($sql, ['uid' =>$user['uid']]);
                     
                }
            
        });

        $worker1->work();
    }


    public function sendSms(string $phone, string $message): void
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization:key a49c61c65a8166d35b55fbcdcef25771399768bab912caf0cc987c33216d3b9c',
        ];

        $messageData = [
            'text' => $message,
            'type' => 0,
            'sender' => 'LIMVO APP',
            'destinations' => [$phone],
        ];

        $ch = curl_init('https://api.smsonlinegh.com/v5/sms/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            echo "SMS sent to $phone\n";
        } else {
            echo "Failed to send SMS to $phone\n";
        }
    }

    public  function SmsDpositinfo($column){
    $sql = ("SELECT d.user_id, u.contact, d.sms_sent
    FROM deposit_new d
    INNER JOIN users_test u ON u.uid = d.user_id
    CROSS JOIN sms_preferences p
    WHERE p.$column = 1 AND d.sms_sent = 'pending'
    LIMIT 10");
    return   $users = parent::query($sql); 
            
    }

    public  function SmsWithdrawinfo($column){
    $sql = ("SELECT w.uid, u.contact, w.sms_sent
    FROM withdrawal_manage w
    INNER JOIN users_test u ON u.uid = w.uid
    CROSS JOIN sms_preferences p
    WHERE p.$column = 1 AND w.sms_sent = 'pending'
    LIMIT 10");
    return   $users = parent::query($sql); 
            
    }



   public static function ProccessSMS($workload) {
      echo "Processing sms: " . $workload . PHP_EOL;
        // Simulate some processing
        return strtoupper($workload);
   }

   public static function ProccessEMAIL($workload) {
       echo "Processing email: " . $workload . PHP_EOL;
        // Simulate some processing
        return strtoupper($workload);
   }

   public static function ProccessDEPOSIT($workload) {
       echo "Processing deposit: " . $workload . PHP_EOL;
        // Simulate some processing
        return strtoupper($workload);
   }

   

}

// // Setup Gearman Worker
// $worker = new worker('127.0.0.1:4730'); // Replace with actual server if needed

// foreach (Testworkers::getWorker() as [$functionName, $callback]) {
//     $worker->registerFunction($functionName, function (\Kicken\Gearman\Job\WorkerJob $job) use ($callback) {
//         return $callback($job->getWorkload());
//     });
//     echo "Registered worker: $functionName" . PHP_EOL;
// }

// while ($worker->work()) {
//     if ($worker->returnCode() != GEARMAN_SUCCESS) {
//         echo "Gearman error: " . $worker->error() . PHP_EOL;
//         break;
//     }
// }


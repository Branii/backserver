<?php 
// require_once __DIR__ . '/vendor/autoload.php';

use Kicken\Gearman\Worker as worker;
use Kicken\Gearman\Job\WorkerJob as jobs;
class GearmanWorker  extends MEDOOHelper {

public static function ProccessGamesWon($workload) {
       echo "Processing games won: " . $workload . PHP_EOL;
        $provider = PLatFormSettingModel::getActiveProvider($workload);
        $users =  self::SmsgamesWon($workload);
        echo "Sending [$workload] SMS to " . count($users) . " users...\n";
        foreach ($users as $user) {
            if (strtolower($user['sms_sent']) !== 'pending') {
                echo "No users with status 'new'\n";
                return;
                }

            PLatFormSettingModel::smsOptionToUse($provider,$user['message'],$user['contact']);
             $sql = ("UPDATE notifications SET sms_sent = 'sent' WHERE user_id = :user_id");
             $data = parent::query($sql, ['user_id' =>$user['user_id']]);
        }
}
public  static function SmsgamesWon($column){
    $sql = ("SELECT n.user_id, n.contact, n.sms_sent, n.message FROM notifications n
    CROSS JOIN sms_preferences p
    WHERE p.$column = 1 AND n.sms_sent = 'pending'
    LIMIT 100");
    return  $users = parent::query($sql); 
    //  return $trasationIds = array_column($data, 'user_id');

}

// public static function sendSms(string $phone, string $message): void
// {
//         $headers = [
//             'Content-Type: application/json',
//             'Accept: application/json',
//             'Authorization:key a49c61c65a8166d35b55fbcdcef25771399768bab912caf0cc987c33216d3b9c',
//         ];

//         $messageData = [
//             'text' => $message,
//             'type' => 0,
//             'sender' => 'LIMVO APP',
//             'destinations' => [$phone],
//         ];

//         $ch = curl_init('https://api.smsonlinegh.com/v5/sms/send');
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//         $response = curl_exec($ch);
//         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         curl_close($ch);

//         if ($httpCode == 200) {
//             echo "SMS sent to $phone\n";
//         } else {
//             echo "Failed to send SMS to $phone\n";
//         } 
// }


// public static function ProccessWithdrawal($workload) {
//        echo "Processing withrawal sms: " . $workload . PHP_EOL;
//         $message = "Your withdrawal has been processed successfully.";
        
//         $users =self::SmsWithdrawinfo($workload);
//         echo "Sending [$workload] SMS to " . count($users) . " users...\n";
//        foreach ($users as $user) {
//         if (strtolower($user['sms_sent']) !== 'pending') {
//             echo "No users with status 'new'\n";
//             return;
//         }
//             $amount = number_format($user['actual_withdrawal_amount'], 2); 
//             $message = "Your withrawal of $amount has been successfully processed. Thank you!";
//             // self::sendSms($user['contact'], $message);
//          //SmsProvider::sendSmsGonline($message,$user['contact'],);
//         $sql = ("UPDATE withdrawal_manage SET sms_sent = 'sent' WHERE uid = :uid");
//         $data = parent::query($sql, ['uid' =>$user['uid']]);

//       }
// }


// public  static function SmsWithdrawinfo($column){
//     $sql = ("SELECT w.uid, u.contact, w.sms_sent,w.actual_withdrawal_amount FROM withdrawal_manage w
//     INNER JOIN users_test u ON u.uid = w.uid
//     CROSS JOIN sms_preferences p
//     WHERE p.$column = 1 AND w.sms_sent = 'pending'
//     LIMIT 10");
//     return   $users = parent::query($sql); 
            
// }

// public static function smsOptionToUse($message,$contact) {  
//     $sql = "SELECT sms_provider FROM sms_preferences WHERE status = 'active'";
//     $data = parent::query($sql);
//     $provider = $data[0]['sms_provider'] ?? null;
//     if ($provider === 'smsonlinegh') {
//         SmsProvider::sendSmsGonline($message,$contact,);
//     } elseif ($provider === 'Twilio') {
//         SmsProvider::sendSmsTwilio($message,$contact);
//     } else {
//         error_log("No valid active SMS provider found.");
//     }
// }

//    public static function ProccessEMAIL($workload) {
//        echo "Processing email: " . $workload . PHP_EOL;
//         // Simulate some processing
//         return strtoupper($workload);
//    }


// public static function ProcessGamesWon($workload) {
//     echo "Processing games won: " . $workload . PHP_EOL;

//     $provider = PlatformSettingModel::getActiveProvider($workload);
//     $users = self::SmsgamesWon($workload);

//     echo "Sending [$workload] SMS to " . count($users) . " users...\n";

//     if (empty($users)) {
//         return;
//     }

//     // Prepare data for bulk sending
//     $contacts = array_column($users, 'contact');
//     $messages = array_column($users, 'message'); // Assuming all messages are same OR you’ll structure it differently

//     // Send bulk SMS (you need to modify smsOptionToUse to accept arrays)
//     PlatformSettingModel::smsOptionToUse($provider, $messages, $contacts);

//     // Collect user_ids for batch update
//     $userIds = array_column($users, 'user_id');

//     // Mark messages as sent in bulk
//     if (!empty($userIds)) {
//         $inQuery = implode(',', array_fill(0, count($userIds), '?'));
//         $sql = "UPDATE notifications SET sms_sent = 'sent' WHERE user_id IN ($inQuery)";
//         parent::query($sql, $userIds);
//     }
// }

// function sendArkeselSMS($message, $recipient, $sender = 'LIMVO APP') {
//     $apiKey = 'your_arkesel_api_key';

//     $payload = [
//         'sender' => $sender,
//         'message' => $message,
//         'recipients' => [$recipient]
//     ];

//     $ch = curl_init('https://sms.arkesel.com/api/v2/sms/send');
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Authorization: Bearer ' . $apiKey,
//         'Content-Type: application/json'
//     ]);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

//     $response = curl_exec($ch);
//     curl_close($ch);

//     return json_decode($response, true);
// }

//
// function sendArkeselBulkSMS($message, array $recipients, $sender = 'LIMVO APP') {
//     $apiKey = 'your_arkesel_api_key';

//     $payload = [
//         'sender' => $sender,
//         'message' => $message,
//         'recipients' => $recipients  // array of numbers e.g. ["233243403313", "233553812349"]
//     ];

//     $ch = curl_init('https://sms.arkesel.com/api/v2/sms/send');
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Authorization: Bearer ' . $apiKey,
//         'Content-Type: application/json'
//     ]);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

//     $response = curl_exec($ch);
//     curl_close($ch);

//     return json_decode($response, true);
// }

  
}




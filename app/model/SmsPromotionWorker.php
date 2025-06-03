<?php
use Kicken\Gearman\Client;

class SmsPromotionWorker
{
  

    public function run(): void
    {
        $worker = new \Kicken\Gearman\Worker('127.0.0.1:4730');
        echo "Worker is ready for jobs\n";

         $worker->registerFunction('send_new_user_promotions',function(\Kicken\Gearman\Job\WorkerJob $job)  {
            $payload = json_decode($job->getWorkload(), true);

            var_dump($payload);
            exit;

            if (!is_array($payload)) {
                echo "Invalid workload format\n";
                return;
            }

            $eventTemplates = [
                'deposit'  => "Your deposit has been successfully processed. Thank you!",
                'withdraw' => "Your withdrawal has been processed successfully.",
                'promo'    => "You have a new promotional offer waiting!",
            ];

            foreach ($payload as $event) {
                if (!isset($eventTemplates[$event])) {
                    echo "Unknown event: $event\n";
                    continue;
                }

                $message = $eventTemplates[$event];
                $column = $event;

                $stmt = $this->pdo->prepare("
                    SELECT u.id, u.phone, u.status
                    FROM users u
                    CROSS JOIN sms_preferences p
                    WHERE p.{$column} = 1 AND u.status = 'new'
                    LIMIT 10
                ");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "Sending [$event] SMS to " . count($users) . " users...\n";

                foreach ($users as $user) {
                    if (strtolower($user['status']) !== 'new') {
                        echo "No users with status 'new'\n";
                        return;
                    }

                    $this->sendSms($user['phone'], $message);

                    // Mark as sent
                    $updateStmt = $this->pdo->prepare("UPDATE users SET status = 'sent' WHERE id = :id");
                    $updateStmt->execute([':id' => $user['id']]);
                }
            }
        });

        echo "Worker running for new signups...\n";
        $worker->work();
    }

    private function sendSms(string $phone, string $message): void
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
}

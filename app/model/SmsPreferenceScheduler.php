<?php
use Revolt\EventLoop;
use Kicken\Gearman\Client;
class SmsPreferenceScheduler extends MEDOOHelper
{
    public function run(): void
    {
        $client = new Client('127.0.0.1:4730');
        EventLoop::repeat(1, function () use ($client) {
            $seconds = date("s");
            echo "$seconds\n";

            if ($seconds === "00") {
                if (!$this->hasRunThisMinute) {
                    echo "Checking preferences at " . date("H:i:s") . "\n";
                    $this->hasRunThisMinute = true;
                    $this->checkAndSubmitJob();
                }
            } else {
                $this->hasRunThisMinute = false;
            }
        });

        EventLoop::run();
    }

    public function checkAndSubmitJob(): void
    {
        $client = new Client('127.0.0.1:4730');
        $sql = "SELECT gamewon FROM sms_preferences WHERE id = 1";
        $prefs = parent::query($sql);
        
            if ($prefs[0]['gamewon'] == 1) {
                $eventTypes = "gamewon";
                if (!empty($eventTypes)) {
                    $client->submitBackgroundJob('sms_gameswon', $eventTypes);
                    echo "Job submitted for: " .  $eventTypes . "\n";
                } else {
                    echo "No enabled event types. Job not sent.\n";
                }
            } 
    }

}

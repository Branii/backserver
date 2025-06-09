<?php
 date_default_timezone_set('Asia/Shanghai');
class PLatFormSettingModel extends MEDOOHelper
{
  

    public static function FetchSms($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $data = parent::query("SELECT * FROM sms_config ORDER BY sms_id DESC LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('sms_config');
        return ['data' => $data, 'total' => $totalRecords];
    }

    // public static function getUsernameById(mixed $userId)
    // {
    //     $data = parent::query("SELECT username,email,contact,reg_type,uid FROM users_test WHERE uid = :uid", ['uid' => $userId])[0];
    //     return $data;
    // }
    // public static function SpecificUser()
    // {
    //     $data = parent::query("SELECT uid FROM users_test WHERE login_count > 0");
    //     $uids = array_column($data, 'uid');
    //     return $uids;
    // }
  
    public static function InserIntoSms($smsprovider,$sendename)
    {  
          $data = [
            "sms_provider" => $smsprovider,
            "sender_name" => $sendename,
            "date_created" => date("Y-m-d / H:i:s"),
          ];
           $data = parent::insert("sms_config", $data);
          return $data ? "success" : "failed";
    }

    public static function InserIntoSavePreferences($data)
    {  
    $pdo = (new Database())->openLink();

    $sql = "REPLACE INTO sms_preferences (id, deposit, withdraw,gamewon, sms_provider) VALUES (:id,:deposit,:withdraw,:gamewon,:sms_provider)";
        $id = 1;
        $params = [
            ':id' => $id,
            ':deposit'  => isset($data['deposit']) && $data['deposit'] ? 1 : 0,
            ':withdraw' => isset($data['withdraw']) && $data['withdraw'] ? 1 : 0,
            ':gamewon'  => isset($data['gamewon']) && $data['gamewon'] ? 1 : 0,
            ':sms_provider' => $data['provider'] ?? null
        ];
        $data = parent::query($sql, $params);
        return $data ? "failed" : "success";
    }

     public static function SaveStateSmsSettings()
    {  
        $sql = "SELECT deposit, withdraw,gamewon,sms_provider FROM sms_preferences WHERE id = 1";  
        $data = parent::query($sql);
        return $data;
    }

    public static function getActiveProvider($provider){
     
         $sql = match($provider){
            "deposit" => "SELECT sms_provider FROM sms_preferences WHERE status = 'active' AND deposit = 1",
            "withdrawal" => "SELECT sms_provider FROM sms_preferences WHERE status = 'active'  AND withdraw = 1",
            "otp" => "SELECT sms_provider FROM sms_preferences WHERE status = 'active'  AND otp = 1",
            "gamewon" => "SELECT sms_provider FROM sms_preferences WHERE status = 'active'  AND gamewon = 1",
          };
          $results = parent::query($sql);

        if (!empty($results)) {
         return $results[0]['sms_provider'] ?? null;
        }
         return 'default'; 
    }


    public static function smsOptionToUse($provider,$message,$contact) {  
        if ($provider === 'smsonlinegh') {
        (new SmsProvider($provider))->sendSmsGonline($message,$contact);
        } elseif ($provider === 'Twilio') {
            SmsProvider::sendSmsTwilio($message,$contact);
        } else {
            return "No valid active SMS provider found.";
        }
    }


    public static function DeleteAnnoucement($messageid)
    {
        $params = ['messageid' => $messageid]; // Correct parameter key
        $data = parent::query("DELETE FROM notices WHERE msg_id = :messageid", $params);
        $data = parent::query("DELETE FROM notice_users WHERE msg_id = :messageid", $params);
        return $data ? "Message could not be deleted. Please try again." : "Message deleted successfully.";
    }

    public static function Messagesubquery($username, $messagetype, $startdate, $enddate)
    {
        $filterConditions = [];

        if (!empty($username)) {
            $filterConditions[] = "audience= '$username'";
        }

        if (!empty($messagetype)) {
            $filterConditions[] = "ms_type = '$messagetype'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "DATE(created_at) BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "DATE(created_at) = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "DATE(created_at) = '$enddate'";
        }

        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
      //  $subQuery .= "ORDER BY created_at DESC";

        return $subQuery;
    }

    public static function FilterMessageData($subquery, $page, $limit)
    {
        try {
            $startpoint = ($page - 1) * $limit;
            $sql = " SELECT *  FROM notices WHERE $subquery LIMIT :offset, :limit";
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

            $countSql1 = "SELECT COUNT(*) AS total_results FROM notices WHERE $subquery";

            // Execute the count query
            $totalRecords = parent::query($countSql1);
            $totalRecords = $totalRecords[0]['total_results'];

            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        }
    }

    public static function EditMessageData($mgid)
    {
        $sql = "SELECT msg_id,subject,message FROM notices WHERE msg_id = :mgid";
        $data = parent::query($sql, ['mgid' => $mgid]);
        return $data;
    }

    public static function UpdateSms($initialTotal,$used,$currentBalance,$sms_provider)
    {
        $sql = "UPDATE sms_config SET total_sms =:total_sms, sms_used=:sms_used,current_sms=:current_sms  WHERE sms_provider = :sms_provider";
        $data = parent::query($sql, ['total_sms' => $initialTotal, 'sms_used' => $used,'current_sms' =>$currentBalance, 'sms_provider' => $sms_provider]);
        return $data ? "Message could not be updated. Please try again." : "Message updated successfully.";
    }


    ///Notification data
    public static function FetchNotification($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
    
        $query =
         "SELECT nu.msg_id, nu.username, nu.read_status, n.subject, n.message, n.created_at,n.timezone 
            FROM notice_users AS nu
            JOIN notices AS n ON nu.msg_id = n.msg_id
            ORDER BY nu.msg_id DESC
            LIMIT :offset, :limit ";
    
        $data = parent::query($query, ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('notice_users');
    
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function Notifyssubquery($username, $messagetype, $startdate, $enddate)
    {
        $filterConditions = [];
        $subQuery = "";
        if (!empty($username)) {
            $filterConditions[] = "notice_users.username = '$username'";
        }

        if (!empty($messagetype)) {
            $filterConditions[] = "notice_users.read_status= '$messagetype'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "DATE(notice_users.created_at) BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "DATE(notice_users.created_at) = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "DATE(notice_users.created_at) = '$enddate'";
        }

        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
       // $subQuery .= "ORDER BY notice_users.created_at DESC";

        return $subQuery;
    }

    public static function FilterNotifysData($subquery, $page, $limit)
    {
        try {
             $startpoint = ($page - 1) * $limit;
             $sql = "
                SELECT 
                notice_users.*, 
                notices.message,
                notices.subject
            FROM notice_users
            LEFT JOIN notices ON notices.msg_id = notice_users.msg_id
            WHERE $subquery
            LIMIT :offset, :limit
            ";
        
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
 
            $countSql1 = "SELECT COUNT(*) AS total_results FROM notice_users WHERE $subquery"; 

            // Execute the count query
            $totalRecords = parent::query($countSql1);
            $totalRecords = $totalRecords[0]['total_results'];

            return ['data' => $data , 'total' => $totalRecords];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        }
    }

    
}

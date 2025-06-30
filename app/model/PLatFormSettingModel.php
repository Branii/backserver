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

    public static function InserIntoSms($smsprovider,$sendename)
    {  
          $data = [
            "sms_provider" => $smsprovider,
            "sender_name" => $sendename,
            "created_at" => date("Y-m-d / H:i:s"),
          ];
           $data = parent::insert("sms_config", $data);
          return $data ? "success" : "failed";
    }

    public static function InserIntoSavePreferences($data)
    {  

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
        } elseif ($provider === 'smsarkesel') {
         (new SmsProvider($provider))->sendArkeselSMS($message,$contact);
        } else {
            return "No valid active SMS provider found.";
        }
    }
    public static function FetchSmsProviders()
    {  
        $sql = "SELECT sms_id,sms_provider FROM sms_config";  
        $data = parent::query($sql);
        return $data;
    }

    public static function DeleteSms($smsid)
    {
        $params = ['sms_id' => $smsid]; // Correct parameter key
        $data = parent::query("DELETE FROM sms_config WHERE sms_id = :sms_id", $params);
        return $data ? "Data could not be deleted. Please try again." : "Data deleted successfully.";
    }

    public static function Smssubquery($smsprovider,$smsstatus,$startdate,$enddate)
    {
        $filterConditions = [];

        if (!empty($smsprovider)) {
            $filterConditions[] = "sms_provider= '$smsprovider'";
        }

        if (!empty($smsstatus)) {
            $filterConditions[] = "status = '$smsstatus'";
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

    public static function FilterSmsData($subquery, $page, $limit)
    {
        try {
            $startpoint = ($page - 1) * $limit;
            $sql = " SELECT *  FROM sms_config WHERE $subquery LIMIT :offset, :limit";
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

            $countSql1 = "SELECT COUNT(*) AS total_results FROM sms_config WHERE $subquery";
            $totalRecords = parent::query($countSql1);

            $totalRecords = $totalRecords[0]['total_results'];
            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        }
    }


    //Email codes

    public static function fetchEmailData($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $data = parent::query("SELECT * FROM email_config ORDER BY email_id DESC LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('email_config');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function InserIntoEmail($emaiprovider,$sendename)
    {  
          $data = [
            "email_provider" => $emaiprovider,
            "sender_name" => $sendename,
            "created_at" => date("Y-m-d / H:i:s"),
          ];
           $data = parent::insert("email_config", $data);
          return $data ? "success" : "failed";
    }
     public static function FetchEmailProviders()
    {  
        $sql = "SELECT email_id,email_provider FROM email_config";  
        $data = parent::query($sql);
        return $data;
    }

    public static function InserEmailSavePreferences($data)
    {  

     $sql = "REPLACE INTO email_preferences (id, deposit, withdraw,gamewon, email_provider) VALUES (:id,:deposit,:withdraw,:gamewon,:email_provider)";
        $id = 1;
        $params = [
            ':id' => $id,
            ':deposit'  => isset($data['deposit']) && $data['deposit'] ? 1 : 0,
            ':withdraw' => isset($data['withdraw']) && $data['withdraw'] ? 1 : 0,
            ':gamewon'  => isset($data['gamewon']) && $data['gamewon'] ? 1 : 0,
            ':email_provider' => $data['provider'] ?? null
        ];
        $data = parent::query($sql, $params);
        return $data ? "failed" : "success";
    }

    public static function SaveStateEmailSettings()
    {  
        $sql = "SELECT deposit, withdraw,gamewon,email_provider FROM email_preferences WHERE id = 1";  
        $data = parent::query($sql);
        return $data;
    }

    public static function DeleteEmail($emailid)
    {
        $params = ['email_id' => $emailid]; // Correct parameter key
        $data = parent::query("DELETE FROM email_config WHERE email_id = :email_id", $params);
        return $data ? "Data could not be deleted. Please try again." : "Data deleted successfully.";
    }

       public static function Emailsubquery($emailprovider,$emailstatus,$startdate,$enddate)
    {
        $filterConditions = [];

        if (!empty($emailprovider)) {
            $filterConditions[] = "email_provider= '$emailprovider'";
        }

        if (!empty($emailstatus)) {
            $filterConditions[] = "status = '$emailstatus'";
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

    public static function FilterEmailData($subquery, $page, $limit)
    {
        try {
            $startpoint = ($page - 1) * $limit;
            $sql = " SELECT *  FROM email_config WHERE $subquery LIMIT :offset, :limit";
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

            $countSql1 = "SELECT COUNT(*) AS total_results FROM email_config WHERE $subquery";
            $totalRecords = parent::query($countSql1);

            $totalRecords = $totalRecords[0]['total_results'];
            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        }
    }
    
    public static function getEmailBalance($provider)
    {
        $sql = "SELECT current_emails,email_used FROM email_config WHERE email_provider = :email_provider";
        $data = parent::query($sql, ['email_provider' => $provider])[0];
        return $data;
    }


      public static function UpdateEmail($initialTotal,$used,$currentBalance,$sms_provider)
    {
        $sql = "UPDATE email_config SET total_emails =:total_emails, email_used=:email_used,current_emails=:current_emails  WHERE email_provider = :email_provider";
        $data = parent::query($sql, ['total_emails' => $initialTotal, 'email_used' => $used,'current_emails'=>$currentBalance, 'email_provider' => $sms_provider]);
        return $data ? "Message could not be updated. Please try again." : "Message updated successfully.";
    }
    public static function UpdateSms($initialTotal,$used,$currentBalance,$sms_provider)
    {
        $sql = "UPDATE sms_config SET total_sms =:total_sms, sms_used=:sms_used,current_sms=:current_sms  WHERE sms_provider = :sms_provider";
        $data = parent::query($sql, ['total_sms' => $initialTotal, 'sms_used' => $used,'current_sms' =>$currentBalance, 'sms_provider' => $sms_provider]);
        return $data ? "Message could not be updated. Please try again." : "Message updated successfully.";
    }


    // ///Notification data
    // public static function FetchNotification($page, $limit): array
    // {
    //     $startpoint = $page * $limit - $limit;
    
    //     $query =
    //      "SELECT nu.msg_id, nu.username, nu.read_status, n.subject, n.message, n.created_at,n.timezone 
    //         FROM notice_users AS nu
    //         JOIN notices AS n ON nu.msg_id = n.msg_id
    //         ORDER BY nu.msg_id DESC
    //         LIMIT :offset, :limit ";
    
    //     $data = parent::query($query, ['offset' => $startpoint, 'limit' => $limit]);
    //     $totalRecords = parent::count('notice_users');
    
    //     return ['data' => $data, 'total' => $totalRecords];
    // }

    // public static function Notifyssubquery($username, $messagetype, $startdate, $enddate)
    // {
    //     $filterConditions = [];
    //     $subQuery = "";
    //     if (!empty($username)) {
    //         $filterConditions[] = "notice_users.username = '$username'";
    //     }

    //     if (!empty($messagetype)) {
    //         $filterConditions[] = "notice_users.read_status= '$messagetype'";
    //     }

    //     if (!empty($startdate) && !empty($enddate)) {
    //         $filterConditions[] = "DATE(notice_users.created_at) BETWEEN '$startdate' AND '$enddate'";
    //     } elseif (!empty($startdate)) {
    //         $filterConditions[] = "DATE(notice_users.created_at) = '$startdate'";
    //     } elseif (!empty($enddate)) {
    //         $filterConditions[] = "DATE(notice_users.created_at) = '$enddate'";
    //     }

    //     if (!empty($filterConditions)) {
    //         $subQuery = implode(' AND ', $filterConditions);
    //     }
    //     // Add ordering and limit to the query
    //    // $subQuery .= "ORDER BY notice_users.created_at DESC";

    //     return $subQuery;
    // }

    // public static function FilterNotifysData($subquery, $page, $limit)
    // {
    //     try {
    //          $startpoint = ($page - 1) * $limit;
    //          $sql = "
    //             SELECT 
    //             notice_users.*, 
    //             notices.message,
    //             notices.subject
    //         FROM notice_users
    //         LEFT JOIN notices ON notices.msg_id = notice_users.msg_id
    //         WHERE $subquery
    //         LIMIT :offset, :limit
    //         ";
        
    //         $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
 
    //         $countSql1 = "SELECT COUNT(*) AS total_results FROM notice_users WHERE $subquery"; 

    //         // Execute the count query
    //         $totalRecords = parent::query($countSql1);
    //         $totalRecords = $totalRecords[0]['total_results'];

    //         return ['data' => $data , 'total' => $totalRecords];
    //     } catch (Exception $e) {
    //         // Log the error message for debugging purposes
    //         error_log("Error executing query: " . $e->getMessage());
    //     }
    // }

    
}

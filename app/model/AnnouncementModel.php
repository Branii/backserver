<?php

class AnnouncementModel extends MEDOOHelper
{
    // $query = "SELECT u.*, p.profile_info
    // FROM users u
    // JOIN user_profiles p ON u.uid = p.uid
    // WHERE u.uid IN ($uidList)";

    public static function FetchAnnoucement($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $data = parent::query("SELECT * FROM notices ORDER BY msg_id DESC LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('notices');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function GeneralMessage($title, $content, $sendby, $messagetype, $targetUser, $uid)
    {
        $dates = date('Y:m:d');
        $status = "Active";

        if (!is_array($uid)) {
            $uid = [$uid]; // Convert single ID to an array
        }
        //    if ($messagetype == "general") {
        // $totalRecords = parent::count('users_test');

        // } else {
        //     $totalRecords = 1;
        // }
        // $uidsJson = is_array($uid) ? json_encode($uid) : $uid;
        // $uidsJson = json_encode($uid);
        $params = [
            'subject' => $title,
            'message' => $content,
            'send_by' => $sendby,
            'created_at' => date("Y-m-d / H:i:s"),
            'ms_status' => $status,
            'ms_type' => $messagetype,
            'audience' => $targetUser,
            'uid' => $uid,
            // 'ms_count' =>$totalRecords
        ];
        $insertData = parent::insert("notices", $params);
        if ($insertData) {
            $msg_id = parent::query("SELECT ms_type,msg_id FROM notices ORDER BY msg_id DESC LIMIT 1")[0];
            if ($msg_id['ms_type'] == "general") {
                return "Message sent successfully.";
            }
            if (!empty($uid)) {
                self::createNotice($msg_id['msg_id'], $uid);
            }
            return "Message sent successfully.";
        } else {
            return "Message could not be sent. Please try again.";
        }
    }
    public static function getUsernameById(mixed $userId)
    {
        $data = parent::query("SELECT username,email,contact,reg_type,uid FROM users_test WHERE uid = :uid", ['uid' => $userId])[0];
        return $data;
    }
    public static function SpecificUser()
    {
        $data = parent::query("SELECT uid FROM users_test WHERE login_count > 0");
        $uids = array_column($data, 'uid');
        return $uids;
    }
    public static function NewlyRegisteredUsers($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $data = parent::query("SELECT uid FROM users_test WHERE DATE(created_at) BETWEEN :startDate AND :endDate", 
                ['startDate' => $startDate, 'endDate' => $endDate]);
            $uids = array_column($data, 'uid');
            return $uids;
        } else {
           return "Please select a valid date range";
        }
    }
    
    public static function createNotice($msg_id, $userIds = [])
    {
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        $userIdList = implode(',', $userIds);

        $result = parent::query("SELECT username, email, contact, reg_type, uid FROM users_test WHERE uid IN ($userIdList)");

        $userData = [];
        foreach ($result as $data) {
            // Determine the correct username based on reg_type
            if ($data['reg_type'] == 'username') {
                $username = $data['username'];
            } elseif ($data['reg_type'] == 'contact') {
                $username = $data['contact'];
            } else {
                $username = $data['email'];
            }

            $id = $data['uid'];
            $currentDateTime = date('Y-m-d / H:i:s'); 
            // Make sure username is properly quoted and add current date
            $userData[] = "($msg_id, $id, '" . $username . "', '$currentDateTime')";
        }

        // Ensure there are values to insert
        if (!empty($userData)) {
            $values = implode(',', $userData);
            $insertData = parent::query("INSERT INTO notice_users (msg_id, user_id, username,created_at) VALUES $values");
            return $insertData ? "Message sent successfully." : "Message could not be sent. Please try again.";
        } else {
            return "No valid users found.";
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
        $subQuery .= "ORDER BY created_at DESC";

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
        // $params = ['mgid' => $mgid];
        $sql = "SELECT msg_id,subject,message FROM notices WHERE msg_id = :mgid";
        $data = parent::query($sql, ['mgid' => $mgid]);
        return $data;
    }

    public static function UpdateMessageData($msgtilte, $msgcontent, $mgid)
    {
        // $params = ['mgid' => $mgid];
        $sql = "UPDATE notices SET subject =:title, message=:content  WHERE msg_id = :mgid";
        $data = parent::query($sql, ['title' => $msgtilte, 'content' => $msgcontent, 'mgid' => $mgid]);
        return $data ? "Message could not be updated. Please try again." : "Message updated successfully.";
    }


    ///Notification data
    public static function FetchNotification($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
    
        $query =
         "SELECT nu.msg_id, nu.username, nu.read_status, n.subject, n.message, n.created_at
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

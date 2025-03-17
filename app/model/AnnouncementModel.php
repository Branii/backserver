<?php

class AnnouncementModel extends MEDOOHelper
{



    public static function FetchAnnoucement($page, $limit): array
    {
       $startpoint = $page * $limit - $limit;
       $data = parent::query(
          "SELECT * FROM notices ORDER BY msg_id DESC LIMIT :offset, :limit",
          ['offset' => $startpoint, 'limit' => $limit]
       );
       $totalRecords = parent::count('notices');
       return ['data' => $data, 'total' => $totalRecords,];
    }

    public static function GeneralMessage($title ,$content,$sendby,$messagetype,$targetUser,$usernames) {
       $dates = date('Y:m:d');
       $status = "Active";
      // $status = "Active";
        $params = [
            'title' =>$title,
            'content' =>$content,
            'send_by' => $sendby,
            'created_at'=>  date("Y-m-d / H:i:s"),
            'status' =>$status,
            'type'=> $messagetype,
            'audience' =>$targetUser,
            'uid' =>$usernames
        ];
         $insertData = parent::insert("notices", $params);
         if ($insertData) {
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
 
    public static function DeleteAnnoucement($messageid)
    {
 
      $params = ['messageid' => $messageid]; // Correct parameter key
      $data = parent::query("DELETE FROM notices WHERE msg_id = :messageid", $params);
      return $data ? "Message could not be deleted. Please try again." : "Message deleted successfully.";
       
    }

    public static function Messagesubquery($username,$messagetype,$startdate,$enddate)
    {

        $filterConditions = [];

        if (!empty($username)) {
            $filterConditions[] = "audience= '$username'";
        }

        if (!empty($messagetype)) {
            $filterConditions[] = "type = '$messagetype'";
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
       // $subQuery .= "ORDER BY created_at DESC";

        return $subQuery;
    }


   
    public static function FilterMessageData($subquery, $page, $limit)
    {
        try {
            // Calculate the starting point for pagination
            $startpoint = ($page - 1) * $limit;
       
            $sql = " SELECT *  FROM notices WHERE $subquery LIMIT :offset, :limit";
        
            // SQL query for counting total records
            $countSql1 = "
                SELECT 
                    COUNT(*) AS total_results
                FROM 
                    notices
                WHERE $subquery
            ";
        
            // Prepare and execute the main query with parameterized inputs
            $data = parent::query($sql, [ 'offset' => $startpoint, 'limit' => $limit ]);
        
            // Execute the count query
            $totalRecords = parent::query($countSql1);
            $totalRecords = $totalRecords[0]['total_results'];
        
            // Return the data and total record count
            return [
                'data' => $data,
                'total' => $totalRecords
            ];
        
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        
            // Optionally, return an empty set or error response
            return [
                'data' => [],
                'total' => 0,
                'error' => "Error executing query: " . $e->getMessage()
            ];
        }
    }

}

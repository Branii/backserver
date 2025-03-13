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
 
  

}

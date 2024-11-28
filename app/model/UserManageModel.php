<?php

class UserManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// USERLIST LIST -//////////

    public static function FetchUserlistData($page, $limit): array
    {

        $startpoint = ($page * $limit) - $limit; 
        $data = parent::query( 
            "SELECT uid, username, nickname, agent_username, balance, recharge_level, state, 
            last_login_time, rebate, date_created, agent  FROM users ORDER BY uid DESC  LIMIT :startpoint, :limit", 
            ['startpoint' => (int)$startpoint, 'limit' => (int)$limit] 
        ); 
          $totalRecords  = parent::count('users');
        return ['data' => $data, 'total' => $totalRecords];
         
    }
    public static function countUserLogs($uid)
    {
        $logCount = parent::count("user_logs", '*', ["uid" => $uid]);
        return $logCount ?: null;
    }

    public static function getDirectReferrals($uid)
    {
        $total = parent::count("users", "*", ["agent" => $uid]);
        return $total > 2 ? '...' : '->';
    }
    public static function getSubordinate($agent)
    {
        
        return  $data = parent::query("SELECT username FROM users WHERE agent = :agent", ['agent' => $agent]); 
    }

    public static function Fetchsubordinates($uid)
    {
        $totalCount = parent::count("users", "*", ["AND" => ["agent" => $uid, "account_type" => 3, "uid[!]" => $uid]]);
        return $totalCount;
    }

    public static function Filteruserlist($page, $limit, $username, $states, $startdate, $enddate)
    {
        $whereConditions = self::FilterUserlistDataSubQuery($username, $states, $startdate, $enddate);
        $startpoint = ($page * $limit) - $limit;
        $data = parent::selectAll("users", '*', ["AND" => $whereConditions, "ORDER" => ["users.uid" => "DESC"], "LIMIT" => [$startpoint, $limit]]);
        $lastQuery = MedooOrm::openLink()->log();
        $totalRecords  = parent::selectAll('users', '*', ['AND' => $whereConditions]);
        return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];
    }

    public static function FilterUserlistDataSubQuery($username = '', $states = '', $from = '', $to = '')
    {
        $conditions = [];

        if (!empty($username) && $username != 'all') {
            $conditions['users.uid'] = $username;
        }

        if (!empty($states) && $states != 'all') {
            $conditions['users.state'] = $states;
        }

        if ($from != '' && $to != '') {
            $conditions['users.date_created[<>]'] = [$from, $to];
        } elseif ($from != '') {
            $conditions['users.date_created[>=]'] = $from;
        } elseif ($to != '') {
            $conditions['users.date_created[<=]'] = $to;
        }

        return $conditions;
    }

    public static function AddAgentData($datas)
    {

        try {
        
            $inserAgentdata = parent::insert("users", $datas);
            if ($inserAgentdata) {

                self::UpdateAgentTable($datas);
                return "Success";
            }else {
                return "Failed";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function FetchTopAgentData($page, $limit): array
    {
         
        $startpoint = ($page * $limit) - $limit;
        $data = parent::selectAll(
            "users",
            ["uid","username", "nickname","agent_username","balance","recharge_level","state",
            "last_login_time","rebate","date_created","agent"],
            [  "account_type" => 2, "ORDER" => ["uid" => "DESC"], "LIMIT" => [$startpoint, $limit]]
        );
        $totalRecords = parent::count("users");
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function checkEmailExist($datas)
    {
        return  $agentemail = parent::selectAll("users", ["user_email","uid"], ["user_email" => $datas]);
    }

    public static function UpdateAgentTable($userData)
    {
        
        $dates  = new DateTime();
        $date   = $dates->format('Y-m-d');
        $time   = $dates->format("H:i:s");
        $agent  =  self::checkEmailExist($userData['user_email'])[0];
        $agentid =$agent['uid'] ;
        $data = [
            "agent_id" => $agentid,
            "agent_name" => $userData["username"],
            "agent_email" => $userData["user_email"],
            "agent_rebate" =>  $userData["rebate"],
            "date_created" =>  $date,
            "time_created" => $time,
        ];
        return $Agentdata = parent::insert("agents", $data);
        
    }

    public static function validateRegister($datas)
    {

        $errors = [];
        $emailexist = self::checkEmailExist($datas['agentemail']);
        $password = trim($datas['agentpassword'] ?? '');
        $confirmPassword = trim($datas['agentpassword1'] ?? '');
        $email = trim($datas['agentemail'] ?? '');
        $username = trim($datas['agentname'] ?? '');


        //email exit    
        if ($emailexist) {
            $errors['emailexist'] = "Email already exists";
        }
        // Password validation
        if (empty($password)) {
            $errors['passwordRequired'] = "Password is required";
        } elseif (strlen($password) < 8) {
            $errors['passwordLength'] = "Password must be at least 8 characters";
        }

        // Confirm password validation
        if ($password !== $confirmPassword) {
            $errors['confirmPassword'] = "Password doesn't match";
        }

        if (!preg_match('/^(?=.*[~`!@#$%^&*()\-+={}[\]|\\:;"\'<>,.?\/₹]).*$/', $password)) {
            $errors['passwordSpecialChar'] = "Password must contain at least one special symbol";
        }

        // Case sensitivity validation (uppercase and lowercase)
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z]).*$/', $password)) {
            $errors['passwordCaseSensitive'] = "Password must contain at least one uppercase and lowercase letter";
        }

        // Must contain at least one number
        if (!preg_match('/^(?=.*[0-9]).*$/', $password)) {
            $errors['passwordNumber'] = "Password must contain at least one number";
        }

        // Email validation
        if (empty($email)) {
            $errors['email'] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email address is invalid";
        }

        // Username validation
        if (empty($username)) {
            $errors['username'] = "Username is required";
        } elseif (strlen($username) < 5) {
            $errors['username'] = "Username must be at least 5 characters";
        }

        // Username pattern validation (corrected pattern)
        if (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/', $username)) {
            $errors['usernamePattern'] = "Username must contain only letters, numbers, and underscores, and must start with a letter";
        }

        return $errors;
    }

    public static function FetchRebateData()
    {
        return  $res = parent::selectAll("rebate", ["rebate"], ["ORDER" => ["rebate_id" => "ASC"]]);
    }

    public static function fetchquotaData($userrebate)
    {

        $data = parent::selectAll("rebate", ["odds_group", "rebate", "quota", "counts"], ["rebate[<=]" => $userrebate]);
        return $serializedData = json_encode($data);
    }



    ////////////// USERLIST LIST END -//////////
    //NOTE -
    ////////////// USERLIST LOGS -//////////
    public static function FetchUserlogsData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT user_logs.*, COALESCE(users.username, 'N/A') AS username FROM user_logs   
            JOIN users ON users.uid = user_logs.uid  ORDER BY ulog_id DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );
        $totalRecords  = parent::count('user_logs');
        return ['data' => $data, 'total' => $totalRecords];
    }
  

    public static function Filteruserlogs($page, $limit, $username, $startdate, $enddate)
    {
        $whereConditions = self::FilterUserlogsDataSubQuery($username,  $startdate, $enddate);
        $startpoint = ($page * $limit) - $limit;
        $data = parent::selectAll("user_logs", '*', ["AND" => $whereConditions, "ORDER" => ["ulog_id" => "DESC"], "LIMIT" => [$startpoint, $limit]]);
        $lastQuery = MedooOrm::openLink()->log();
        $totalRecords  = parent::selectAll('user_logs', '*', ['AND' => $whereConditions]);
        return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];
    }

    public static function FilterUserlogsDataSubQuery($username = '', $from = '', $to = '')
    {
        $conditions = [];

        if (!empty($username) && $username != 'all') {
            $conditions['user_logs.uid'] = $username;
        }

        // if (!empty($states) && $states != 'all') {
        //     $conditions['users.state'] = $states;
        // }

        if ($from != '' && $to != '') {
            $conditions['user_logs.date_created[<>]'] = [$from, $to];
        } elseif ($from != '') {
            $conditions['user_logs.date_created[>=]'] = $from;
        } elseif ($to != '') {
            $conditions['user_logs.date_created[<=]'] = $to;
        }

        return $conditions;
    }

    public static function fetchUserRebateList($uid)
    {
        $rebatelist = parent::selectOne("users","rebate_list", ["uid"=>$uid]);
        return json_decode($rebatelist);
        
    }

}

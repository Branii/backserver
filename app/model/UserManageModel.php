<?php

class UserManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// USERLIST LIST -//////////

    public static function FetchUserlistData($page, $limit): array
    {

        $startpoint = ($page - 1) * $limit;
        $data = parent::query(
            "SELECT uid, username,email,contact,nickname, agent_name, balance, recharge_level, user_state,reg_type,agent_level,
                  rebate, created_at, agent_id, account_type
             FROM users_test
             ORDER BY uid DESC
             LIMIT :startpoint, :limit",
            [
                'startpoint' => (int)$startpoint,
                'limit' => (int)$limit
            ]
        );

        $totalRecords = parent::count('users_test');

        return ['data' => $data, 'total' => $totalRecords];
    }
    public static function countUserLogs($uid)
    {
        $logCount = parent::count("user_logs", '*', ["uid" => $uid]);
        return $logCount ?: null;
    }

    public static function getDirectReferrals($agent_id)
    {
        $total = parent::count("users_test", "*", ["agent_id" => $agent_id]);
        return $total > 2 ? '...' : '->';
    }
    public static function getSubordinate($agent_id)
    {

        return  $data = parent::query("SELECT nickname FROM users_test WHERE agent_id = :agent_id", ['agent_id' => $agent_id]);
    }

    public static function getUserIdByMixedValued(array $mixedValue)
    {
        if (empty($mixedValue)) {
            return []; // Return an empty array if input is empty
        }
    
        try {
            $placeholders = implode(',', array_fill(0, count($mixedValue), '?'));
            $pdo = (new Database())->openLink();
    
            $stmt = $pdo->prepare("SELECT nickname FROM users_test WHERE uid IN ($placeholders)");
            $stmt->execute($mixedValue);
    
            // Fetch all nicknames as an indexed array
            $subordinates = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $subordinates;
    
        } catch (PDOException $e) {
            // Log or handle the error as needed
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public static function Fetchsubordinates($uid)
    {
        $totalCount = parent::count("users_test", "*", ["AND" => ["agent_id" => $uid, "account_type" => 3, "uid[!]" => $uid]]);
        return $totalCount;
    }

    public static function Filteruserlist($subQuery,$page, $limit)
    {
        
         $startpoint = ($page - 1) * $limit;
 
          $sql = "SELECT uid, username,email,contact,nickname, agent_name, balance, recharge_level, user_state,reg_type,
                  rebate, created_at, agent_id, account_type,reg_type
             FROM users_test WHERE  $subQuery ";
            
        $countSql = "
                SELECT 
                    COUNT(*) AS total_count
                FROM 
                    users_test
            WHERE
                $subQuery
                ";

        $data = parent::query($sql);
        $totalRecords = parent::query($countSql);
        $totalRecords = $totalRecords[0]['total_count'];
        $lastQuery = MedooOrm::openLink()->log();
        return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
        
    }

    public static function FilterUserlistDataSubQuery($username,$states, $startdate, $enddate)
    {
        $filterConditions = [];

        // Build filter conditions
        if (!empty($username)) {
            $filterConditions[] = "uid = '$username'";
        }
       
        if (!empty($states)) {
            $filterConditions[] = "user_state = '$states'";
        }

        
        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "created_at BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "created_at = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "created_at = '$enddate'";
        }

        // Combine conditions into the final query
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }

        // Add ordering and limit to the query (you can also parameterize order if needed)
        $subQuery .= " ORDER BY created_at DESC";

        // Return the final subquery
        return $subQuery;
    }

    public static function AddAgentData($datas)
    {

        try {

            $inserAgentdata = parent::insert("users_test", $datas);
            if ($inserAgentdata) {
                self::UpdateAgentTable($datas);
                return "Success";
            } else {
                return "Failed";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function FetchTopAgentData($page, $limit): array
    {
        // Calculate the starting point for pagination
        $startpoint = ($page * $limit) - $limit;
        $sql = "
        SELECT 
            uid, username,email,contact, agent_name, balance, recharge_level, user_state, 
            last_login, rebate, created_at, agent_id,account_type,reg_type,nickname  
        FROM users_test
        WHERE account_type = 2
        ORDER BY uid DESC
        LIMIT :startpoint, :limit
      ";

      $data = parent::query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
        // Count the total records with the same filter (for pagination)
        $totalRecords = parent::count("users_test");

        // Return the paginated data along with the total record count
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function checkEmailExist($datas)
    {
        return  $agentemail = parent::selectAll("users_test", ["email", "uid"], ["email" => $datas]);
    }

    public static function UpdateAgentTable($userData)
    {

        $dates  = new DateTime();
        $date   = $dates->format('Y-m-d');
        $time   = $dates->format("H:i:s");
        $agent  =  self::checkEmailExist($userData['email'])[0];
        $agentid = $agent['uid'];
        $data = [
            "agent_id" => $agentid,
            "agent_name" => $userData["username"],
            "agent_email" => $userData["email"],
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

        $data = parent::query("SELECT odds_group, rebate, quota, counts FROM rebate WHERE rebate <= :rebate", ['rebate' => $userrebate]);
        return $serializedData = json_encode($data);
    }

    public static   function generateRandomNickname()
    {
        // List of random words to pick from
        $adjectives = ['Swift', 'Bold', 'Clever', 'Brave', 'Mighty', 'Fierce', 'Silent', 'Electric', 'Lucky', 'Shiny'];
        $animals = ['Tiger', 'Eagle', 'Wolf', 'Dragon', 'Panther', 'Fox', 'Bear', 'Shark', 'Lion', 'Falcon'];

        $randomAdjective = $adjectives[array_rand($adjectives)];
        $randomAnimal = $animals[array_rand($animals)];
        $randomNumber = rand(100, 999); // Generates a random number between 100 and 999

        $nickname = $randomAdjective . $randomAnimal . $randomNumber;

        return $nickname;
    }

    ////////////// USERLIST LIST END -//////////
    //NOTE -

    ////////////// USERLIST LOGS -//////////
    public static function FetchUserlogsData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $sql = "
        SELECT 
            user_logs.*, 
            users_test.email, users_test.contact, users_test.reg_type ,
            COALESCE(users_test.username, 'N/A') AS username 
        FROM user_logs   
        LEFT JOIN users_test ON users_test.uid = user_logs.uid  
        ORDER BY user_logs.ulog_id DESC 
        LIMIT :startpoint, :limit
    ";
    
    // Execute the query with pagination parameters
      $data = parent::query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
        $totalRecords  = parent::count('user_logs');
        return ['data' => $data, 'total' => $totalRecords];
    }


    public static function Filteruserlogs($subQuery, $page, $limit)
    {
        $startpoint = $page * $limit - $limit;
        $sql = "
        SELECT 
            temp_table.*, 
            users_test.email AS email,
            users_test.username AS username,
            users_test.contact AS contact,users_test.reg_type AS reg_type    
        FROM 
            (
                SELECT * 
                FROM user_logs
                WHERE $subQuery
            ) AS temp_table
        LEFT JOIN 
            users_test ON users_test.uid = temp_table.uid
         LIMIT :offset, :limit
       
        ";

        $countSql = "
                SELECT 
                    COUNT(*) AS total_count
                FROM 
                    user_logs
            WHERE
                $subQuery
                ";

        $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::query($countSql);
        $totalRecords = $totalRecords[0]['total_count'];
        $lastQuery = MedooOrm::openLink()->log();
        return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
    }

    public static function FilterUserlogsDataSubQuery($username,$startdate,$enddate)
    {
   
        $filterConditions = [];

        // Build filter conditions
        if (!empty($username)) {
            $filterConditions[] = "uid = '$username'";
        }

        
        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "login_date BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "login_date = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "login_date = '$enddate'";
        }

        // Combine conditions into the final query
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }

        // Add ordering and limit to the query (you can also parameterize order if needed)
        $subQuery .= " ORDER BY login_date DESC";

        // Return the final subquery
        return $subQuery;
    
    }

    public static function fetchUserRebateList($uid)
    {
        $rebatelist = parent::selectOne("users_test", "*", ["uid" => $uid])['rebate_list'];
        return json_decode($rebatelist);
    }
}

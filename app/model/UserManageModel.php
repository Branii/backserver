<?php

class UserManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// USERLIST LIST -//////////

    public static function FetchUserlistData($page, $limit): array
    {

        $startpoint = ($page - 1) * $limit;
        $data = parent::query(
            "SELECT uid, username,email,contact,nickname, agent_name, balance, recharge_level, user_state,reg_type,
                  rebate, created_at, agent_id, account_type,reg_type
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
    public static function countUserLogs($partnerID,$uid)
    {   
        $logCount = parent::openLink($partnerID)->count("user_logs", '*', ["uid" => $uid]);
        // $logCount = parent::count("user_logs", '*', ["uid" => $uid]);
        return $logCount ?: null;
    }

    public static function getDirectReferrals($partnerID,$agent_id)
    {
        $total = parent::getLink($partnerID)->count("users_test", "*", ["agent_id" => $agent_id]);
        return $total > 2 ? '...' : '->';
    }
    public static function getSubordinate($partnerID,$agent_id)
    {
        return $data = parent::openLink($partnerID)->query("SELECT nickname FROM users_test WHERE agent_id = :agent_id", ['agent_id' => $agent_id]);
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

        return  $data = parent::query("SELECT nickname FROM users_test WHERE agent_id = :agent_id", ['agent_id' => $agent_id]);
    }

    public static function Fetchsubordinates($partnerID,$uid)
    {
        $totalCount = parent::openLink($partnerID)->count("users_test", "*", ["AND" => ["agent_id" => $uid, "account_type" => 3, "uid[!]" => $uid]]);
        $totalCount = parent::count("users_test", "*", ["AND" => ["agent_id" => $uid, "account_type" => 3, "uid[!]" => $uid]]);
        return $totalCount;
    }

 
    public static function Filteruserlist($page, $limit, $username, $states, $startdate, $enddate)
    {
        $whereConditions = self::FilterUserlistDataSubQuery($username, $states, $startdate, $enddate);
        $startpoint = ($page * $limit) - $limit;
        $data = parent::selectAll("users", '*', ["AND" => $whereConditions, "ORDER" => ["users.uid" => "DESC"], "LIMIT" => [$startpoint, $limit]]);
        $lastQuery = MedooOrm::openLink()->log();
        $totalRecords = parent::count("users","*",["AND" => $whereConditions]);
        return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
    }

    public static function FilterUserlistDataSubQuery($username, $states, $startdate, $enddate)
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
            $filterConditions[] = " created_at = '$enddate'";
        }

        // Combine conditions into the final query
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }

        $subQuery .= " ORDER BY created_at DESC";
        return $subQuery;
    }

    public static function fetch_user_hierarchy($user_id)
    {
        $db = parent::getLink();
        $sql = "SELECT uid,username,agent_level,account_type FROM users_test  WHERE uid=:user_id";
        $stmt = $db->query($sql, [":user_id" => intval($user_id)]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function fetch_user_rel($user_id): array
    {
        try {
            $db = parent::getLink();

            $agent_level_res = self::fetch_user_hierarchy($user_id);
            if (empty($agent_level_res) || $agent_level_res->agent_level === "*****") {
                return ["status" => "success", "data" => []];
            }
            $unserialized_hierarchy = unserialize($agent_level_res->agent_level);
            $params = [];
            $placeholders = [];
            foreach ($unserialized_hierarchy as $agent_id => $agent_rebate) {
                $place_holder = ":uid{$agent_id}";
                $placeholders[] = $place_holder;
                $params[$place_holder] = $agent_id;
            }
            $sql =
                "SELECT uid, CASE WHEN reg_type = 'email' THEN email WHEN reg_type = 'contact' THEN contact WHEN reg_type = 'username' THEN username END AS username FROM users_test WHERE  uid IN (" .
                implode(',', $placeholders) .
                ") ORDER BY users_test.uid DESC";
            $stmt = $db->query($sql, $params);
            // Fetch the results as an array of objects
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            return ["status" => "success", 'data' => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function fetch_users_login_count(array $user_ids): array
    {
        try {
            $db = parent::openLink();
            $placeholders = [];
            $params = [];
            foreach ($user_ids as $user_id) {
                $placeholders[] = ":uid$user_id";
                $params[":uid$user_id"] = $user_id;
            }
            $sql = "SELECT uid,COUNT(*) as logs_count FROM `user_logs` WHERE uid IN (" . implode(',', $placeholders) . ") GROUP BY uid";
            $stmt = $db->query($sql, $params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data" => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error."];
        }
    }

    public static function count_subs(array $agent_ids): array
    {
        try {
            $db = parent::openLink();
            $placeholders = [];
            $params = [];
            foreach ($agent_ids as $agent_id) {
                $placeholders[] = ":uid$agent_id";
                $params[":uid$agent_id"] = $agent_id;
            }
            $sql = "SELECT agent_id,COUNT(*) as subs_count FROM `users_test` WHERE agent_id IN (" . implode(',', $placeholders) . ") GROUP BY agent_id";
            $stmt = $db->query($sql, $params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data" => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error."];
        }

        // $totalRecords  = parent::selectAll('users', '*', ['AND' => $whereConditions]);
        // return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];

    }

    public static function fetch_agent_nickname(array $agent_ids): array
    {
        try {
            $db = parent::openLink();
            $placeholders = [];
            $params = [];
            foreach ($agent_ids as $key => $agent_id) {
                $placeholders[] = ":uid$key";
                $params[":uid$key"] = $agent_id;
            }
            $sql = "SELECT uid,nickname FROM `users_test` WHERE uid IN (" . implode(',', $placeholders) . ") GROUP BY uid";
            $stmt = $db->query($sql, $params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data" => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function fetchAgentSubs($agent_id, $page = 1, $limit = 20): array
    {
        try {
            $all_subs = DataReportModel::allSubs($agent_id, $page, $limit);
            if (empty($all_subs["data"])) {
                return ["status" => "success", "data" => []];
            }
            $all_subs = $all_subs["data"];

            $uids = array_column($all_subs, 'uid');
            $agent_ids = array_column($all_subs, 'agent_id');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count = self::count_subs($uids);
            $agent_nicknames = self::fetch_agent_nickname($agent_ids);

            return ["status" => "success", "data" => $all_subs, "login_counts" => $login_counts, "direct_subs_count" => $subs_count, "agent_nicknames" => $agent_nicknames];
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "error", 'data' => "Internal Server Error."];
        }
    }

    public static function filter_user($partnerID,array $filters = []): array
    {
        try {
            $database = parent::openLink($partnerID);

            // Add binding parameters
            $params = [":uid" => $filters["uid"]];
            $table_name = "users_test";
            $whereClause = "";

            $startDate = $filters["start_date"];
            $endDate = $filters["end_date"];

            if (!empty($filters["recharge_level"])) {
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = " AND recharge_level=:recharge_level ";
            }
            if (!empty($filters["state"])) {
                $params[":user_state"] = $filters["state"];
                $whereClause .= " AND user_state=:user_state";
            }

            if (!empty($startDate) && empty($endDate)) {
                $whereClause .= "AND created_at = :start_date";
                $params[':start_date'] = $startDate;
            } elseif (empty($startDate) && !empty($endDate)) {
                $whereClause .= "AND created_at = :end_date";
                $params[':end_date'] = $endDate;
            } elseif (!empty($startDate) && !empty($endDate)) {
                $start = min($startDate, $endDate);
                $end = max($startDate, $endDate);
                $whereClause .= " AND created_at BETWEEN :start_date AND :end_date ";
                $params[':start_date'] = $start;
                $params[':end_date'] = $end;
            }

            // Build the query
            $sql = "SELECT *,(SELECT COUNT(*) FROM users_test WHERE {$table_name}.account_type=2) as total_records FROM users_test WHERE {$table_name}.uid=:uid {$whereClause}";

            // Execute query using Medoo's query method
            $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
            return DataReportModel::response($data);
        } catch (Exception $e) {
            return DataReportModel::response("Internal Server Error." . $e->getMessage(), false);
        }
    }

    public static function filter_top_agents(array $filters = [], $page, $limit): array
    {
        try {
            $database = parent::getLink();

            // Pagination setup
            $offset = ($page - 1) * $limit;
            // Add binding parameters
            $params = [':offset' => intval($offset), ':limit' => intval($limit)];
            $table_name = "users_test";
            $whereClause = "";
            $startDate = $filters["start_date"];
            $endDate = $filters["end_date"];

            if (!empty($filters["recharge_level"])) {
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = " AND recharge_level=:recharge_level ";
            }
            if (!empty($filters["state"])) {
                $params[":user_state"] = $filters["state"];
                $whereClause .= " AND user_state=:user_state";
            }

            if (!empty($startDate) && empty($endDate)) {
                $whereClause .= "AND created_at = :start_date";
                $params[':start_date'] = $startDate;
            } elseif (empty($startDate) && !empty($endDate)) {
                $whereClause .= "AND created_at = :end_date";
                $params[':end_date'] = $endDate;
            } elseif (!empty($startDate) && !empty($endDate)) {
                $start = min($startDate, $endDate);
                $end = max($startDate, $endDate);
                $whereClause .= " AND created_at BETWEEN :start_date AND :end_date ";
                $params[':start_date'] = $start;
                $params[':end_date'] = $end;
            }

            // Build the query
            $sql = "SELECT *,(SELECT COUNT(*) FROM users_test WHERE {$table_name}.account_type=2 {$whereClause}) as total_records FROM users_test WHERE {$table_name}.account_type=2 {$whereClause} ORDER BY {$table_name}.uid DESC LIMIT :offset, :limit";

            // Execute query using Medoo's query method
            $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
            return DataReportModel::response($data);
        } catch (Exception $e) {
            return DataReportModel::response("Internal Server Error." . $e->getMessage(), false);
        }
    }

    public static function searchUserData($partnerID,$filters): array
    {
        try {
            $top_agents = self::filter_user($partnerID,$filters);
            if (empty($top_agents["data"])) {
                return ["status" => "success", "data" => []];
            }
            $top_agents = $top_agents["data"];
            $uids = array_column($top_agents, 'uid');
            $login_counts = self::fetch_users_login_count($partnerID,$uids);
            $subs_count = self::count_subs($partnerID,$uids);

            return ["status" => "success", "data" => $top_agents, "login_counts" => $login_counts, "direct_subs_count" => $subs_count];
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "error", 'data' => "Internal Server Error."];
        }
    }
    public static function fetchTopAgents(array $filters, $page = 1, $limit = 20): array
    {
        try {
            $top_agents = self::filter_top_agents($filters, $page, $limit);
            if (empty($top_agents["data"])) {
                return ["status" => "success", "data" => [], "login_counts" => [], "direct_subs_count" => []];
            }
            $top_agents = $top_agents["data"];
            $uids = array_column($top_agents, 'uid');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count = self::count_subs($uids);

            return ["status" => "success", "data" => $top_agents, "login_counts" => $login_counts, "direct_subs_count" => $subs_count, "agent_nicknames" => ["status" => "success", "data" => []]];
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "error", 'data' => "Internal Server Error."];
        }
    }

    public static function fetchUsersData($partnerID,array $filters = [], $page = 1, $limit): array
    {
        try {
            $db = parent::openLink();

            // Pagination setup
            $offset = ($page - 1) * $limit;
            // Add binding parameters
            $params = [':offset' => intval($offset), ':limit' => intval($limit)];
            $table_name = "users_test";
            $whereClause = "";
            $startDate = $filters["start_date"];
            $endDate = $filters["end_date"];

            if (!empty($filters["recharge_level"])) {
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = empty($whereClause) ? " recharge_level=:recharge_level " : " AND recharge_level=:recharge_level ";
            }
            if (!empty($filters["state"])) {
                $params[":user_state"] = $filters["state"];
                $whereClause .= empty($whereClause) ? " user_state=:user_state " : " AND user_state=:user_state ";
            }
            if (!empty($filters["uid"])) {
                $params[":uid"] = $filters["uid"];
                $whereClause .= empty($whereClause) ? " uid=:uid " : " AND uid=:uid ";
            }

            if (!empty($startDate) && empty($endDate)) {
                $whereClause .= empty($whereClause) ? " created_at = :start_date " : "AND created_at = :start_date ";
                $params[':start_date'] = $startDate;
            } elseif (empty($startDate) && !empty($endDate)) {
                $whereClause .= empty($whereClause) ? " created_at = :end_date " : "AND created_at = :end_date ";
                $params[':end_date'] = $endDate;
            } elseif (!empty($startDate) && !empty($endDate)) {
                $start = min($startDate, $endDate);
                $end = max($startDate, $endDate);
                $whereClause .= empty($whereClause) ? " created_at BETWEEN :start_date AND :end_date  " : " AND created_at BETWEEN :start_date AND :end_date ";
                $params[':start_date'] = $start;
                $params[':end_date'] = $end;
            }

            
            $whereClause = empty($whereClause) ? " " : " WHERE  {$whereClause} ";

            $sql = "SELECT *,(SELECT COUNT(*) FROM users_test {$whereClause}) AS total_records FROM users_test {$whereClause}  ORDER BY uid DESC LIMIT :offset, :limit";
            $stmt = $db->query($sql, $params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            
            $uids = array_column($data, 'uid');
            $agent_ids = array_column($data, 'agent_id');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count = self::count_subs($uids);
            $agent_nicknames = self::fetch_agent_nickname($agent_ids);

            return ["status" => "success", "data" => $data, "login_counts" => $login_counts, "direct_subs_count" => $subs_count, "agent_nicknames" => $agent_nicknames];
        } catch (Exception $e) {
            return ["status" => "error", 'data' => "Internal Server Error."];
        }
    }

    public static function blockUserData(int $userId)
    {
        $db = parent::getLink();
        $params = [":userid" => intval($userId)];
        try {
            $sql = "UPDATE users_test SET user_state = 4 WHERE uid = :userid";
            $stmt = $db->query($sql, $params);
            $row_count = $stmt->rowCount();
            if ($row_count > 0) {
                return ['status' => 'success', 'data' => $row_count];
            } else {
                return ['status' => 'success', 'data' => 0];
            }
        } catch (PDOException $pDOException) {
            return ['status' => 'error', 'message' => $pDOException];
        }
        }
    // public static function FilterUserlistDataSubQuery($username = '', $states = '', $from = '', $to = '')
    // {
    //     $conditions = [];

    //     if (!empty($username) && $username != 'all') {
    //         $conditions['users.uid'] = $username;
    //     }

    //     if (!empty($states) && $states != 'all') {
    //         $conditions['users.state'] = $states;
    //     }

    //     if ($from != '' && $to != '') {
    //         $conditions['users.date_created[<>]'] = [$from, $to];
    //     } elseif ($from != '') {
    //         $conditions['users.date_created[>=]'] = $from;
    //     } elseif ($to != '') {
    //         $conditions['users.date_created[<=]'] = $to;
    //     }

    //     return $conditions;
    // }


    public static function AddAgentData($partnerID,$datas)
    {

        try {
            $inserAgentdata = parent::insert($partnerID,"users_test", $datas);

            $inserAgentdata = parent::insert("users_test", $datas);
            if ($inserAgentdata) {
                self::UpdateAgentTable($partnerID,$datas);
                return "Success";
            } else {
                return "Failed";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function FetchTopAgentData($partnerID,$page, $limit): array
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

        $data = parent::openLink($partnerID)->query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
      $data = parent::query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
        // Count the total records with the same filter (for pagination)
        $totalRecords = parent::count($partnerID,"users_test");

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

    public static function validateRegister($partnerID,$datas)
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

    public static function FetchRebateData($partnerID)
    {
        // return $res = parent::selectAll($partnerID,"rebate", ["rebate"], ["ORDER" => ["rebate_id" => "ASC"]]);
        return  $res = parent::selectAll("rebate", ["rebate"], ["ORDER" => ["rebate_id" => "ASC"]]);
    }

    public static function fetchquotaData($partnerID,$userrebate)
    {
        $data = parent::openLink($partnerID)->query("SELECT odds_group, rebate, quota, counts FROM rebate WHERE rebate <= :rebate", ['rebate' => $userrebate]);

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
    public static function FetchUserlogsData($partnerID,$page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $sql = "
        SELECT 
            user_logs.*, 
            users_test.email, users_test.contact, users_test.reg_type ,
            COALESCE(users_test.username, 'N/A') AS username 
        FROM user_logs   
        JOIN users_test ON users_test.uid = user_logs.uid  
        ORDER BY user_logs.ulog_id DESC 
        LIMIT :startpoint, :limit
     ";

        // Execute the query with pagination parameters
        $data = parent::openLink()->query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('user_logs');

    
    // Execute the query with pagination parameters
      $data = parent::query($sql, ['startpoint' => $startpoint, 'limit' => $limit]);
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
        $filterConditions = [];
   
        // Build filter conditions
        if (!empty($username)) {
            $filterConditions[] = "user_logs.uid = '$username'";
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
    }
    public static function fetchUserRebateList($uid)
    {
        $rebatelist = parent::selectOne("users_test", "*", ["uid" => $uid])['rebate_list'];
        return json_decode($rebatelist);
    }
}

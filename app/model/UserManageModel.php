<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});
class UserManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// USERLIST LIST -//////////

    public static function FetchUserlistData($page, $limit): array
    {
        $startpoint = ($page - 1) * $limit;
        $sql = "SELECT 
             u.uid, 
             u.username, 
             u.email, 
             u.contact, 
             u.nickname, 
             u.agent_name, 
             u.balance, 
             u.recharge_level, 
             u.user_state, 
             u.reg_type, 
             u.agent_level,           
             u.rebate, 
             u.created_at, 
             u.agent_id, 
             u.last_login, 
             u.account_type, 
                            GROUP_CONCAT(a.nickname) AS subordinates, 
                            COUNT(a.uid) AS sub_count, 
                            u.rebate
                        FROM 
                            users_test u
                        LEFT JOIN 
                            users_test a ON u.uid = a.agent_id
                        GROUP BY 
                            u.uid DESC
                        LIMIT :offset, :limit;";
        $pdo = (new Database())->openLink();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':offset', $startpoint, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as &$row) {
            $row['logincount'] = self::countUserLogs($row['uid']);
        }

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

    public static function Filteruserlist($subQuery, $page, $limit)
    {

        $startpoint = ($page - 1) * $limit;

        $sql = "SELECT uid, username,email,contact,nickname, agent_name, balance, recharge_level, user_state,reg_type,
                  rebate, created_at, agent_id, account_type,reg_type,last_login
             FROM users_test WHERE  $subQuery ";

        $countSql = "
                SELECT 
                    COUNT(*) AS total_count
                FROM 
                    users_test
            WHERE
                $subQuery
                ";


    //     $sql = "
    //     SELECT 
    //         u.uid, 
    //         u.username, 
    //         u.email, 
    //         u.contact, 
    //         u.nickname, 
    //         u.agent_name, 
    //         u.balance, 
    //         u.recharge_level, 
    //         u.user_state, 
    //         u.reg_type, 
    //         u.agent_level,           
    //         u.rebate, 
    //         u.created_at, 
    //         u.agent_id, 
    //         u.last_login, 
    //         u.account_type, 
    //         GROUP_CONCAT(a.nickname) AS subordinates, 
    //         COUNT(a.uid) AS sub_count
    //     FROM 
    //         users_test u
    //     LEFT JOIN 
    //         users_test a ON u.uid = a.agent_id
    //       WHERE $subQuery
    // GROUP BY u.uid
    
        
    //  ";
   

    $data = parent::query($sql);
    foreach ($data as &$row) {
        $row['logincount'] = self::countUserLogs($row['uid']);
    }
    $totalRecords = parent::query($countSql);
    $totalRecords = $totalRecords[0]['total_count'];
    $lastQuery = MedooOrm::openLink()->log();
    return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
    //     // SQL to count total records
    //     $countSql = "
    //     SELECT COUNT(DISTINCT u.uid) AS total_count
    //     FROM 
    //         users_test u
    //     LEFT JOIN 
    //         users_test a ON u.uid = a.agent_id
    //     WHERE $subQuery
    // ";

    //     try {
    //         $pdo = (new Database())->openLink();

    //         // Fetch paginated data
    //         $stmt = $pdo->prepare($sql);
    //         // $stmt->bindValue(':offset', $startpoint, PDO::PARAM_INT);
    //         // $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    //         $stmt->execute();
    //         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // Count user logs for each row
    //         foreach ($data as &$row) {
    //             $row['logincount'] = self::countUserLogs($row['uid']);
    //         }

    //         // Fetch total record count
    //         $countStmt = $pdo->prepare($countSql);
    //         $countStmt->execute();
    //         $totalRecords = (int)$countStmt->fetchColumn();

    //         return ['data' => $data, 'total' => $totalRecords];
    //     } catch (PDOException $e) {
    //         // Log and handle database exceptions
    //         error_log("Database error: " . $e->getMessage());
    //         return ['error' => 'A database error occurred'];
    //     }
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

        // Add ordering and limit to the query (you can also parameterize order if needed)
        $subQuery .= " ORDER BY created_at DESC";

        // Return the final subquery
        return $subQuery;
    }

    public static function fetch_user_hierarchy($user_id)
    {
        $db = parent::getLink();
        $sql  = "SELECT uid,username,agent_level,account_type FROM users_test  WHERE uid=:user_id";
        $stmt = $db->query($sql,[":user_id" => intval($user_id)]);
        return $stmt->fetch(PDO::FETCH_OBJ);

    }

    public static function fetch_user_rel($user_id): array {
       
       try{

      
            $db = parent::getLink();
           
            $agent_level_res = self::fetch_user_hierarchy($user_id);
            if(empty($agent_level_res) || $agent_level_res->agent_level === "*****") return ["status" => "success","data" => []];
            $unserialized_hierarchy  = unserialize($agent_level_res->agent_level);
            $params = [];
            $placeholders = [];
            foreach ($unserialized_hierarchy as $agent_id => $agent_rebate) {
                $place_holder = ":uid{$agent_id}";
                $placeholders[] = $place_holder;
                $params[$place_holder] = $agent_id;
            }
            $sql = "SELECT uid, CASE WHEN reg_type = 'email' THEN email WHEN reg_type = 'contact' THEN contact WHEN reg_type = 'username' THEN username END AS username FROM users_test WHERE  uid IN (".implode(',',$placeholders).") ORDER BY users_test.uid DESC";
            $stmt = $db->query($sql,$params);
            // Fetch the results as an array of objects
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            return ["status" => "success", 'data' => $data ];
        }catch(Exception $e){
            return ["status" => "error","data" => "Internal Server Error.".$e->getMessage()];
         }

    }

    public static function fetch_users_login_count(array $user_ids):array{

        try{
            $db = parent::getLink();
            $placeholders = [];
            $params = [];
            foreach($user_ids as $user_id){
                $placeholders[] = ":uid$user_id";
                $params[":uid$user_id"] = $user_id;
            }
            $sql = "SELECT uid,COUNT(*) as logs_count FROM `user_logs` WHERE uid IN (".implode(',', $placeholders).") GROUP BY uid";
            $stmt = $db->query($sql,$params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success","data" => $data];
        }catch(Exception $e){   
            return ["status" => "error", "data" => "Internal Server Error."];

        }
    }

    public static function count_subs(array $agent_ids):array {

        try{
            $db = parent::getLink();
            $placeholders = [];
            $params = [];
            foreach($agent_ids as $agent_id){
                $placeholders[] = ":uid$agent_id";
                $params[":uid$agent_id"] = $agent_id;
            }
            $sql = "SELECT agent_id,COUNT(*) as subs_count FROM `users_test` WHERE agent_id IN (".implode(',', $placeholders).") GROUP BY agent_id";
            $stmt = $db->query($sql,$params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success","data" => $data];

        }catch(Exception $e){

            return ["status" => "error", "data" => "Internal Server Error."];
        }
    }
    

    public static function fetch_agent_nickname(array $agent_ids):array {

        try{
            $db = parent::getLink();
            $placeholders = [];
            $params = [];
            foreach($agent_ids as $key => $agent_id){
                $placeholders[] = ":uid$key";
                $params[":uid$key"] = $agent_id;
            }
            $sql = "SELECT uid,nickname FROM `users_test` WHERE uid IN (".implode(',', $placeholders).") GROUP BY uid";
            $stmt = $db->query($sql,$params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success","data" => $data];

        }catch(Exception $e){

            return ["status" => "error", "data" => "Internal Server Error.".$e->getMessage()];
        }
    }

    public static function fetchAgentSubs($agent_id, $page = 1, $limit = 20) : array {
        try{
            $all_subs = DataReportModel::allSubs($agent_id,$page, $limit);
            if(empty($all_subs["data"])) return ["status" => "success","data" => []];
            $all_subs = $all_subs["data"];
            
            $uids     = array_column($all_subs,'uid');
            $agent_ids     = array_column($all_subs,'agent_id');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count = self::count_subs($uids);
            $agent_nicknames = self::fetch_agent_nickname($agent_ids);

        return ["status" => "success", "data" => $all_subs,"login_counts" => $login_counts,"direct_subs_count" => $subs_count,"agent_nicknames" => $agent_nicknames];
            
        }catch(Exception $e){
            echo $e->getMessage();
            return ["status" => "error" , 'data' => "Internal Server Error."];

        }
    }

    public static function filter_user(array $filters = []): array{
          try{
            $database = parent::getLink();

            // Add binding parameters
            $params = [":uid" => $filters["uid"]];
            $table_name = "users_test";
            $whereClause = "";
            
            $startDate = $filters["start_date"];
            $endDate   = $filters["end_date"];

            if(!empty($filters["recharge_level"])){
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = " AND recharge_level=:recharge_level ";
            }
            if(!empty($filters["state"])){
                $params[":user_state"] = $filters["state"];
                $whereClause .=  " AND user_state=:user_state";
            }

             if (!empty($startDate) && empty($endDate)){
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
        }catch(Exception $e){
            return DataReportModel::response("Internal Server Error.". $e->getMessage(),false);
        }
    }
    
    public static function filter_top_agents(array $filters = [], $page,$limit):array {
        try{
            $database = parent::getLink();

            // Pagination setup
            $offset = ($page - 1) * $limit;
              // Add binding parameters
            $params = [':offset' => intval($offset), ':limit' => intval($limit)];
            $table_name = "users_test";
            $whereClause = "";
            $startDate = $filters["start_date"];
            $endDate   = $filters["end_date"];

            if(!empty($filters["recharge_level"])){
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = " AND recharge_level=:recharge_level ";
            }
            if(!empty($filters["state"])){
                $params[":user_state"] = $filters["state"];
                $whereClause .=  " AND user_state=:user_state";
            }

             if (!empty($startDate) && empty($endDate)){
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
        }catch(Exception $e){
            return DataReportModel::response("Internal Server Error.". $e->getMessage(),false);
        }
    }


    public static function searchUserData($filters): array {
             try{
           
            $top_agents = self::filter_user($filters);
            if(empty($top_agents["data"])) return ["status" => "success","data" => []];
            $top_agents   = $top_agents["data"];
            $uids         = array_column($top_agents,'uid');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count   = self::count_subs($uids);

        return ["status" => "success", "data" => $top_agents,"login_counts" => $login_counts,"direct_subs_count" => $subs_count];
            
        }catch(Exception $e){
            echo $e->getMessage();
            return ["status" => "error" , 'data' => "Internal Server Error."];

        }
    }
    public static function fetchTopAgents(array $filters,$page = 1, $limit = 20) : array {
        try{
           
            $top_agents = self::filter_top_agents($filters,$page, $limit);
            if(empty($top_agents["data"])) return ["status" => "success", "data" => [],"login_counts" => [],"direct_subs_count" => []];
            $top_agents   = $top_agents["data"];
            $uids         = array_column($top_agents,'uid');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count   = self::count_subs($uids);

        return ["status" => "success", "data" => $top_agents,"login_counts" => $login_counts,"direct_subs_count" => $subs_count,"agent_nicknames" => ["status"=> "success","data"=>[]]];
            
        }catch(Exception $e){
            echo $e->getMessage();
            return ["status" => "error" , 'data' => "Internal Server Error."];

        }
    }


    public static function fetchUsersData(array $filters =[],$page = 1, $limit): array {

        try{
            $db = parent::getLink();
             // Pagination setup
            $offset = ($page - 1) * $limit;
              // Add binding parameters
            $params = [':offset' => intval($offset), ':limit' => intval($limit)];
            $table_name = "users_test";
            $whereClause = "";
            $startDate = $filters["start_date"];
            $endDate   = $filters["end_date"];

            if(!empty($filters["recharge_level"])){
                $params[":recharge_level"] = $filters["recharge_level"];
                $whereClause = empty($whereClause) ?  " recharge_level=:recharge_level " : " AND recharge_level=:recharge_level ";
            }
            if(!empty($filters["state"])){
                $params[":user_state"] = $filters["state"];
                $whereClause .=  empty($whereClause) ? " user_state=:user_state " : " AND user_state=:user_state ";
            }
            if(!empty($filters["uid"])){
                $params[":uid"] = $filters["uid"];
                $whereClause .=  empty($whereClause) ? " uid=:uid " : " AND uid=:uid ";
            }

             if (!empty($startDate) && empty($endDate)){
                $whereClause .= empty($whereClause) ? " created_at = :start_date " : "AND created_at = :start_date ";
                $params[':start_date'] = $startDate;
            } elseif (empty($startDate) && !empty($endDate)) {
                $whereClause .= empty($whereClause) ? " created_at = :end_date " : "AND created_at = :end_date ";
                $params[':end_date'] = $endDate;
            } elseif (!empty($startDate) && !empty($endDate)) {
                $start = min($startDate, $endDate);
                $end   = max($startDate, $endDate);
                $whereClause .= empty($whereClause) ? " created_at BETWEEN :start_date AND :end_date  " : " AND created_at BETWEEN :start_date AND :end_date ";
                $params[':start_date'] = $start;
                $params[':end_date'] = $end;
            }

            $whereClause = empty($whereClause) ? " " :" WHERE  {$whereClause} ";

            $sql = "SELECT *,(SELECT COUNT(*) FROM users_test {$whereClause}) AS total_records FROM users_test {$whereClause}  ORDER BY uid DESC LIMIT :offset, :limit";
            $stmt = $db->query($sql, $params);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            
            $uids     = array_column($data,'uid');
            $agent_ids     = array_column($data,'agent_id');
            $login_counts = self::fetch_users_login_count($uids);
            $subs_count = self::count_subs($uids);
            $agent_nicknames = self::fetch_agent_nickname($agent_ids);

        return ["status" => "success", "data" => $data,"login_counts" => $login_counts,"direct_subs_count" => $subs_count,"agent_nicknames" => $agent_nicknames];
            
        }catch(Exception $e){
            return ["status" => "error" , 'data' => "Internal Server Error."];

        }
    }



    public static function blockUserData(int $userId)
    {

        $db = parent::getLink();
        $params = [":userid" => intval($userId)];
        try {
            
            $sql = "UPDATE users_test SET user_state = 4 WHERE uid = :userid";
            $stmt = $db->query($sql,$params);
            $row_count = $stmt->rowCount();
            if ($row_count > 0) {
             return ['status' => 'success', 'data' => $row_count];
            } else {
                return  ['status' => 'success', 'data' => 0];
            }
        } catch (PDOException $pDOException) {
         return ['status' => 'error', 'message' => $pDOException];
        }

     
    }


    public static function fetch_user_ips($user_id)
    {
        $db = parent::getLink();
        $sql = "SELECT ulog_id,login_date,login_time,ip,ip_state FROM `user_logs` WHERE uid=:user_id";
        $stmt = $db->query($sql,[":user_id" => $user_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }




    public static function deleteUserData(int $userId)
    {

        try{
            $db = parent::getLink();
            $sql = "DELETE FROM users_test WHERE uid = :userid";
            $stmt = $db->query($sql,[":userid" => intval($userId)]);
            if ($stmt->rowCount() > 0) {
                return ['status' => 'success','data' => $stmt->rowCount()];
            } else {
                return ['status' => 'success', 'data' => 0];
            }
        }catch(Exception $e){
            return ["status"=>"error","data" => "Internal Server Error."];
        }
       
    }

    public static function fetchUserLotteries($user_id)
    {
        try{
            
          
        $db = parent::getLink();
        $sql = "SELECT lt_id,name,(SELECT blocked_lotteries FROM `users_test` WHERE uid=:user_id ) as blockedLotteries FROM `lottery_type`";
        $stmt = $db->query($sql,[":user_id"=> $user_id]);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(empty($data)){
            return ["status" => "error", "data", "No Lotteries registered"];
        }
        $blocked_lotteries = $data[0]->blockedLotteries;
       if($blocked_lotteries != null && $blocked_lotteries != "*****") $data[0]->blockedLotteries = unserialize($blocked_lotteries);

        return ["status"=>"success","data"=> $data];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];
        }
        // return ['lotteries' => $lotteries, 'blockedLotteries' => empty($data->blocked_lotteries) ? [] : unserialize($data->blocked_lotteries)];
    }

    

    public static function update_lottery_stat_for_user($user_id,$lottery_id)
    {

        
       
        try{
        $db   = parent::getLink();
        $sql = "SELECT blocked_lotteries FROM `users_test` WHERE uid=:user_id";
        $stmt = $db->query($sql,[":user_id" => $user_id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
            $state = false;
        
            $unserialized_lotteries = empty($data->blocked_lotteries) || $data->blocked_lotteries == "*****" ? [] : unserialize($data->blocked_lotteries);
           
            if(empty($unserialized_lotteries)){
                $state = true;
                $sql = "UPDATE `users_test` SET blocked_lotteries='".serialize([$lottery_id])."' WHERE uid=:user_id";
            }else{
                if(in_array($lottery_id,$unserialized_lotteries)){
                    $unserialized_lotteries = array_diff($unserialized_lotteries,[$lottery_id]);
                }else{
                     $state = true;
                     array_push($unserialized_lotteries,$lottery_id);
                }
                
                $sql = "UPDATE `users_test` SET blocked_lotteries='" . serialize($unserialized_lotteries) . "' WHERE uid=:user_id";
            }
            $stmt = $db->query($sql,[":user_id" => $user_id]);
            if($stmt->rowCount()){
                return ['status' => 'success', 'data' => $stmt->rowCount()];
            }
           
            print_r($unserialized_lotteries);
            return ['status' => 'success', 'data' => 0];
       
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => 'Error Blocking Lottery for User.'. $e->getMessage()];
        }
    }



    public static function fetchUserLogs($user_id,$page = 1, $limit = 100): array {

        try{
         
            $db   = parent::getLink();
            $offset = ($page - 1) * $limit;

            $sql = "SELECT ulog_id,uid,ip,login_date,login_time,(SELECT COUNT(ulog_id) FROM user_logs WHERE uid=:user_id) as totalPages, CASE ip_state WHEN 1 THEN 'allowed' ELSE 'unknown' END AS ip_state FROM user_logs WHERE uid=:user_id LIMIT :offset, :limit";
            $stmt = $db->query($sql,[":user_id" => $user_id, ":offset" => $offset, ":limit" => $limit]);
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ['status' => 'success', "data" =>$data];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error."];
    
        }
    }

    public static function block_user_ip($user_id, $ip_id)
    {
        try {
           
            $db   = parent::getLink();
            $sql = "UPDATE user_logs SET ip_state = CASE ip_state WHEN 1  THEN 2 ELSE 1 END WHERE uid =:user_id AND ulog_id=:ulog_id";
            $stmt = $db->query($sql,[":user_id" => $user_id,":ulog_id" => $ip_id ]);
            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', "data" => $stmt->rowCount()];
            } else {
                return ['status' => 'success', 'data' => 0];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'msg' => 'Error Blocking Lottery for User.' . $e->getMessage()];
        }
    }

    public static function FetchUserData(int $user_id)
    {
        try{

       
        $db = parent::getLink();
        $sql  = "SELECT * FROM users_test WHERE uid = :user_id";
        $stmt = $db->query($sql,[":user_id" => $user_id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => $e->getMessage()];       
    }
    }

    public static function updateUserInfo($user_id, $depositLimit,$withdrawalLimit, $rebate,$state,$dailyBettingTotalLimit)
    {
        try{


       
        $db = parent::getLink();
        $sql  = "UPDATE  users_test SET rebate=:rebate, user_state =:user_state, daily_bet_llimit=:daily_bet_llimit, withdrawal_level=:withdrawal_level,recharge_level=:recharge_level  WHERE uid = :user_id";
        $stmt = $db->query($sql,[":user_id" => intval($user_id),":rebate" => $rebate,":user_state" => $state,":daily_bet_llimit" => $dailyBettingTotalLimit,":withdrawal_level" => $withdrawalLimit, ":recharge_level" => $depositLimit]);
        $data =  $stmt->rowCount();
        return ["status" => "success", "data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => $e->getMessage()];       
    }
    }

    // public static function fetchUserRel($user_id)
    // {
    //     try{

    //     $db = parent::getLink();
    //     $sql  = "UPDATE  users_test SET rebate=:rebate, user_state =:user_state, daily_bet_llimit=:daily_bet_llimit, withdrawal_level=:withdrawal_level,recharge_level=:recharge_level  WHERE uid = :user_id";
    //     $stmt = $db->query($sql,[":user_id" => intval($user_id),":rebate" => $rebate,":user_state" => $state,":daily_bet_llimit" => $dailyBettingTotalLimit,":withdrawal_level" => $withdrawalLimit, ":recharge_level" => $depositLimit]);
    //     $data =  $stmt->rowCount();
    //     return ["status" => "success", "data" => $data];
    // }catch(Exception $e){
    //     return ["status" => "error", "data" => $e->getMessage()];       
    // }
    // }



    public static function  FetchSubAgents($nicknames, $page, $limit)
    {
        if (!is_array($nicknames)) {
            $nicknames = explode(",", $nicknames); // Split string into array
        }
        $placeholders = implode(',', array_fill(0, count($nicknames), '?'));

        if (!is_array($nicknames)) {
            $nicknames = explode(",", $nicknames);
        }

        $startpoint = ($page - 1) * $limit;

        if (empty($nicknames)) {
            return ['data' => [], 'total' => 0];
        }

        // Named placeholders for nicknames
        $placeholders = implode(',', array_map(fn($index) => ":nickname$index", array_keys($nicknames)));

        // SQL to fetch data
        $sql = "
        SELECT 
            u.uid, 
            u.username, 
            u.email, 
            u.contact, 
            u.nickname, 
            u.agent_name, 
            u.balance, 
            u.recharge_level, 
            u.user_state, 
            u.reg_type, 
            u.agent_level,           
            u.rebate, 
            u.created_at, 
            u.agent_id, 
            u.last_login, 
            u.account_type, 
            GROUP_CONCAT(a.nickname) AS subordinates, 
            COUNT(a.uid) AS sub_count
        FROM 
            users_test u
        LEFT JOIN 
            users_test a ON u.uid = a.agent_id
        WHERE 
            u.nickname IN ($placeholders)
        GROUP BY 
            u.uid
        LIMIT :offset, :limit
        ";

            // SQL to count total records
            $countSql = "
            SELECT 
                COUNT(DISTINCT u.uid) AS total_count
            FROM 
                users_test u
            LEFT JOIN 
                users_test a ON u.uid = a.agent_id
            WHERE 
                u.nickname IN ($placeholders)
        ";

            $pdo = (new Database())->openLink();

            // Prepare and bind nicknames for the main query
            $stmt = $pdo->prepare($sql);
            foreach ($nicknames as $index => $nickname) {
                $stmt->bindValue(":nickname$index", $nickname, PDO::PARAM_STR);
            }
            $stmt->bindValue(':offset', $startpoint, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as &$row) {
                $row['logincount'] = self::countUserLogs($row['uid']);
            }
            // Prepare and bind nicknames for the count query
            $countStmt = $pdo->prepare($countSql);
            foreach ($nicknames as $index => $nickname) {
                $countStmt->bindValue(":nickname$index", $nickname, PDO::PARAM_STR);
            }
            $countStmt->execute();
            $totalRecords = $countStmt->fetchColumn();

            return ['data' => $data, 'total' => $totalRecords];
    }
    public function FetchUserAccountChange($userid,$page,$limit){
        $startpoint = ($page - 1) * $limit;
        $sql = "SELECT 
                    transaction.*, 
                    users_test.email, 
                    users_test.contact, 
                    users_test.reg_type, 
                    COALESCE(users_test.username, 'N/A') AS username 
                FROM 
                    transaction   
                LEFT JOIN 
                    users_test ON users_test.uid = transaction.uid  
                WHERE 
                    transaction.uid = :uid  
                ORDER BY 
                    transaction.trans_id DESC 
                LIMIT :offset, :limit";

        $countSql = "SELECT COUNT(*) AS total_count 
        FROM transaction 
        LEFT JOIN users_test ON users_test.uid = transaction.uid  
        WHERE transaction.uid = :uid";
                
        $pdo = (new Database())->openLink();
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters correctly
        $stmt->bindValue(':offset', (int)$startpoint, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':uid', (int)$userid, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count total records
        $countStmt = $pdo->prepare($countSql);
        $countStmt->bindValue(':uid', (int)$userid, PDO::PARAM_INT);
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();
                
        return ['data' => $data, 'total' => $totalRecords];
        
    }
   

    public function FilterUserAccountChange($subquery,$userid, $page, $limit) {

        $startpoint = ($page - 1) * $limit;
    
        $sql = "SELECT 
                    transaction.*, 
                    users_test.email, 
                    users_test.contact, 
                    users_test.reg_type, 
                    COALESCE(users_test.username, 'N/A') AS username 
                FROM 
                    transaction   
                LEFT JOIN 
                    users_test ON users_test.uid = transaction.uid  
                 WHERE   $subquery AND transaction.uid = :uid
                  ORDER BY  transaction.trans_id DESC 
                LIMIT :offset, :limit";
    
        $countSql = "SELECT COUNT(*) AS total_count 
                     FROM transaction 
                     LEFT JOIN users_test ON users_test.uid = transaction.uid  
                    WHERE $subquery AND transaction.uid = :uid";
    
        // Database connection
        $pdo = (new Database())->openLink();
    
 
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', (int)$userid, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $startpoint, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $countStmt = $pdo->prepare($countSql);
        $countStmt->bindValue(':uid', (int)$userid, PDO::PARAM_INT);
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();
    
        return ['data' => $data, 'total' => $totalRecords];
    }
    
    
    public static function FilterChangeDataSubQuery($states, $startdate, $enddate)
    {
        $filterConditions = [];

       
        if (!empty($states)) {
            $filterConditions[] = "transaction.order_type = '$states'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "DATE(transaction.dateTime) BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "DATE(transaction.dateTime) = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "DATE(transaction.dateTime) = '$enddate'";
        }

        // Combine conditions into the final query
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }

        // Add ordering and limit to the query (you can also parameterize order if needed)
      //  $subQuery .= " ORDER BY dateTime DESC";

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
        return  $agentemail = parent::selectAll("users_test", ["username", "uid"], ["username" => $datas]);
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
        $emailexist = self::checkEmailExist(trim($datas['agentname']));
        $password = trim($datas['agentpassword'] ?? '');
        // $confirmPassword = trim($datas['agentpassword1'] ?? '');
      //  $email = trim($datas['agentemail'] ?? '');
        $username = trim($datas['agentname'] ?? '');

        // //email exit    
        if ($emailexist) {
            $errors['emailexist'] = "Username already taken";
        }
        // Password validation
        if (empty($password)) {
            $errors['passwordRequired'] = "Password is required";
        } elseif (strlen($password) < 8) {
            $errors['passwordLength'] = "Password must be at least 8 characters";
        }

        // Confirm password validation
        // if ($password !== $confirmPassword) {
        //     $errors['confirmPassword'] = "Password doesn't match";
        // }

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
        // if (empty($email)) {
        //     $errors['email'] = "Email is required";
        // } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     $errors['email'] = "Email address is invalid";
        // }

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
            user_logs.*, 
            users_test.email,
            users_test.username,
            users_test.contact,
            users_test.reg_type
        FROM user_logs
        LEFT JOIN users_test ON users_test.uid = user_logs.uid
        WHERE $subQuery
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

    public static function FilterUserlogsDataSubQuery($username, $startdate, $enddate)
    {

        $filterConditions = [];

        // Build filter conditions
        if (!empty($username)) {
            $filterConditions[] = "user_logs.uid = '$username'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "user_logs.login_date BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "user_logs.login_date = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "user_logs.login_date = '$enddate'";
        }

        // Combine conditions into the final query
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }

        // $subQuery .= " ORDER BY login_date DESC";

        return $subQuery;
    }

    public static function fetchUserRebateList($uid)
    {
        $rebatelist = parent::selectOne("users_test", "*", ["uid" => $uid])['rebate_list'];
       return  $data = json_decode($rebatelist,true);
      //return   $datareverse = array_reverse($data);
     
    }
}
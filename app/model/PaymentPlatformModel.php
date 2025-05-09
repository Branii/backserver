<?php
 date_default_timezone_set('Asia/Shanghai');
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class PaymentPlatformModel extends MEDOOHelper{


    // public static function fetchPaymentPlatforms(): Mixed{
    //     try{
    //     $table_name = "currency";
    //     $res = parent::openLink()->query("SELECT * FROM {$table_name} WHERE currency_type ='fiat' " )->fetchAll(PDO::FETCH_OBJ);
    //     return ["status" => "success", "data" => $res];
    // }catch(Exception $e){
    //     return self::response("Internal Server Error.",false,);
    // }
    // }

    // public static function fetchPaymentPlatformsForPartner($page = 1,$limit = 20): Mixed{

    //     try{
    //     $table_name = "enzerhub_currency";
    //     $offset = ($page - 1) * $limit;
    //     $res = parent::openLink()->query("SELECT * FROM {$table_name} ORDER BY cid DESC LIMIT :offset,:limit", [":offset" => $offset, ":limit" => $limit ])->fetchAll(PDO::FETCH_OBJ);
    //     return ["status" => "success", "data" => $res];
    // }catch(Exception $e){
    //     return self::response("Internal Server Error.",false,);
    // }
    // }



    // public static function searchPaymentPlatform($searchData = []): Mixed{


        
    //     try{
        
    //     $table_name = "enzerhub_currency";
    //     $offset = ($searchData["page"] - 1) * 10;
    //     $params = [":offset" => (int) $offset, ":limit" => (int) $searchData["limit"]];
    //     $db_fields = ["platformID" => "payment_type_id", "currency" => "currency","status" => "status" , "startDate" => "date_created","endDate" => "date_created"];
    //     $where_clause = [];
    //     foreach($searchData as $key => $value){
    //         if($key != "page" && $key != "limit" && !empty($value)){
    //             if($key != "startDate" && $key != "endDate" ){
    //                 $where_clause[] = $db_fields[$key]."=:$key";
    //                 $params[":$key"] = $value;
    //             }
    //         }
    //     }

    //     if (!empty($searchData["startDate"]) || !empty($searchData['endDate'])) {
    //         if (empty($searchData['endDate'])) {
    //             $where_clause[] = "date_created=:datecreated";
    //             $params[":datecreated"] = $searchData['datecreated'];
    //         } elseif (empty($searchData['startDate'])) {
    //             $where_clause[] = "date_created=:enddate";
    //             $params[":enddate"] = $searchData['endDate'];
    //         } else {
    //             $where_clause[] = "date_created BETWEEN :datecreated AND :enddate";
    //             $params[":datecreated"] = min($searchData['startDate'], $searchData['endDate']);
    //             $params[":enddate"]     = max($searchData['startDate'], $searchData['endDate']);
    //         }
    //     }

    //     $sql = "SELECT * FROM {$table_name} ".(empty($where_clause) ? "" : " WHERE ".implode(" AND ",$where_clause)) ." LIMIT :offset,:limit";

    //     $res = parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
    //     return ["status" => "success", "data" => $res];
    // }catch(Exception $e){
    //     return self::response("Internal Server Error.".$e->getMessage(),false,);
    // }
    // }

    // public static function addNewPaymentPlaftorm($searchData = []): Mixed{
        
    //     try{
            
    //     $table_name = "enzerhub_currency";
    //     $map = [];
    //     foreach($searchData as $key => $value) {
    //         $map[":$key"] = $value;
    //     }

    //     $sql = "INSERT INTO $table_name (payment_type_id, name, status, created_by, date_created, currency, fee, site_url, admin_site_url, last_update, last_update_by, min_amount, max_amount,info,priority,countries) VALUES (:payment_type_id, :name, :status, :created_by, :date_created, :currency, :fee, :site_url, :admin_site_url, :last_update, :last_update_by, :min_amount, :max_amount,:info,:priority,:countries);";

    //     $stmt      = parent::openLink()->query($sql, $map);
    //     $row_count = $stmt->rowCount();
    //     return ["status" => "success", "data" => $row_count,"id" => parent::openLink()->id()];
    // }catch(Exception $e){

    //     if($e->getCode() == 23000){
    //         return ["status" => "error", "data" => $searchData['name']." payments already added."];
    //     }
    //     return self::response("Internal Server Error.".$e->getCode(),false,);
    // }
    // }
    // public static function editPaymentPlaftorm($searchData = []): Mixed{
        
    //     try{
            
    //     $table_name = "enzerhub_currency";
    //     $map = [];
    //     foreach($searchData as $key => $value) {
    //         $map[":$key"] = urldecode($value);
    //     }

    //     $sql = "UPDATE  $table_name SET status=:status, currency=:currency, fee=:fee, site_url=:site_url, admin_site_url=:admin_site_url, last_update=:last_update, last_update_by=:last_update_by, min_amount=:min_amount, max_amount=:max_amount , info=:info , priority=:priority,countries=:countries WHERE payment_type_id=:payment_type_id";
        
    //     $stmt      = parent::openLink()->query($sql, $map);
    //     $row_count = $stmt->rowCount();
    //     return ["status" => "success", "data" => $row_count];
    // }catch(Exception $e){
    //     return self::response("Internal Server Error.".$e->getMessage(),false,);
    // }
    // }



    public static function searchPlatformNames($platformName): Mixed{
        $query = trim($platformName); // Clean the input
        $query = parent::openLink()->query(
         "SELECT * FROM currency WHERE name LIKE :search AND currency_type='fiat' LIMIT 50", ['search' => "%$query%"]);
        $data = $query->fetchAll(PDO::FETCH_OBJ);
        return $data;

    // }
    // public static function fetchDifferentCurrency(): Mixed{
     try{

       
        $query = trim($platformName); 

        // return $db_id;
        
        $query = parent::openLink($db_id)->query(
         "SELECT * FROM currency WHERE name LIKE :search AND currency_type='fiat' LIMIT 50", ['search' => "%$query%"]);
        $data = $query->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }catch(Exception $e){
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
  }
    
  


    // public static function response($data,$type = true) {  return ["status" => $type ? "success" : "error" , "data" => $data];  }


    public static function FetchPaymentPlatform($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $query =
         "SELECT bankid,name,bank_type,currency_type,
                 bank_status,max_deposit,max_withdrawal,created_at,approved_by
         FROM banks  ORDER BY banks.bankid DESC LIMIT :offset, :limit 
         ";
        $data = parent::query($query, ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords = parent::count('banks');
        return ['data' => $data, 'total' => $totalRecords];
    }


    public static function fetchAllPaymentPlatform($page, $limit){
     
        $startpoint = $page * $limit - $limit;
        $query =
         "SELECT *,(SELECT COUNT(*) FROM payment_platforms) as  FROM payment_platforms  ORDER BY cid DESC LIMIT :offset, :limit 
         ";
        $data = parent::query($query, ['offset' => $startpoint, 'limit' => $limit]);
        return ['status' => "success",'data' => $data, ];
    
    }
    public static function AddPaymentPlatform($paymentname, $currencytype,$paylogo, $currencystate,$maxiamount, $miniamount,$currencyselect,$approvedby)
    {
        $params =[
         'name' =>$paymentname,
         'bank_type' =>$currencytype,
         'currency_type' =>$currencyselect,
         'image' =>$paylogo,
         'bank_status' =>$currencystate,
         'max_deposit' => $miniamount,
         'max_withdrawal' =>$maxiamount,
         'approved_by' =>$approvedby,
         'created_at' => date("Y-m-d / H:i:s")
        ];
         $insertData = parent::insert("banks", $params);
         return $insertData ? "Payment added succesfully." : "Payment could not be added. Please try again.";
        
    }

    public static function DeletePaymentPlatform($payid){
       $data = parent::query("DELETE  FROM banks WHERE bankid =:bankid", ['bankid' => $payid]);
        return $data ? "Please try again." : "Deleted succesfully.";
    }

    public static function EditPaymentPlatform($payid){
        $data = parent::query("SELECT bankid,bank_status,currency_type,max_deposit,max_withdrawal FROM banks WHERE bankid =:bankid", ['bankid' => $payid]);
         return $data ;
     }

    public static function UpdatePaymentPlatform($typecurrency,$maxiamounts,$minamount,$statecurrent,$paymentids){
        $params =[
            'currency_type' =>$typecurrency,
            'bank_status' =>$statecurrent,
            'max_deposit' => $minamount,
            'max_withdrawal' =>$maxiamounts,
            'bankid' =>$paymentids, 
         ];

         $sql = "UPDATE banks SET bank_status = :bank_status, currency_type = :currency_type, max_deposit = :max_deposit, max_withdrawal = :max_withdrawal WHERE bankid = :bankid";
         $data = parent::query($sql, $params);
        return $data ? "Please try again." : "Updated successfully.";
    }



    public static function updatePartnerMainInfo($parameters = []){
        

        try{
        $params["partner_id"] = (int)$parameters["partner_id"];
        $query  = []; 
        foreach($parameters as $field => $value){
            if($field === "partner_id") continue;
            $params[$field] = $value;
            $query[] = "$field = :$field";
        }
         $sql = "UPDATE partners_v1 SET partnerName = :partnerName, currency_type = :currency_type, max_deposit = :max_deposit, max_withdrawal = :max_withdrawal WHERE partner_id = :partner_id";
         $sql = "UPDATE partners_v1 SET ".implode(",",$query)." WHERE partner_id = :partner_id";
         $stmt = parent::openLink()->query($sql, $params);
       return ["status" => "success", "data" => $stmt->rowCount()];
    }catch(Exception $e){
        return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];       
    }
    }
    
    public static function fetchAllPaymentPlatforms(){
     try{
         $sql = "SELECT cid FROM  payment_platforms";
         $stmt = parent::openLink()->query($sql);
         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return ["status" => "success", "data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => "Internal Server Error."];       
    }
    }
    public static function editPartnerLotteries($partnerID,$blocked_lotteries){
        
        try{
         $sql = "UPDATE partners_v1 SET blocked_lotteries = :blocked_lotteries WHERE partner_id = :partner_id";
         $stmt = parent::openLink()->query($sql, [":partner_id" => $partnerID,":blocked_lotteries" => $blocked_lotteries]);
       return ["status" => "success", "data" => $stmt->rowCount()];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];       
        }
    }
    public static function editPartnerCurrencySettings($partnerID,$blocked_currencies){
        
        try{
         $sql = "UPDATE partners_v1 SET blocked_currencies = :blocked_currencies WHERE partner_id = :partner_id";
         $stmt = parent::openLink()->query($sql, [":partner_id" => $partnerID,":blocked_currencies" => $blocked_currencies]);
       return ["status" => "success", "data" => $stmt->rowCount()];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];       
        }
    }
    public static function editPartnerlanguagesSettings($partnerID,$blocked_languages){
        
        try{
         $sql = "UPDATE partners_v1 SET blocked_languages = :blocked_languages WHERE partner_id = :partner_id";
         $stmt = parent::openLink()->query($sql, [":partner_id" => $partnerID,":blocked_languages" => $blocked_languages]);
       return ["status" => "success", "data" => $stmt->rowCount()];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];       
        }
    }
    
    public static function Platformsubquery($curencytypes,$stautspayment, $startdate, $enddate)
    {
        $filterConditions = [];
        $subQuery = "";
        if (!empty($curencytypes)) {
            $filterConditions[] = "bank_type ='$curencytypes'";
        }

        if (!empty($stautspayment)) {
            $filterConditions[] = "bank_status = '$stautspayment'";
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
       // $subQuery .= "ORDER BY notice_users.created_at DESC";

        return $subQuery;
    }

    public static function FilterPlatformData($subquery,$page, $limit){
        try {
             $startpoint = ($page - 1) * $limit;
             $sql = "
             SELECT bankid, name, bank_type, currency_type, bank_status, 
                    max_deposit, max_withdrawal, created_at, approved_by
             FROM banks
             WHERE $subquery
             LIMIT :limit OFFSET :offset
         ";
                
              $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

              $countdata = "SELECT COUNT(*) AS total_counts FROM banks WHERE $subquery"; 

            // Execute the count query
            $totalRecords = parent::query($countdata);
            $totalRecords = $totalRecords[0]['total_counts'];

            return ['data' => $data , 'total' => $totalRecords];
        } catch (Exception $e) {
            error_log("Error executing query: " . $e->getMessage());
        }
    }


public static function searchPaymentPlatform($searchData = [],$page, $limit): Mixed {

        try{
        
        $table_name = "payment_platforms";
        $offset = ($page - 1) * 10;
        $params = [":offset" => (int) $offset, ":limit" => (int) $limit];
        $where_clause = [];
        foreach($searchData as $key => $value){
            if(!empty($value)){
                if($key != "startDate" && $key != "endDate" ){
                    $where_clause[] = "$key=:$key";
                    $params[":$key"] = $value;
                }
            }
        }

        if (!empty($searchData["startDate"]) || !empty($searchData['endDate'])) {
            if (empty($searchData['endDate'])) {
                $where_clause[] = "date_created=:datecreated";
                $params[":datecreated"] = $searchData['datecreated'];
            } elseif (empty($searchData['startDate'])) {
                $where_clause[] = "date_created=:enddate";
                $params[":enddate"] = $searchData['endDate'];
            } else {
                $where_clause[] = "date_created BETWEEN :datecreated AND :enddate";
                $params[":datecreated"] = min($searchData['startDate'], $searchData['endDate']);
                $params[":enddate"]     = max($searchData['startDate'], $searchData['endDate']);
            }
        }

        $sql = "SELECT *,(SELECT COUNT(*) FROM {$table_name}) as total_records FROM {$table_name} ".(empty($where_clause) ? "" : " WHERE ".implode(" AND ",$where_clause)) ." LIMIT :offset,:limit";

        $res = parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return ["status" => "error", "data" => $e->getMessage()];
    }
    }
}
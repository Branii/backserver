<?php


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class PartnersModel extends MedooOrm{


    public static function fetch_partners_names(): Mixed{

        try{
        $table_name = "partners_v1";
        $res = parent::openLink()->query("SELECT partner_id,name FROM {$table_name}")->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.",false,);
    }
    }

    public static function fetch_partners($page = 1,$limit = 20): Mixed{

        try{
        $table_name = "partners_v1";
        $offset = ($page - 1) * $limit;
        $res = parent::openLink()->query("SELECT * FROM {$table_name} ORDER BY partner_id DESC LIMIT :offset,:limit", [":offset" => $offset, ":limit" => $limit ])->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.",false,);
    }
    }



    public static function searchPartners($searchData = []): Mixed{

    try{
        
        $table_name = "partners_v1";
        $offset = ($searchData["page"] - 1) * 10;
        $params = [":offset" => (int) $offset, ":limit" => (int) $searchData["limit"]];
        $db_fields = ["partner_id" => "partner_id", "state" => "state", "startDate" => "date_created","endDate" => "date_created"];
        $where_clause = [];
        foreach($searchData as $key => $value){
            if($key != "page" && $key != "limit" && !empty($value)){
                if($key != "startDate" && $key != "endDate" ){
                    $where_clause[] = $db_fields[$key]."=:$key";
                    $params[":$key"] = $value;
                }
            }
        }

        if (!empty($searchData["startDate"]) || !empty($searchData['endDate'])) {
            if (empty($searchData['endDate'])) {
                $where_clause[] = "date_created=:datecreated";
                $params[":datecreated"] = $searchData['startDate'];
            } elseif (empty($searchData['startDate'])) {
                $where_clause[] = "date_created=:enddate";
                $params[":enddate"] = $searchData['endDate'];
            } else {
                $where_clause[] = "date_created BETWEEN :datecreated AND :enddate";
                $params[":datecreated"] = min($searchData['startDate'], $searchData['endDate']);
                $params[":enddate"]     = max($searchData['startDate'], $searchData['endDate']);
            }
        }

        $sql = "SELECT * FROM {$table_name} ".(empty($where_clause) ? "" : " WHERE ".implode(" AND ",$where_clause)) ." LIMIT :offset,:limit";


        $res = parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
    }

    public static function addNewPartner($searchData = []): Mixed{
        
        try{

      
        $table_name = "partners_v1";
        $db = parent::openLink();
        $map = [];
        foreach($searchData as $key => $value) {
            $map[":$key"] = $value;
        }
        $sql = "INSERT INTO $table_name (name, currency,state, created_by, date_created, site_url, admin_site_url, last_update, last_update_by) VALUES (:name, :currency,:state, :created_by, :date_created, :site_url, :admin_site_url, :last_update, :last_update_by);";
        $stmt      = $db->query($sql, $map);
        $row_count = $stmt->rowCount();
        return ["status" => "success", "data" => $row_count,"id" => $db->id()];
    }catch(Exception $e){

        if($e->getCode() == 23000){
            return ["status" => "error", "data" => $searchData['name']." payments already added."];
        }
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
    }



    public static function fetchLotteries()
    {
        try{
            
          
        $db = parent::openLink();
        $sql = "SELECT lt_id,name,(SELECT blocked_lotteries FROM `users_test` WHERE uid=:user_id ) as blockedLotteries FROM `lottery_type`";
        $sql = "SELECT lt_id,name FROM `lottery_type`";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(empty($data)){
            return ["status" => "error", "data", "No Lotteries registered"];
        }

        return ["status"=>"success","data"=> $data];
        }catch(Exception $e){
            return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];
        }
        // return ['lotteries' => $lotteries, 'blockedLotteries' => empty($data->blocked_lotteries) ? [] : unserialize($data->blocked_lotteries)];
    }
    public static function editPaymentPlaftorm($searchData = []): Mixed{
        
        try{
            
        $table_name = "enzerhub_currency";
        $map = [];
        foreach($searchData as $key => $value) {
            $map[":$key"] = urldecode($value);
        }

        $sql = "UPDATE  $table_name SET status=:status, currency=:currency, fee=:fee, site_url=:site_url, admin_site_url=:admin_site_url, last_update=:last_update, last_update_by=:last_update_by, min_amount=:min_amount, max_amount=:max_amount , info=:info , priority=:priority,countries=:countries WHERE payment_type_id=:payment_type_id";
        
        $stmt      = parent::openLink()->query($sql, $map);
        $row_count = $stmt->rowCount();
        return ["status" => "success", "data" => $row_count];
    }catch(Exception $e){
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
    }



    public static function searchPartnersNames($partnerName): Mixed{
        try{

        echo $partnerName;
        // $query = trim($partnerName); 
        return [];
        // $query = parent::openLink()->query("SELECT * FROM partner WHERE name LIKE :search LIMIT 50", ['search' => "%$query%"]);
        // $data = $query->fetchAll(PDO::FETCH_OBJ);
        // return ["status" => "success","data" => $data];
    }catch(Exception $e){
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }

    }
    public static function fetchDifferentCurrency(): Mixed{
        try{

       
        $query = parent::openLink()->query(
         "SELECT DISTINCT currency FROM `currency`");
        $data = $query->fetchAll(PDO::FETCH_OBJ);
        return $data;
        }catch(Exception $e){
            return self::response("Internal Server Error.".$e->getMessage(),false,);
        }

    }
  
    public static function fetchAllBlockedPartnerPaymentPlatforms($partner_id){
        
     try{
         $sql = "SELECT blocked_payment_platforms FROM  partners_v1 WHERE partner_id = :partner_id";
         $stmt = parent::openLink()->query($sql, [":partner_id" => $partner_id]);
         $data = $stmt->fetch(PDO::FETCH_ASSOC);
       return ["status" => "success", "data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => "Internal Server Error.". $e->getMessage()];       
    }
    }

    public static function fetchAllPaymentPlatforms(): array{
        try{
            $sql = "SELECT cid FROM  payment_platforms";
            $stmt = parent::openLink()->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return ["status" => "success", "data" => $data];
       }catch(Exception $e){
           return ["status" => "error", "data" => "Internal Server Error."];       
       }
       }

    public static function response($data,$type = true) {  return ["status" => $type ? "success" : "error" , "data" => $data];  }
}
<?php


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class PaymentPlatformModel extends MedooOrm{


    public static function fetchPaymentPlatforms(): Mixed{

        try{
        $table_name = "currency";
        $res = parent::openLink()->query("SELECT * FROM {$table_name} WHERE currency_type ='fiat' " )->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.",false,);
    }
    }

    public static function fetchPaymentPlatformsForPartner($page = 1,$limit = 20): Mixed{

        try{
        $table_name = "enzerhub_currency";
        $offset = ($page - 1) * $limit;
        $res = parent::openLink()->query("SELECT * FROM {$table_name} ORDER BY cid DESC LIMIT :offset,:limit", [":offset" => $offset, ":limit" => $limit ])->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.",false,);
    }
    }



    public static function searchPaymentPlatform($searchData = []): Mixed{


        
        try{
        
        $table_name = "enzerhub_currency";
        $offset = ($searchData["page"] - 1) * 10;
        $params = [":offset" => (int) $offset, ":limit" => (int) $searchData["limit"]];
        $db_fields = ["platformID" => "payment_type_id", "currency" => "currency","status" => "status" , "startDate" => "date_created","endDate" => "date_created"];
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

        $sql = "SELECT * FROM {$table_name} ".(empty($where_clause) ? "" : " WHERE ".implode(" AND ",$where_clause)) ." LIMIT :offset,:limit";

        $res = parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success", "data" => $res];
    }catch(Exception $e){
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
    }

    public static function addNewPaymentPlaftorm($searchData = []): Mixed{
        
        try{
            
        $table_name = "enzerhub_currency";
        $map = [];
        foreach($searchData as $key => $value) {
            $map[":$key"] = $value;
        }

        $sql = "INSERT INTO $table_name (payment_type_id, name, status, created_by, date_created, currency, fee, site_url, admin_site_url, last_update, last_update_by, min_amount, max_amount,info,priority,countries) VALUES (:payment_type_id, :name, :status, :created_by, :date_created, :currency, :fee, :site_url, :admin_site_url, :last_update, :last_update_by, :min_amount, :max_amount,:info,:priority,:countries);";

        $stmt      = parent::openLink()->query($sql, $map);
        $row_count = $stmt->rowCount();
        return ["status" => "success", "data" => $row_count,"id" => parent::openLink()->id()];
    }catch(Exception $e){

        if($e->getCode() == 23000){
            return ["status" => "error", "data" => $searchData['name']." payments already added."];
        }
        return self::response("Internal Server Error.".$e->getCode(),false,);
    }
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



    public static function searchPlatformNames($db_id,$platformName): Mixed{
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
  


    public static function response($data,$type = true) {  return ["status" => $type ? "success" : "error" , "data" => $data];  }
}
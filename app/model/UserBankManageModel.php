<?php



set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

class UserBankManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// Bank Card  LIST -//////////

    public static function FetchBankcardlistData(array $filters = [], $page = 1, $limit = 20): array
    {

        try{

        $db = parent::getLink();
        $offset = ($page - 1) * $limit;
        $whereClause = "";
        $table_name = "user_bank";
        $params  = [":offset" => $offset,":limit" => $limit];
        foreach ($filters as $db_column => $value) {
            if(!empty($value)){
                $whereClause .= empty($whereClause) ? " {$table_name}.{$db_column}=:{$db_column} " : " AND  {$table_name}.{$db_column}=:{$db_column}" ;
                $params[":{$db_column}"]      = $value;
            }
        }

      $whereClause = empty($whereClause) ? " " : " WHERE {$whereClause} ";
        $sql = "SELECT user_bank.*,(SELECT COUNT(*) FROM user_bank {$whereClause} ) AS total_records, users_test.username, users_test.nickname, users_test.email
            FROM user_bank
            JOIN users_test ON user_bank.uid = users_test.uid 
            {$whereClause} 
            ORDER BY bank_id DESC
            LIMIT :offset, :limit";

        $stmt = $db->query($sql,
            $params
        );
       
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success","data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => "Internal Server Error."];

}

}

    public static function fetchBankTypes($bank_type): array
    {

        try{
        $db = parent::getLink();
        $stmt = $db->query(
            "SELECT bank_type FROM user_bank WHERE bank_type LIKE :bank_type GROUP BY bank_type ORDER BY bank_type DESC ",
            [":bank_type" => "%{$bank_type}%"]
        );
        
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return ["status" => "success","data" => $data];
    }catch(Exception $e){
        return ["status" => "error", "data" => "Internal Server Error.".$e->getMessage()];

}

}


}
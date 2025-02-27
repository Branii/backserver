<?php



set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class GameManageModel extends MEDOOHelper
{

    public static function getTables()
    {
        $result = parent::selectAll('gamestable_map', '*');
        $gameTable = [];
        foreach ($result as $value) {
            $gameTable[$value['game_type']] = [
                'draw_table' => $value['draw_table'],
                'bet_table' => $value['bet_table'],
                'draw_storage' => $value['draw_storage']
            ];
        }
        return $gameTable;
    }
    public static function getAllGames()
    {
        return parent::selectAll('game_type', ['gt_id', 'name']);
    }

    public static function getAllGamesLottery()
    {
        return parent::selectAll('lottery_type', ['lt_id', 'name']);
    }

    public static function getLotteryGamesById(string $lotteryId, $gamemodel)
    {
        $bigData = [];

        if (in_array($lotteryId, [1,2,3,5,6,8,10]) && in_array($gamemodel, ['standard', 'twosides','longdragon','boardgames','roadbet'])) {
            $tableMap = [
                'standard'  => 'game_name',
                'twosides'  => 'twosides',
                'longdragon'  => 'longdragon',
                'boardgames'  => 'boardgames',
                'roadbet'  => 'roadbet',
                'fantan'  => 'fantan',
                'manytables'  => 'manytables'
            ];
            $tableName = $tableMap[$gamemodel];
            $sql = "SELECT gn_id, name, modified_odds, group_type, modified_totalbet, gameplay_name, total_bets,model,
                          oddspercentage,totalbetpercentage,odds,total_bets
                    FROM {$tableName} WHERE lottery_type = :lotteryId";
        
            $data = parent::query($sql, ['lotteryId' => $lotteryId]);
            return ['data' => $data] ;
        }

        // foreach ($tables as $table) {
        //     $sql = "SELECT gn_id,name, modified_odds,group_type, modified_totalbet, gameplay_name,total_bets
        //     FROM {$table} WHERE lottery_type = :lotteryId";

        //     $data = parent::query($sql, ['lotteryId' => $lotteryId]);

        //     $bigData[$table] = $data;
        // }
      //  return  $bigData;
    }

    //public static 
   

    public static function UpdateOddsTotalbets($gameId,$gamemodel,$newodds,$oddpercent,$newtotalbet,$totalbetpercent)
    {
      
        if ( in_array($gamemodel, ['standard', 'twosides','longdragon','boardgames','roadbet'])) {
            $tableMap = [
                'standard'  => 'game_name',
                'twosides'  => 'twosides',
                'longdragon'  => 'longdragon',
                'boardgames'  => 'boardgames',
                'roadbet'  => 'roadbet',
                'fantan'  => 'fantan',
                'manytables'  => 'manytables'
            ];
            $tableName = $tableMap[$gamemodel];
            $sql = "UPDATE {$tableName} 
            SET modified_odds = :modified_odds,
                oddspercentage = :oddspercentage,
                modified_totalbet = :modified_totalbet,
                totalbetpercentage = :totalbetpercentage
              WHERE gn_id = :gn_id";

    try {
        $data = parent::query($sql, [
            'modified_odds'        => $newodds,
            'oddspercentage'       => $oddpercent,
            'modified_totalbet'    => $newtotalbet,
            'totalbetpercentage'   => $totalbetpercent,
            'gn_id'         => $gameId
        ]);

        if($data > 1){
           $data = self::getLotteryGamesById($gameId, $gamemodel);
        }

      

        return ['success' => true, 'message' => 'Update successful', 'data' => $data];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Database update failed', 'error' => $e->getMessage()];
    }
        }
    
     
    }
    



    public static function filterGameDraws($page, $limit, $gameId, $datefrom, $dateto)
    {
        try {
            $startpoint = ($page * $limit) - $limit;
            $conditions = self::filterConditions($datefrom, $dateto);
            $where = $conditions['where'];
            $params = $conditions['params'];
            $drawTable = self::getTables()[$gameId]['draw_table'];
            $data = parent::query(
                "SELECT * FROM " . $drawTable . " " . $where . "
            ORDER BY draw_id DESC LIMIT :offset, :limit",
                array_merge($params, ['offset' => $startpoint, 'limit' => $limit])
            );

            $totalRecords = parent::query(
                "SELECT * FROM " . $drawTable . " " . $where . "ORDER BY draw_id DESC",
                array_merge($params)
            );

            return ['data' => $data, 'total' => count($totalRecords)];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public static function filterConditions($datefrom = '', $dateto = '')
    {
        $where = '';
        $params = [];
        if ($datefrom && $dateto) {
            $where .= "WHERE date_created >= :datefrom AND date_created <= :dateto";
            $params['datefrom'] = $datefrom;  // Set datefrom parameter
            $params['dateto'] = $dateto;      // Set dateto parameter
        } elseif ($datefrom) {
            $where .= "WHERE date_created = :datefrom";
            $params['datefrom'] = $datefrom;
        } elseif ($dateto) {
            $where .= "WHERE date_created = :dateto";
            $params['dateto'] = $dateto;
        }
        return ['where' => $where, 'params' => $params];
    }


    public static function fetchGameTypesForLottery($lottery_id, $current_page = 1, $recordsPerPage = 20)
    {

        try{

            

        $offset = ($current_page - 1) * $recordsPerPage;
        $database = parent::openLink();
        $whereClause = empty($lottery_id) ? "" : " WHERE game_type.lottery_type = :lottery_id ";

        $sql = "SELECT lottery_type.*, game_type.*, 
            (SELECT COUNT(*) FROM game_type 
             JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id $whereClause ) AS total_count 
            FROM game_type 
            JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id 
            $whereClause 
            ORDER BY game_type.gt_id  DESC
            LIMIT :offset, :recordsPerPage";

        $params = [":offset" => $offset, ":recordsPerPage" => $recordsPerPage];
        if ($whereClause) {
            $params[":lottery_id"] = $lottery_id;
        }

        $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);

        return ['status' => "success", 'data' => $data];

    }catch(Exception $e){

        return ['status' => "success", 'data' => "Internal Server Error.". $e->getMessage()];
    }

    }


    

    public static function fetchBonusTwoSides($lottery_id,$game_group_name)
    {

        try{

          
        $database = parent::openLink();
        $table_name = "twosides_group";
        $sql = "SELECT {$table_name}.odds_group_id AS odds_group_id, {$table_name}.game_play_id, {$table_name}.label AS label, {$table_name}.odds AS odds, {$table_name}.rebate AS rebate, {$table_name}.profit AS profit , twosides.gn_id AS twosides_gn_id, twosides.name AS twosides_name FROM {$table_name} JOIN twosides ON {$table_name}.game_play_id = twosides.gn_id JOIN game_group ON game_group.gp_id = twosides.game_group WHERE game_group.name = :game_group_name AND game_group.lottery_type =:lottery_type";
        $params = [":lottery_type" => $lottery_id, ":game_group_name" => $game_group_name];
        $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return ['status' => "success", 'data' => $data];

    }catch(Exception $e){

        return ['status' => "success", 'data' => "Internal Server Error.".$e->getMessage()];
    }

    }
    public static function updateGameGroupData($data)
    {

        try{

          
        $sql = "";
        $database = parent::openLink();
        $table_name = "twosides_group";
        foreach($data as $odds_group_id => $info){
        $sql .= "UPDATE {$table_name} SET odds=:odds_{$odds_group_id} , max_bet_amt=:max_bet_amt_{$odds_group_id}, max_total_bet_amt=:max_total_bet_amt_{$odds_group_id} WHERE odds_group_id=:odds_group_id_{$odds_group_id}:";
        $params[":odds_{$odds_group_id}"] = $info["odds"]; 
        $params[":max_bet_amt_{$odds_group_id}"] = $info["max_amt"]; 
        $params[":max_total_bet_amt_{$odds_group_id}"] = $info["max_tot_amt"]; 

        }
        $data = $database->query($sql, $params);
        return ['status' => "success", 'data' => $data->rowCount()];

    }catch(Exception $e){

        return ['status' => "success", 'data' => "Internal Server Error.".$e->getMessage()];
    }

    }



    public static function updateLotteryData($maxPrizeAmountPerBet,$maxAmtPerIssue, $maxWinPerPersonPerIssue,$minBetAmtPerIssue,$lockTimeForClsing,$sortingWeight,$lottery_type,$game_type_id): array {
        try{

            if($sortingWeight < 1)return ["status" => "error", "data" => "Sorting Weight must be greater than zero."];


            // return [":maximum_prize_per_bet" => $maxPrizeAmountPerBet, ':maximum_amount_per_issue' => $maxAmtPerIssue,':maximum_win_per_issue' => $maxWinPerPersonPerIssue, ':minimum_amount_per_issue' => $minBetAmtPerIssue, ':closing_time' => $lockTimeForClsing, ':game_type_id' => $game_type_id ];
        $database = parent::openLink();
        $swaped_game_ids = [];
        $stmt = $database->query("SELECT sort_weight FROM lottery_type WHERE lt_id=:lt_id",[':lt_id' => $lottery_type]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $lottery_type_sort_weight = $data->sort_weight;
        $lottery_type_sort_weight =  json_decode($lottery_type_sort_weight,true);
        $sorting_weight_flipped   = array_flip($lottery_type_sort_weight);
       
        if(empty($sorting_weight_flipped) || !in_array((int) $sortingWeight,$lottery_type_sort_weight)){
            $lottery_type_sort_weight[$game_type_id] = $sortingWeight;
        }else{
         
          $res =  self::swapElements($lottery_type_sort_weight,$game_type_id,$sortingWeight,$sorting_weight_flipped[$sortingWeight]);
            if(!$res){
                return ['status' => "error", 'data' => "Duplicated Sorting Weight"];
            }

            $swaped_game_ids = $res; 
        }
            
        $sorting_weight = $database->query("UPDATE lottery_type SET sort_weight = :sorting_weight  WHERE lottery_type.lt_id = :lottery_id
            ",[":sorting_weight" => json_encode($lottery_type_sort_weight), ':lottery_id' => (int) $lottery_type ]);


        $stmt = $database->query("UPDATE game_type SET maximum_prize_per_bet = :maximum_prize_per_bet,maximum_win_per_issue = :maximum_win_per_issue,maximum_amount_per_issue = :maximum_amount_per_issue, minimum_amount_per_issue = :minimum_amount_per_issue , closing_time =:closing_time  WHERE game_type.gt_id = :game_type_id
            ",[":maximum_prize_per_bet" => (int) $maxPrizeAmountPerBet, ':maximum_amount_per_issue' => (int) $maxAmtPerIssue,':maximum_win_per_issue' => (int) $maxWinPerPersonPerIssue, ':minimum_amount_per_issue' => (int) $minBetAmtPerIssue, ':closing_time' => (int) $lockTimeForClsing, ':game_type_id' => (int) $game_type_id ]); 
     


        return ['status' => "success", 'data' => $stmt->rowCount(),"swapped" => $swaped_game_ids, "sorting_weight" => $sorting_weight->rowCount()];

    }catch(Exception $e){

        return ['status' => "success", 'data' => "Internal Server Error."];
    }

    }

    public static function updateLotteryStatus($game_type_id,$status): array {
        try{
        $status = ["gameon" => 1 , "gameoff" => -1][$status];
        $database = parent::openLink();
        $stmt = $database->query("UPDATE game_type SET state = :state  WHERE game_type.gt_id = :game_type_id
            ",[":state" => $status, ':game_type_id' => (int) $game_type_id ]);
        return ['status' => "success", 'data' => $stmt->rowCount()];

    }catch(Exception $e){

        return ['status' => "success", 'data' => "Internal Server Error.". $e->getMessage()];
    }

    }



    public static function fetch_draw_info_game_type($game_type = 1)
    {

        try{

        $db = parent::getLink();
        $sql = "SELECT draw_table,bet_table FROM gamestable_map WHERE game_type = :game_type";
        $stmt = $db->query($sql,[':game_type' => (int) $game_type]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return ['status' => 'success', 'data' => $data];
        }catch(Exception $e){
            return ['status' => "error", 'data' => "Internal Server 
            Erro"];
        }
    }


    public static function getDrawTableInfo($game_type,$issue_number = 0,$status = "",$startDate  = "", $endDate = "", int $currentPage = 1, int $limit = 20)
    {


        $res = self::fetch_draw_info_game_type($game_type);
        if($res['status'] === "error") return ["status" => 'error', 'data' => "Internal Server error."];
        $db = parent::getLink();
        $offset = ($currentPage - 1) * $limit;
        $res = $res['data'];
        $drawtable = $res->draw_table;
        $bet_table = $res->bet_table;
        $params = [':offset' => (int) $offset, ':limit' => $limit ];

        $whereClause = "";
        if(!empty($game_type)){
            $params[":game_type"] = $game_type;
            $whereClause = empty($whereClause) ?  " {$drawtable}.lottery_type=:game_type " : " AND {$drawtable}.lottery_type=:game_type ";
        }
        if(!empty($issue_number)){
            $params[":issue_number"] = $issue_number;
            $whereClause .=  empty($whereClause) ? " period=:issue_number " : " AND period=:issue_number ";
        }
        if(!empty($status)){
            $params[":draw_status"] = $status;
            $whereClause .=  empty($whereClause) ? " draw_status=:draw_status " : " AND draw_status=:draw_status ";
        }

         if (!empty($startDate) && empty($endDate)){
            $whereClause .= empty($whereClause) ? " time_added = :start_date " : " AND time_added = :start_date ";
            $params[':start_date'] = $startDate;
        } elseif (empty($startDate) && !empty($endDate)) {
            $whereClause .= empty($whereClause) ? " time_added = :end_date " : " AND time_added = :end_date ";
            $params[':end_date'] = $endDate;
        } elseif (!empty($startDate) && !empty($endDate)) {
            $start = min($startDate, $endDate);
            $end   = max($startDate, $endDate);
            $whereClause .= empty($whereClause) ? " time_added BETWEEN :start_date AND :end_date  " : " AND time_added BETWEEN :start_date AND :end_date ";
            $params[':start_date'] = $start;
            $params[':end_date'] = $end;
        }

        $whereClause = empty($whereClause) ? "" : " WHERE {$whereClause} ";

         $sql    = "SELECT *,{$drawtable}.closing_time as my_closing,(SELECT COUNT(*) FROM  {$drawtable}) as total_records, (SELECT COUNT(*) FROM {$bet_table} WHERE draw_period = {$drawtable}.period) as totalIssueBet, (SELECT SUM(bet_amount) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period) as sumTotalAmount,(SELECT SUM(win_bonus) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period AND bet_status = 2) as total_won_amount,(SELECT SUM(win_bonus) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period AND bet_status = 3) as total_lose_amount FROM {$drawtable} JOIN game_type ON {$drawtable}.lottery_type = game_type.gt_id {$whereClause}  ORDER BY draw_id DESC LIMIT :offset, :limit";
        $stmt   = $db->query($sql,$params);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        $data = [];

        foreach($result as $key => $value){
            $data[] = ['lottery_type' => $value->name, 'lottery_code' => $value->game_group , 'issue_number' => $value->period , 'winning_numbers' => implode(',',json_decode($value->draw_number)), 'total_bet_amount' => $value->sumTotalAmount ?? 0 , 'total_win_amount' => $value->total_won_amount ?? 0, 'draw_time' => str_replace(' ','/',$value->time_added), 'sales_deadline' => str_replace(' ','/',$value->my_closing), 'actual_draw_time' => str_replace(' ','/',$value->time_added), 'settlement_completion_time' => str_replace(' ','/',$value->settlement_completion_time ?? 0) ,'status' => $value->draw_status, 'total_records' => $value->total_records] ;
        }
        return ['status' => 'success','data' => $data];
    }


    public static function swapElements(&$array, $element1 = 0,$element1NewWeight = 0, $element2 = 0) {
       try{

      
        $element1 = (int) $element1;
        $element2 = (int) $element2;

        if(!array_key_exists($element2,$array)){
            $array[$element1] = $element1NewWeight;
            return true;
        }
        if (!array_key_exists($element1,$array) || !array_key_exists($element2,$array)) {
            return false; // Ensure elements exist
        }


        $element1OldWeight = $array[$element1];

        if((int) $element1OldWeight == ($element1NewWeight)){
        return false;
        }
  
        $array[$element1] = $element1NewWeight;
        $array[$element2] = $element1OldWeight;
        return [$element1, $element2]; // Successful swap

    }catch(Exception $e){
        echo $e->getMessage();
        return ["status" => "error", "data" => $e->getMessage()];
       }
    }

}

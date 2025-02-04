<?php


class adminController extends Controller {

    public function notfound() {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function index(){
        $this->view('html/signin');
        $this->view->render();
    }

    public function home(){
        $this->view('html/home');
        $this->view->render();
    }

    public function signin(){
        $this->view('exec/signin');
        $this->view->render();
    }

    public function signout(){
        $this->view('exec/signout');
        $this->view->render();
    }

    public function admins($data){
        $this->view('exec/admins_exec',['flag'=> 'addNewAdmin', 'data' => $data]);
        $this->view->render();
    }

    public function alladmins($pageNumber,$limit){
        $this->view('exec/admins_exec',['flag'=> 'viewAdmins','page'=>$pageNumber,'limit'=>$limit, ]);
        $this->view->render();
    }

    public function permissions($data, $adminId){
        $this->view('exec/admins_exec',['flag'=> 'permissions','permissionsData'=>$data,'userId'=>$adminId]);
        $this->view->render();
    }

    public function adminlogs($pageNumber,$limit,$adminId){
        $this->view('exec/admins_exec',['page'=>$pageNumber,'limit'=>$limit, 'flag'=> 'adminlogs','userId'=>$adminId]);
        $this->view->render();
    }

    public function searchlogs($pageNumber,$limit,$adminId,$query){
        $this->view('exec/admins_exec',[
            'page'=>$pageNumber,
            'limit'=>$limit,
            'flag'=> 'searchlogs',
            'userId'=>$adminId,
            'query'=>$query,
            ]
        );
        $this->view->render();
    }

    public function filterAdminLogs($pageNumber, $limit, $adminId, $datefrom, $dateto){
        $this->view('exec/admins_exec',[
            'page'=>$pageNumber,
            'limit'=>$limit, 
            'flag'=> 'filterAdminLogs',
            'userId'=>$adminId,
            'datefrom'=>$datefrom,
            'dateto'=>$dateto
        ]);
        $this->view->render();
    }

    public function getAllBackups($pageNumber,$limit){
        $this->view('exec/admins_exec',data: ['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'getAllBackups']);
        $this->view->render();
    }

    public function getAllgames(){
        $this->view('exec/game_management',['flag' => 'getAllgames']);
        $this->view->render();
    }

    public function getSpecificDraws($gameId, $datefrom, $dateto, $pageNumber, $limit){
        $this->view('exec/game_management',[
        'page'=>$pageNumber,
        'limit'=>$limit, 
        'flag'=> 'getSpecificDraws',
        'gameId'=>$gameId,
        'datefrom'=>$datefrom,
        'dateto'=>$dateto
    ]);
    $this->view->render();
    }

    public function backup(){
        $this->view('exec/admins_exec', [
            'flag'=>'backup'
        ]);
        $this->view->render();
    }

    // side bar datas adminLogs

    public function transactiondata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'transactiondata']);
        $this->view->render();
    }

    public function gamebetdata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'gamebetdata']);
        $this->view->render();
    }

    public function filterusername($username)
    {
        $this->view('exec/businessflow', ['username' => $username, 'flag' => 'filterusername']);
        $this->view->render();
    }

    public function filtertransactions($username,$orderid,$ordertype,$startdate,$enddate,$pageNumber,$limit){
        $this->view('exec/businessflow',[
            'username' => $username,'orderid' => $orderid,
            'ordertype' => $ordertype,'startdate' => $startdate,
            'enddate' => $enddate, 'flag' => 'filtertransactions',
            'page'=>$pageNumber,'limit'=>$limit,

        ]);
        $this->view->render();
    }

    public function getTransactionBet($transactionId){
        $this->view('exec/businessflow',['transactionId'=>$transactionId, 'flag' => 'getTransactionBet']);
        $this->view->render();
    }

   //NOTE -
    //////////////LOTTERY BETS -//////////

    public function lotterydata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'lotterydata']);
        $this->view->render();
    }

    public function viewBetstake($becode){
        $this->view('exec/businessflow',['betcode'=>$becode,'flag' => 'viewBetstake']);
        $this->view->render();
    }

    public function fetchLotteryname(){
        $this->view('exec/businessflow',['flag' => 'fetchLotteryname']);
        $this->view->render();
    }
 
    public function filterbetdata($uid,$gametype,$betstate,$betstatus,$startdate,$enddate,$page,$limit){
        $this->view('exec/businessflow',[
        'uid'=>$uid,
        'gametype'=>$gametype,
        'betstate'=>$betstate,
        'betstatus'=>$betstatus,
        'startdate'=>$startdate,
        'enddate'=>$enddate,
        'page'=>$page,
        'limit'=>$limit,
        'flag' => 'filterbetdata']);
        $this->view->render();
    }
    
    public function searchusername($username){
        $this->view('exec/businessflow',['username'=>$username,'flag' => 'searchusername']);
        $this->view->render();
    }


    // --- MUNIRU ----
    public function searchLotteryName($lottery_name){
        $this->view('exec/win_loss',['lottery_name'=>$lottery_name,'flag' => 'filter-lotteries']);
        $this->view->render();
    }
    public function searchWinLossUser($user_id,$lottery_id,$start_date,$end_date){
   
        $this->view('exec/win_loss',['user_id'=>$user_id,'lottery_id' => $lottery_id,'start_date' => $start_date,'end_date' => $end_date,'flag' => 'search-user-win-loss']);
        $this->view->render();
    }
    public function fetchTopAgents($lottery_id,$start_date,$end_date,$page,$limit){
      
        $this->view('exec/win_loss',['lottery_id' => $lottery_id,'start_date' => $start_date,'end_date' => $end_date,'page' => $page,'limit' => $limit,'flag' => 'get-top-agents']);
        $this->view->render();
    }
    public function fetchAgentSubs($agent_id,$lottery_id,$start_date,$end_date,$page,$limit){
        $this->view('exec/win_loss',["agent_id" => $agent_id,'lottery_id' => $lottery_id,'start_date' => $start_date,'end_date' => $end_date,'page' => $page,'limit' => $limit,'flag' => 'get-agent-subs']);
        $this->view->render();
    }
    public function getUserDetails($user_id,$lottery_id,$start_date,$end_date,){
        $this->view('exec/win_loss',['user_id' => $user_id,'lottery_id' => $lottery_id,'start_date' => $start_date,'end_date' => $end_date,'flag' => 'get-user-details']);
        $this->view->render();
    }

    # withdrawl Records
    public function searchWidrlRecords($userID,$widrlID, $widrlChannels,$widrlStatus,$widrlStartDate,$widrlEndDate,$page,$limit){
        
        $this->view('exec/withdrawal_records',['user_id'=> $userID, 'widrl_id' => $widrlID, 'widrl_channels' => $widrlChannels, 'widrl_status' => $widrlStatus, 'widrl_start_date' => $widrlStartDate, 'widrl_end_date' => $widrlEndDate, 'page' => $page,'limit' => $limit, 'flag' => 'filter_records' ]);
        $this->view->render();
    }



     //NOTE -
    //////////////TRACK BET DATA -//////////
    public function trackdata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'trackdatas']);
        $this->view->render();
    }
    
    public function filterTrackdata($username,$trackstatus,$tracklotery,$startdate,$enddate,$page,$limit){
        $this->view('exec/businessflow',[
        'username'=>$username,
        'trackstatus'=>$trackstatus,
        'tracklotery'=>$tracklotery,
        'startdate'=>$startdate,
        'enddate'=>$enddate,
        'page'=>$page,
        'limit'=>$limit,
        'flag' => 'filterTrack']);
        $this->view->render();
    }
    public function  getTrackbet($tracktoken){
        $this->view('exec/businessflow',['token'=>$tracktoken, 'flag' => 'getTrackbet']);
        $this->view->render();
    }
    public function  getAllTokenbet($tracktoken){
        $this->view('exec/businessflow',['token'=>$tracktoken, 'flag' => 'getTracktokenbet']);
        $this->view->render();
    }


    

   //

    //NOTE -
    ////////////// USERLIST LIST -//////////
    public function userlistdata($pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlistdata']);
        $this->view->render();
    }


    /// ----- WIN LOSS REPORT --------------------------------
    public function users_win_loss($lottery_id, $start_date,$end_date, $page,$limit)
    {
        $this->view('exec/win_loss', ['lottery_id' => $lottery_id,'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page,"limit"=> $limit, 'flag' => 'users-win-loss']);
        $this->view->render();
    }
    public function get_top_agents($lottery_id, $start_date,$end_date,$page)
    {
        
        $this->view('exec/win_loss', ['lottery_id' => $lottery_id,'start_date' => $start_date, 'end_date' => $end_date,'page' => $page ,'flag' => 'get-top-agents']);
        $this->view->render();
    }
    public function get_subs($user_id,$lottery_id, $start_date,$end_date,$page)
    {
     
        $this->view('exec/win_loss', ['user_id' => $user_id,'lottery' => $lottery_id,'start_date' => $start_date, 'end_date' => $end_date,'page' => $page ,'flag' => 'get-subs']);
        $this->view->render();
    }
    public function get_user_details($user_id,$lottery_id, $start_date,$end_date,$page)
    {
        $this->view('exec/win_loss', ['user_id' => $user_id,'lottery' => $lottery_id,'start_date' => $start_date, 'end_date' => $end_date,'flag' => 'get-user-details']);
        $this->view->render();
    }


    // -- Lottery Draw Records ------------------------
    public function fetch_lottery_basic_params($lottery_id,$page)
    {
        $this->view('exec/lottery_basic_params', ['lottery_id' => $lottery_id,'page' => $page,'flag' => 'fetch-lottery-basic-params']);
        $this->view->render();
    }
    // public function filteruserlist($username = '', $states = '', $startdate = '', $enddate = '', $pageNumber, $limit)
    // {
    //     $this->view('exec/account_manage', [
    //         'username' => $username,
    //         'states' => $states,
    //         'startdate' => $startdate,
    //         'enddate' => $enddate,
    //         'flag' => 'filteruserlist',
    //         'page' => $pageNumber,
    //         'limit' => $limit,

    //     ]);
    //     $this->view->render();
    // }

    public function fetchRebatedata()
    {
        $this->view('exec/account_manage', ['flag' => 'fetchRebatedata']);
        $this->view->render();
    }

    public function  addAgent($data)
    {
        $this->view('exec/account_manage', ['data' => $data,'flag' => 'addAgent']);
        $this->view->render();
    }

    public function  fetchTopAgent($pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['page' => $pageNumber, 'limit' => $limit,'flag' => 'fetchTopAgent']);
        $this->view->render();
    }

    public function  getuserrebate($uid)
    {
        $this->view('exec/account_manage', ['uid' => $uid, 'flag' => 'getuserrebate']);
        $this->view->render();
    }

    public function updateUsedquota($uid,$bonus_group,$rebate_group,$quata_group,$count_group)
    {
        $this->view('exec/account_manage',[
        'uid' => $uid, 'bonus'=>$bonus_group,
        'rebate'=>$rebate_group,'quota'=>$quata_group,
        'count'=>$count_group,
        'flag' => 'updateUsedquota']);
        $this->view->render();
       
    }
    

  
     //NOTE -
    ////////////// USERLIST LOGS -//////////
    public function userlogsdata($pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlogsdata']);
        $this->view->render();
     }
    // public function filterUserlogs($username = '',  $startdate = '', $enddate = '', $pageNumber, $limit)
    // {
    //     $this->view('exec/account_manage', ['username' => $username,'startdate' => $startdate,
    //     'enddate' => $enddate,'flag' => 'filterUserlogs','page' => $pageNumber,'limit' => $limit,]);
    //     $this->view->render();
    // }


  
      //NOTE -
    //////////////INVITATION & REFERAL LINK -//////////
    public function userlinkdata($pageNumber, $limit)
    {
        $this->view('exec/promotion_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlinkdata']);
        $this->view->render();
    }

    // public function  filterUserlinks($username = '',  $startdate = '', $enddate = '', $pageNumber, $limit)
    // {
    //     $this->view('exec/promotion_manage', ['username' => $username,'startdate' => $startdate,
    //     'enddate' => $enddate,'flag' => 'filterUserlinks','page' => $pageNumber,'limit' => $limit,]);
    //     $this->view->render();
    // }

      //NOTE -
    //////////////Quota Settings -//////////
    // 
    public function fetchquota($pageNumber, $limit)
    {
        $this->view('exec/agentmanage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchquota']);
        $this->view->render();
    }
    public function updatequota($rebateid, $quota)
    {
        $this->view('exec/agentmanage', ['rebateid' => $rebateid, 'quota' => $quota, 'flag' => 'updatequota']);
        $this->view->render();
    }
    public function UpdateAllquota($quota)
    {
        $this->view('exec/agentmanage', ['quota' => $quota, 'flag' => 'UpdateAllquota']);
        $this->view->render();
    }

    public function filterRebate($rebate)
    {
        $this->view('exec/agentmanage', ['rebate' => $rebate, 'flag' => 'filterRebate']);
        $this->view->render();
    }


 
       //NOTE -
    //////////////Finance funds Records -//////////
    // 
    public function fetchfinance($pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchfinance']);
        $this->view->render();
    }
    public function addmoney($depositetype,$uid,$amount,$approvedby,$review)
    {
        $this->view('exec/financial_manage', ['depositetype' => $depositetype,'uid'=>$uid,
        'amount' => $amount, 'approvedby' => $approvedby,'review'=>$review,'flag' => 'addmoney']);
        $this->view->render();
    }

    public function filterfinance($uid,$depositestate,$startfinance,$endfinance,$page,$pageLimit)
    {
        $this->view('exec/financial_manage', [
        'uid' => $uid,
        'status' => $depositestate,
        'startdate' => $startfinance,
        'enddate' => $endfinance,
        'page' => $page,
        'limit' => $pageLimit,
        'flag' => 'filterfinance'
    ]);
        $this->view->render();

    }
   
        //NOTE -
    //////////////Deposit Records -//////////
    // 
    public function fetchDeposit($pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber,'limit' => $limit, 'flag' => 'fetchDeposit']);
        $this->view->render();
    }

    public function filterdeposits($uid,$depositchanel,$depositid,$stautsdeposit,$startdepo,$enddepo,$page,$pageLimit)
    {
        $this->view('exec/financial_manage', [
        'uid' => $uid,
        'states' => $depositchanel,
        'depositid' => $depositid,
        'depostatus' => $stautsdeposit,
        'startdate' => $startdepo,
        'enddate' => $enddepo,
        'page' => $page,
        'limit' => $pageLimit,
        'flag' => 'filterdeposit'
    ]);
        $this->view->render();

    }
   
    
     //NOTE -
    //////////////Withdrawal Records -//////////
    // 
    public function fetchwithdraw($pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber,'limit' => $limit, 'flag' => 'fetchwithdraw']);
        $this->view->render();
    }


     //NOTE -
    //////////////Bank Cardlist Records -//////////
    // 
    public function   fetchbankcard($pageNumber, $limit)
    {
        $this->view('exec/userbank_manage', ['page' => $pageNumber,'limit' => $limit, 'flag' => 'fetchbankcard']);
        $this->view->render();
    }
  
   //NOTE -
    //////////////lottery bounus Parameter -//////////
    // 
    public function fetchgames(){
        $this->view('exec/game_manage',['flag' => 'fetchgames']);
        $this->view->render();
    }

    // public function fetchgamebyid($gameid,$tablename){
    //     $this->view('exec/game_manage',['gameid' =>$gameid,'tablename'=>$tablename, 'flag' => 'fetchgamebyid']);
    //     $this->view->render();
    // }

    public function getAllGamesLottery(){
        $this->view('exec/game_management',['flag' => 'getAllGamesLottery']);
        $this->view->render();
    }

    public function getLotteryGames(string $lotterId, string $tables){
        $this->view('exec/game_management',[
            'flag' => 'getLotteryGames',
            'gameId' => $lotterId,
            'tables' => $tables
        ]);
        $this->view->render();
    }

 

    //languages

     public function changelang(string $lang){
        $this->view('exec/switchlang',['lang' => $lang]);
        $this->view->render();
    }

    
}
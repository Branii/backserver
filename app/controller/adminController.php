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

    // public function filtertransactions($username ='',$orderid ='',$ordertype ='',$startdate ='',$enddate ='',$pageNumber,$limit){
    //     $this->view('exec/businessflow',[
    //         'username' => $username,'orderid' => $orderid,
    //         'ordertype' => $ordertype,'startdate' => $startdate,
    //         'enddate' => $enddate, 'flag' => 'filtertransactions',
    //         'page'=>$pageNumber,'limit'=>$limit,

    //     ]);
    //     $this->view->render();
    // }

    public function getTransactionBet($transactionId){
        $this->view('exec/businessflow',['transactionId'=>$transactionId, 'flag' => 'transactionBet']);
        $this->view->render();
    }

   //NOTE -
    //////////////LOTTERY BETS -//////////

    public function lotterydata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'lotterydata']);
        $this->view->render();
    }

    public function viewBetstake($becode,$gametype){
        $this->view('exec/businessflow',['betcode'=>$becode, 'gametype'=>$gametype,'flag' => 'viewBetstake']);
        $this->view->render();
    }

    public function fetchLotteryname(){
        $this->view('exec/businessflow',['flag' => 'fetchLotteryname']);
        $this->view->render();
    }
    
    public function searchusername($username){
        $this->view('exec/businessflow',['username'=>$username,'flag' => 'searchusername']);
        $this->view->render();
    }

    public function filterbetdata($betdata,$limit){
        $this->view('exec/businessflow',['limit'=>$limit,'betdata'=>$betdata,'flag' => 'filterbetdata']);
        $this->view->render();
    }

     //NOTE -
    //////////////TRACK BET DATA -//////////
    public function trackdata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'trackdata']);
        $this->view->render();
    }


    //NOTE -
    ////////////// USERLIST LIST -//////////
    public function userlistdata($pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlistdata']);
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
        $this->view('exec/agentmanage', ['quota' => $rebate, 'flag' => 'filterRebate']);
        $this->view->render();
    }
    
}
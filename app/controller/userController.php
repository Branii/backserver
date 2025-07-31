<?php

class userController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

    //NOTE -
    //////////////USERS FUNCTIONS -//////////

   public function userlistdata($partnerID, $uid, $recharge_level, $state, $start_date, $end_date, $pageNumber, $limit, $miscelleanous)
    {


        $this->view('exec/account_manage', ["partner_id" => $partnerID, 'uid' => $uid, 'recharge_level' => $recharge_level, 'state' => $state, 'startdate' => $start_date, 'enddate' => $end_date, 'page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlistdata']);
        $this->view->render();
    }

        public function filteruserlist($partnerID, $pageNumber, $limit)
    {
        $this->view('exec/account_manage', [
            'partner_id' => $pageNumber,
            'flag' => 'filteruserlist',
            'page' => $pageNumber,
            'limit' => $limit,

        ]);
        $this->view->render();
    }

        public function fetchRebatedata()
    {
        $this->view('exec/account_manage', ['flag' => 'fetchRebatedata']);
        $this->view->render();
    }

   public function  getuserrebate($uid)
    {
        $this->view('exec/account_manage', ['uid' => $uid, 'flag' => 'getuserrebate']);
        $this->view->render();
    }

    public function updateUsedquota($uid, $bonus_group, $rebate_group, $quata_group, $count_group)
    {
        $this->view('exec/account_manage', [
            'uid' => $uid,
            'bonus' => $bonus_group,
            'rebate' => $rebate_group,
            'quota' => $quata_group,
            'count' => $count_group,
            'flag' => 'updateUsedquota'
        ]);
        $this->view->render();
    }
   public function manageUser($userID, $lotteryID, $flag)
    {
        $this->view('exec/account_manage', ['user_id' => $userID, 'ulog_id' => $lotteryID, 'lottery_id' => $lotteryID, "flag" => $flag]);
        $this->view->render();
    }
    
    public function agent_subordinate($user_id, $pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['user_id' => $user_id, 'flag' => 'fetchsubagent', 'page' => $pageNumber, 'limit' => $limit,]);
        $this->view->render();
    }
   public function fetchAgentSubs($partnerID, $agent_id, $lottery_id, $start_date, $end_date, $flag, $page, $limit)
    {
        $this->view('exec/win_loss', ['partner_id' => $partnerID, "agent_id" => $agent_id, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => $flag]);
        $this->view->render();
    }

     public function fetchTopAgents($partnerID, $lottery_id, $start_date, $end_date, $page, $limit)
    {

        $this->view('exec/win_loss', ['partner_id' => $partnerID, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => 'get-top-agents']);
        $this->view->render();
    }

    
    public function  fetchTopAgent($recharge_level, $state, $start_date, $end_date, $page, $limit)
    {
        $this->view('exec/account_manage', ["recharge_level" => $recharge_level, "state" => $state, "start_date" => $start_date, "end_date" => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => 'fetchTopAgent']);
        $this->view->render();
    }

    public function  addAgent($data)
    {
        $this->view('exec/account_manage', ['data' => $data, 'flag' => 'addAgent']);
        $this->view->render();
    }

       public function searchUserListData($partnerID, $username, $recharge_level, $states, $startdate, $enddate, $miscelleanous)
    {
        $this->view('exec/account_manage', [
            'partner_id' => $partnerID,
            'uid' => $username,
            'recharge_level' => $recharge_level,
            'state' => $states,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'flag' => 'searchUserlistData',

        ]);
        $this->view->render();
    }


        public function updateUserData( $userID, $depositLimit, $withdrawalLimit, $rebate, $state, $dailyBettingLimit)
    {

        $this->view('exec/account_manage', ['user_id' => $userID, 'depositLimit' => $depositLimit, 'withdrawalLimit' => $withdrawalLimit, 'rebate' => $rebate, "state" => $state, "dailyBettingTotalLimit" => $dailyBettingLimit, 'flag' => 'updateUserData',]);
        $this->view->render();
    }

      public function useraccountchange($uid, $pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['uid' => $uid, 'flag' => 'fetchaccountchange', 'page' => $pageNumber, 'limit' => $limit,]);
        $this->view->render();
    }
    public function resetUser($uid)
    {

        $this->view('exec/account_manage', [
            'uid'  => $uid,
            'flag' => 'resetloginattempt',
        ]);
        $this->view->render();
    }

  function fetchGameNames($lotteryid,$model)
    {
        $this->view('exec/account_manage', ['lotteryid'=>$lotteryid, 'model'=>$model,'flag'=>'fetchGameNames']);
        $this->view->render();
    }
    
    function getallgametype()
    {
        $this->view('exec/game_management', ['flag'=>'getallgametype']);
        $this->view->render();
    }

        public function updatesGamesnames($userid,$data)
    {
        $this->view('exec/account_manage', ["uid"=>$userid, "data" => $data ,"flag" => 'updategamenames']);
        $this->view->render();
    }

       function fetchgamesTab($lotteryid,$model)
    {
        $this->view('exec/account_manage', ['lotteryid'=>$lotteryid, 'model'=>$model,'flag'=>'fetchgamesTab']);
        $this->view->render();
    }

       public function updatesGameNamess($userid,$lotterymodel,$data)
    {
        $this->view('exec/account_manage', ["uid"=>$userid, "lotterymodel"=>$lotterymodel, "data" => $data ,"flag" => 'updatesGameNamess']);
        $this->view->render();
    }


     public function fetchLotteryname()
    {
        $this->view('exec/businessflow', ['flag' => 'fetchLotteryname']);
        $this->view->render();
    }

 public function filterChangeAccount($uid, $ordertype, $startdate, $enddate, $pageNumber, $limit)
    {
        $this->view('exec/account_manage', [
            'uid' => $uid,
            'ordertype' => $ordertype,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'flag' => 'filterchange',
            'page' => $pageNumber,
            'limit' => $limit,

        ]);
        $this->view->render();
    }

     public function updatesGamegroup($userid,$lotterymodel,$data)
    {
   
   
        $this->view('exec/account_manage', ["uid"=>$userid, "lotterymodel"=>$lotterymodel, "data" => $data ,"flag" => 'updatesGamegroup']);
        $this->view->render();
    }


    //NOTE -
    ////////////// USERLIST LOGS -//////////
    public function userlogsdata($pageNumber, $limit)
    {
        $this->view('exec/account_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlogsdata']);
        $this->view->render();
    }

      public function filterUserlogs($username,  $startdate, $enddate, $pageNumber, $limit)
    {
        $this->view('exec/account_manage', [
            'usernamelog' => $username,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'flag' => 'filterUserlogs',
            'page' => $pageNumber,
            'limit' => $limit,
        ]);
        $this->view->render();
    }

       function updategamegroup($gamegroupid, $gametate)
    {
        $this->view('exec/game_management', [ 'flag' => 'updategamegroup','gamegroupid' => $gamegroupid,'gametate' => $gametate]);
        $this->view->render();
    }

   

}

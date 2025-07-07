<?php

class financialController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }
  //NOTE -
    //////////////Deposit Records functions -//////////
    // 
     public function fetchDeposit($pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchDeposit']);
        $this->view->render();
    }

    public function filterdeposits($uid, $depositchanel, $depositid, $stautsdeposit, $startdepo, $enddepo, $page, $pageLimit)
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

     // NOTE -
    //////////////Withdrawal Records -//////////
    public function fetchwithdraw($partnerID, $pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchwithdraw']);
        $this->view->render();
    }

      public function searchWidrlRecords($userID, $widrlID, $widrlChannels, $widrlStatus, $widrlStartDate, $widrlEndDate, $page, $limit)
    {

        $this->view('exec/withdrawal_records', ['user_id' => $userID, 'widrl_id' => $widrlID, 'widrl_channels' => $widrlChannels, 'widrl_status' => $widrlStatus, 'widrl_start_date' => $widrlStartDate, 'widrl_end_date' => $widrlEndDate, 'page' => $page, 'limit' => $limit, 'flag' => 'filter_records']);
        $this->view->render();
    }


        //NOTE -
    //////////////Finance funds Records -//////////
    // 


     public function addmoney($depositetype, $uid, $amount, $approvedby, $review)
    {
        $this->view('exec/financial_manage', [
            'depositetype' => $depositetype,
            'uid' => $uid,
            'amount' => $amount,
            'approvedby' => $approvedby,
            'review' => $review,
            'flag' => 'addmoney'
        ]);
        $this->view->render();
    }

    public function fetchfinance($pageNumber, $limit)
    {
        $this->view('exec/financial_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchfinance']);
        $this->view->render();
    }

   


      
       public function Searchusername($username)
    {
        $this->view('exec/businessflow', ['username' => $username, 'flag' => 'searchusername']);
        $this->view->render();
    }
       

}
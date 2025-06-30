<?php


class businessflowController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

    
    //NOTE -
    //////////////TRANSACTION FUNCTIONS -//////////
    public function transactiondata($pageNumber, $limit)
    {
        $this->view('exec/businessflow', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'transactiondata']);
        $this->view->render();
    }
    public function filtertransactions($username, $orderid, $ordertype, $partneruid, $startdate, $enddate, $pageNumber, $limit)
    {
        $this->view('exec/businessflow', [
            'username' => $username,
            'orderid' => $orderid,
            'ordertype' => $ordertype,
            'partneruid' => $partneruid,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'flag' => 'filtertransactions',
            'page' => $pageNumber,
            'limit' => $limit,

        ]);
        $this->view->render();
    }

    public function getTransactionBet($transactionId)
    {
        $this->view('exec/businessflow', ['transactionId' => $transactionId, 'flag' => 'getTransactionBet']);
        $this->view->render();
    }

     //NOTE -
    //////////////LOTTERY BETS -//////////

    public function lotterydata($pageNumber, $limit)
    {
        $this->view('exec/businessflow', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'lotterydata']);
        $this->view->render();
    }

    public function viewBetstake($becode)
    {
        $this->view('exec/businessflow', ['betcode' => $becode, 'flag' => 'viewBetstake']);
        $this->view->render();
    }

    public function fetchLotteryname()
    {
        $this->view('exec/businessflow', ['flag' => 'fetchLotteryname']);
        $this->view->render();
    }

    public function filterbetdata($uid, $betOrderID, $gametype, $betstate, $betstatus, $startdate, $enddate, $page, $limit)
    {
        $this->view('exec/businessflow', [
            // 'partner_id' => $partnerID,
            'uid' => $uid,
            'betOrderID' => $betOrderID,
            'gametype' => $gametype,
            'betstate' => $betstate,
            'betstatus' => $betstatus,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'page' => $page,
            'limit' => $limit,
            'flag' => 'filterbetdata'
        ]);
        $this->view->render();
    }
 

}

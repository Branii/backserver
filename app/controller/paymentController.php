<?php

class paymentController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }
//NOTE -
    ////////////// ADD PAYMENT FUNCTIONS -//////////



     public function filterpayments($partnerID, $curencytypes, $stautspayment, $startdepo, $enddepo, $page, $pageLimit)
    {
        $this->view('exec/payment_platform', [
            'partner_id' => $partnerID,
            'curencytypes' => $curencytypes,
            'stautspayment' => $stautspayment,
            'startdate' => $startdepo,
            'enddate' => $enddepo,
            'page' => $page,
            'limit' => $pageLimit,
            'flag' => 'filterpayments'
        ]);
        $this->view->render();
    }

    
    public function addnewpayment()
    {
        $this->view('exec/payment_platform', ['flag' => 'addpayment']);
        $this->view->render();
    }

     public function deletepayment($payid)
    {
        $this->view('exec/payment_platform', ['payid' => $payid, 'flag' => 'deletepayment']);
        $this->view->render();
    }

    
    public function editpayment($payid)
    {
        $this->view('exec/payment_platform', ['payid' => $payid, 'flag' => 'editpayment']);
        $this->view->render();
    }

    public function updateplatform($typecurrency, $maxiamounts, $minamount, $statecurrent, $paymentids)
    {
        $this->view('exec/payment_platform', [
            'typecurrency' => $typecurrency,
            'maxiamounts' => $maxiamounts,
            'minamount' => $minamount,
            'statecurrent' => $statecurrent,
            'paymentids' => $paymentids,
            'flag' => 'updateplatform'
        ]);
        $this->view->render();
    }



      public function fetchPaymentPlatform($page, $limit)
    {
        $this->view('exec/payment_platform', ["page" => $page, "limit" => $limit, 'flag' => 'fetchPaymentPlatform']);
        $this->view->render();
    }

    
   public function filterfinance($uid, $depositestate, $startfinance, $endfinance, $page, $pageLimit)
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
    

}
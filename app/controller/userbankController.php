<?php

class userbankController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

            // NOTE -
    ////////////// Bank Cardlist Records - //////////
     public function searchBankTypes($bank_type)
    {
        // echo $bank_type;
        $this->view('exec/userbank_manage', ['bank_type' => urldecode($bank_type), 'flag' => 'search-bank-name']);
        $this->view->render();
    }


    public function   fetchbankcard($partnerID, $uid, $bank_type, $card_number, $status, $pageNumber, $limit)
    {

        $this->view('exec/userbank_manage', ['partner_id' => $partnerID, 'uid' => $uid, 'bank_type' => urldecode($bank_type), 'card_number' => $card_number, 'status' => $status, 'page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchbankcard']);
        $this->view->render();
    }


   ////////////// USER PAYMENT METHOD  - //////////
    public function Inactiveuserpaymentmethod($uid, $bank_id)
    {
        $this->view('exec/userbank_manage', ['uid' => $uid, 'bank_id' => $bank_id, 'flag' => 'inactivepayment']);
        $this->view->render();
    }

        public function fetchuserpaymentbyuid($uid)
    {
        $this->view('exec/userbank_manage', ['uid' => $uid, 'flag' => 'getuserpaymentmethod']);
        $this->view->render();
    }

    
    public function filterpaymentdata($username, $uid, $pageNumber, $limit)
    {
        $this->view('exec/userbank_manage', [
            'username' => $username,
            'uid' => $uid,
            'flag' => 'filteruserpayments',
            'page' => $pageNumber,
            'limit' => $limit,
        ]);
        $this->view->render();
    }

  public function filterbankdata($uid,$bankType,$cardNumber,$state, $currentPage, $pageLimit)
    {
  
        $this->view('exec/userbank_manage', [
            'uid' => $uid,
            'bankType' => $bankType,
            'cardNumber' => $cardNumber,
            'state'=>$state,
            'flag' => 'filterbankdata',
            'currentPage' => $currentPage,
            'pageLimit' => $pageLimit,
        ]);
        $this->view->render();
    }
 

     public function fetchuserpaymentmethod($page, $pageLimit)
    {
        $this->view('exec/userbank_manage', ['page' => $page, 'pageLimit' => $pageLimit, 'flag' => 'userpaymentmethod']);
        $this->view->render();
    }
}

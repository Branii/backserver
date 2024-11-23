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

    // side bar datas

    public function transactiondata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'transactiondata']);
        $this->view->render();
    }

    public function gamebetdata($pageNumber,$limit){
        $this->view('exec/businessflow',['page'=>$pageNumber,'limit'=>$limit, 'flag' => 'gamebetdata']);
        $this->view->render();
    }


    public function filterusername($username){
        $this->view('exec/businessflow',['username'=>$username,'flag' => 'filterusername']);
        $this->view->render();
    }

    public function filtertransactions($username ='',$orderid ='',$ordertype ='',$startdate ='',$enddate ='',$pageNumber,$limit){
        $this->view('exec/businessflow',[
            'username' => $username,'orderid' => $orderid,
            'ordertype' => $ordertype,'startdate' => $startdate,
            'enddate' => $enddate, 'flag' => 'filtertransactions',
            'page'=>$pageNumber,'limit'=>$limit,

        ]);
        $this->view->render();
    }

    public function getTransactionBet($transactionId){
        $this->view('exec/businessflow',['transactionId'=>$transactionId, 'flag' => 'transactionBet']);
        $this->view->render();
    }


    
}
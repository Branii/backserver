<?php

class businessController extends Controller {

    public function notfound() {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function account_transaction(int $page, int $limit, $params){
        $this->view('exec/businessflow',[
            'page' => $page,
            'limit'=>$limit, 
            'flag' => 'account_transaction',
            'params' => $params
        ]);
        $this->view->render();
    }

    public function home(){
        $this->view('html/home');
        $this->view->render();
    }
    
}
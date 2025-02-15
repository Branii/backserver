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

    public function filter_transaction(int $page, int $limit, $params){
        $this->view('exec/businessflow',[
            'page' => $page,
            'limit'=>$limit, 
            'flag' => 'filter_transaction',
            'params' => $params
        ]);
        $this->view->render();
    }

    public function fetch_lottery($params){
        $this->view('exec/businessflow',[ 
            'flag' => 'fetch_lottery',
            'params' => $params
        ]);
        $this->view->render();
    }
    
}
<?php

class systemController extends Controller {

    public function notfound() {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function languages($params){
        $this->view('exec/system_settings',[
            'flag' => 'change_language',
            'params' => $params
        ]);
        $this->view->render();
    }

    // public function home(){
    //     $this->view('html/home');
    //     $this->view->render();
    // }
    
}
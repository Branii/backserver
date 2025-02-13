<?php

class homeController extends Controller {

    public function notfound() {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function index(){
        $this->view('html/home');
        $this->view->render();
    }

    public function home(){
        $this->view('html/home');
        $this->view->render();
    }
    
}
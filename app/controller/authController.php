<?php

class authController extends Controller {

    public function notfound() {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function index(){
        $this->view('html/signin');
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

}
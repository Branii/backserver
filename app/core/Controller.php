<?php
use Josantonius\Session\Session;
class Controller{
    protected  $view;
    public function view($viewName,$data=[]){
      $this->view = new View($viewName,$data);
      return $this->view;
    }

    public function isUserLoggedIn(){
      return (new Session)->has("isUserLoggedIn");
    }

}
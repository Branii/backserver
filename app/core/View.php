<?php
class View{

    protected $viewFile;
    protected $viewData;

    public function __construct($viewFile,$viewData){
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
    }

    public function render(){ // render the views
       
        if(file_exists(VIEWS . $this->viewFile . ".phtml")){
            include VIEWS . $this->viewFile . ".phtml";
        }else{
            include VIEWS . "notfound.phtml";
        }
    }

}
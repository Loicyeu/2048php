<?php

include_once PATH_CONTROLEUR . "/ControllerLogin.php";
include_once PATH_CONTROLEUR . "/ControllerGame.php";

class Router {

    private $controllerLogin;
    private $controllerGame;

    public function __construct() {
        $this->controllerLogin = new ControllerLogin();
        $this->controllerGame = new ControllerGame();
    }

    public function route() {
        if(isset($_SESSION['pseudo'])){
            $this->controllerGame->play();
        }else{
            $this->controllerLogin = new ControllerLogin();
            $this->controllerLogin->login();
        }
    }

}
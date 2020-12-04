<?php

include_once PATH_CONTROLEUR . "/ControllerLogin.php";
include_once PATH_CONTROLEUR . "/ControllerGame.php";
include_once PATH_CONTROLEUR . "/ControllerRegister.php";

class Router {

    private $controllerLogin;
    private $controllerGame;
    private $controllerRegister;

    public function __construct() {
        $this->controllerLogin = new ControllerLogin();
        $this->controllerGame = new ControllerGame();
        $this->controllerRegister = new ControllerRegister();
    }

    public function route() {
        if(isset($_SESSION['pseudo'])){
            $this->controllerGame->play();
        }else if(isset($_GET["register"])) {
            $this->controllerRegister;
        }else{
            $this->controllerLogin = new ControllerLogin();
            $this->controllerLogin->login();
        }
    }

}
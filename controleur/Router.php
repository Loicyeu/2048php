<?php
session_start();

include_once PATH_VUE . "/VueLogin.php";
include_once PATH_VUE . "/VueGame.php";
include_once PATH_VUE . "/VueError.php";

class Router {

    private $vueLogin;
    private $vueGame;
    private $vueError;

    public function __construct() {
        $this->vueLogin = new VueLogin();
        $this->vueGame = new VueGame();
        $this->vueError = new VueError();
    }

    public function route() {
        if(isset($_SESSION['pseudo'])){

        }else{

        }
    }

}
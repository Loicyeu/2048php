<?php

include_once PATH_VUE."/VueError.php";
include_once PATH_VUE."/VueLogin.php";
include_once PATH_VUE."/VueGame.php";
include_once PATH_MODELE."/DAOUser.php";

class ControllerLogin {

    private $vueLogin;
    private $vueError;
    private $vueGame;

    public function __construct() {
        $this->vueLogin = new VueLogin();
        $this->vueError = new VueError();
        $this->vueGame = new VueGame();
    }

    public function login() {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {
            try {
                $dao = new DAOUser();
                if ($dao->exists($_POST['pseudo'], $_POST['password'])) {
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                    $this->vueGame->display();
                } else {
                    $this->vueError->displayTest("mauvais mdp ou pseudo");
                }
            }catch (SQLException $e) {
                $this->vueError->displayTest("Erreur SQL");
            }
        }else{
            $this->vueLogin->display();
       }
    }
}
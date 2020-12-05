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
                    $this->vueGame->display_home();
                } else {
                    $this->vueError->display("Le pseudo ou le mot de passe est faux.");
                }
            }catch (SQLException $e) {
                $this->vueError->display("Erreur SQL");
            }
        }else{
            $this->vueLogin->display();
       }
    }
}
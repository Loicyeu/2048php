<?php

include_once PATH_VUE."/VueRegister.php";
include_once PATH_VUE."/VueError.php";
include_once PATH_VUE."/VueGame.php";

class controllerRegister {

    private $vueRegister;
    private $vueError;
    private $vueGame;

    /**
     * controllerRegister constructor.
     */
    public function __construct() {
        $this->vueRegister = new VueRegister();
        $this->vueError = new VueError();
        $this->vueGame = new VueGame();

    }

    /**
     * Méthode permettant au joueur de se créer un compte.
     * Si une erreur se produit alors une vue d'erreur s'affichera.
     */
    public function register() {
        if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['passwordRepeat'])) {
            try {
                $dao = new DAOUser();
                if($_POST['password']!=$_POST['passwordRepeat']) {
                    $this->vueError->display("Les mots de passe ne sont pas identiques.", "/?register");
                } else if(!$dao->exists_pseudo($_POST['pseudo'])) {
                    $dao->create($_POST['pseudo'], $_POST['password']);
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                    $this->vueGame->display_home();
                } else {
                    $this->vueError->display("Le pseudo choisi est déjà utilisé.", "/?register");
                }
            }catch (SQLException $e) {
                $this->vueError->display($e->getMessage(),"/?register");
            }
        }else{
            $this->vueRegister->display();
        }
    }
}
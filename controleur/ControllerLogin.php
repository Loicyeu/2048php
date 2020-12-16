<?php

include_once PATH_VUE."/VueError.php";
include_once PATH_VUE."/VueLogin.php";
include_once PATH_VUE."/VueGame.php";
include_once PATH_MODELE."/DAOUser.php";

/**
 * Classe ControllerLogin.
 * Contrôleur gérant la connexion des joueurs.
 */
class ControllerLogin {

    //region ATTRIBUTES
    /**
     * @var VueLogin La vue de connexion.
     */
    private $vueLogin;
    /**
     * @var VueError La vue des erreurs.
     */
    private $vueError;
    /**
     * @var VueGame La vue de jeu.
     */
    private $vueGame;
    //endregion


    /**
     * Constructeur de ControllerLogin.
     */
    public function __construct() {
        $this->vueLogin = new VueLogin();
        $this->vueError = new VueError();
        $this->vueGame = new VueGame();
    }


    /**
     * Méthode permettant au joueur de se connecter.
     * Si le joueur est connecté, affiche la vue de jeu.
     * Si une erreur se produit alors une vue d'erreur s'affichera.
     */
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
                $this->vueError->display($e->getMessage());
            }
        }else{
            $this->vueLogin->display();
       }
    }
}
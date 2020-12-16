<?php

include_once PATH_VUE."/VueRegister.php";
include_once PATH_VUE."/VueError.php";
include_once PATH_VUE."/VueGame.php";
include_once PATH_MODELE."/DAOUser.php";

/**
 * Classe controllerRegister.
 * Contrôleur gérant l'inscription de nouveau joueurs.
 */
class ControllerRegister {

    //region ATTRIBUTES
    /**
     * @var VueRegister La vue d'inscription.
     */
    private $vueRegister;
    /**
     * @var VueError La vue des erreurs.
     */
    private $vueError;
    /**
     * @var VueGame La vue de jeu.
     */
    private $vueGame;

    private const REGISTER_PAGE = "/?register";
    //endregion


    /**
     * Constructeur de controllerRegister.
     */
    public function __construct() {
        $this->vueRegister = new VueRegister();
        $this->vueError = new VueError();
        $this->vueGame = new VueGame();

    }


    /**
     * Méthode permettant au joueur de se créer un compte.
     * Le joueur a réussit a se créer un compte, affiche la vue de jeu.
     * Si une erreur se produit alors une vue d'erreur s'affichera.
     */
    public function register() {
        if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['passwordRepeat'])) {
            try {
                $dao = new DAOUser();
                if($_POST['password']!=$_POST['passwordRepeat']) {
                    $this->vueError->display("Les mots de passe ne sont pas identiques.", self::REGISTER_PAGE);
                } else if(!$dao->exists_pseudo($_POST['pseudo'])) {
                    $dao->create($_POST['pseudo'], $_POST['password']);
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                    $this->vueGame->display_home();
                } else {
                    $this->vueError->display("Le pseudo choisi est déjà utilisé.", self::REGISTER_PAGE);
                }
            }catch (SQLException $e) {
                $this->vueError->display($e->getMessage(),self::REGISTER_PAGE);
            }
        }else{
            $this->vueRegister->display();
        }
    }
}
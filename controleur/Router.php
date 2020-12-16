<?php

include_once PATH_CONTROLEUR . "/ControllerLogin.php";
include_once PATH_CONTROLEUR . "/ControllerGame.php";
include_once PATH_CONTROLEUR . "/ControllerRegister.php";

/**
 * Classe Router.
 * Contrôleur gérant le gestion des requêtes de la redirection vers le bon contrôleur.
 */
class Router {

    //region ATTRIBUTES
    /**
     * @var ControllerLogin le contrôleur de la vue de connexion.
     */
    private $controllerLogin;

    /**
     * @var ControllerGame le contrôleur de la vue de jeu.
     */
    private $controllerGame;

    /**
     * @var ControllerRegister le contrôleur de la vue d'enregistrement.
     */
    private $controllerRegister;
    //endregion


    /**
     * Constructeur de Router.
     */
    public function __construct() {
        $this->controllerLogin = new ControllerLogin();
        $this->controllerGame = new ControllerGame();
        $this->controllerRegister = new ControllerRegister();
    }


    /**
     * Méthode permettant de choisir le bon contrôleur en fonction de la situation.
     */
    public function route() {
        if(isset($_SESSION['pseudo'])){
            if(isset($_POST["disconnect"])){
                session_unset();
                $this->controllerLogin->login();
            } else {
                $this->controllerGame->play();
            }
        }else if(isset($_GET["register"])) {
            $this->controllerRegister->register();
        }else{
            $this->controllerLogin->login();
        }
    }

}
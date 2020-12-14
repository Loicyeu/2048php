<?php

include_once PATH_VUE."/VueGame.php";
include_once PATH_VUE."/VueResult.php";
include_once PATH_VUE."/VueError.php";
include_once PATH_METIER . "/GamePlate.php";
include_once PATH_MODELE."/DAOParties.php";
include_once PATH_METIER . "/GamePlateEnd.php";

class controllerGame {

    //region ATTRIBUTES
    /**
     * @var VueGame La vue de jeu.
     */
    private $vueGame;
    /**
     * @var VueResult La vue des résultat.
     */
    private $vueResult;
    /**
     * @var VueError La vue des erreurs.
     */
    private $vueError;
    /**
     * @var DAOParties Le DAO des parties.
     */
    private $dao;
    //endregion


    /**
     * controllerGame constructor.
     */
    public function __construct() {
        $this->vueGame = new VueGame();
        $this->vueResult = new VueResult();
        $this->vueError = new VueError();
        $this->dao = new DAOParties();
    }


    /**
     * Méthode permettant de jouer. Si aucun mouvement n'a été choisi,
     * la méthode se contente de ré-afficher le plateau.
     * Si une erreur se produit alors une vue d'erreur s'affichera.
     */
    public function play() {
        try {
            if(isset($_POST['new']) || isset($_GET['reset'])){
                $this->vueGame->display(GamePlate::create_new($_SESSION["pseudo"])->to_html());
            }else if(isset($_GET['previous'])) {
                $this->vueGame->display(GamePlate::load_previous($_SESSION["pseudo"])->to_html());
            }else if(isset($_GET['move'])){
                $gameplate = GamePlate::load($_SESSION["pseudo"]);
                $res = $gameplate->move($_GET['move']);
                if($res=="won") {
                    $this->vueResult->display(true, GamePlateEnd::build($_SESSION["pseudo"])->to_html($gameplate->to_html()));
                }else if ($res=="lost") {
                    $this->vueResult->display(false, GamePlateEnd::build($_SESSION['pseudo'])->to_html($gameplate->to_html()));
                }else {
                    $this->vueGame->display($gameplate->to_html());
                }

            }else {
                $this->vueGame->display(GamePlate::load($_SESSION["pseudo"])->to_html());
            }
        } catch (SQLException | CreateHTMLException $e) {
            $this->vueError->display($e->getMessage());
        }
    }
}
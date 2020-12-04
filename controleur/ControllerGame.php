<?php

include_once PATH_VUE."/VueGame.php";
include_once PATH_MODELE."/GamePlate.php";
include_once PATH_MODELE."/DAOParties.php";

class controllerGame {

    private $vueGame;

    private $dao;

    /**
     * controllerGame constructor.
     */
    public function __construct() {
        $this->vueGame = new VueGame();
        $this->dao = new DAOParties();
    }

    public function play() {
        if(isset($_SESSION['gameplate'])){
            $this->vueGame->display_test(GamePlate::load($_SESSION["pseudo"])->move()->get_html());
        }else {
            $this->vueGame->display_test(GamePlate::create_new($_SESSION["pseudo"])->get_html());
        }



    }

}
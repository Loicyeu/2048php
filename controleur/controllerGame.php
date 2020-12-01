<?php

include_once PATH_VUE."/VueGame.php";
include_once PATH_MODELE."/GamePlate.php";

class controllerGame {

    private $vueGame;


    /**
     * controllerGame constructor.
     */
    public function __construct() {
        $this->vueGame = new VueGame();
    }

    public function play() {
        if(isset($_SESSION['gameplate'])){
            $this->vueGame->display_test(GamePlate::load()->move()->get_html());
        }else {
            $this->vueGame->display_test(GamePlate::create_new()->get_html());
        }

    }
}
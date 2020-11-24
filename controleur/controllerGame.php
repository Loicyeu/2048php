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
        $this->vueGame->display_test((new GamePlate())->display());
    }
}
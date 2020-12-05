<?php

include_once PATH_VUE."/VueGame.php";
include_once PATH_VUE."/VueError.php";
include_once PATH_MODELE."/GamePlate.php";
include_once PATH_MODELE."/DAOParties.php";

class controllerGame {

    private $vueGame;
    private $vueError;
    private $dao;

    /**
     * controllerGame constructor.
     */
    public function __construct() {
        $this->vueGame = new VueGame();
        $this->vueError = new VueError();
        $this->dao = new DAOParties();
    }

    public function play() {
        if(isset($_POST['new'])){
            $this->vueGame->display(GamePlate::create_new($_SESSION["pseudo"])->to_html());
        }else if(isset($_GET['move'])){
            try {
                $gameplate = GamePlate::load($_SESSION["pseudo"]);
                $res = $gameplate->move($_GET['move']);
                if($res=="won") {
                    echo "win";
                }else if ($res=="lost") {
                    echo "loose";
                }else {
                    $this->vueGame->display($gameplate->to_html());
                }
            } catch (SQLException $e) {
                $this->vueError->display($e->getMessage());
            }
        }else {
            $this->vueGame->display(GamePlate::load($_SESSION["pseudo"])->to_html());
        }
    }

}
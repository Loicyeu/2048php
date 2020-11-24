<?php


class GamePlate {

    private $gamePlate;

    /**
     * GamePlate constructor.
     * Génère un nouveau plateau de jeu avec deux carreaux initialisé a 2 placé aléatoirement.
     */
    public function __construct() {
        $this->gamePlate = array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0));
        $firstValueIndex = rand(0,15);
        do $secondValueIndex = rand(0,15);
        while($secondValueIndex == $firstValueIndex);
        $this->gamePlate[floor($firstValueIndex/4)][$firstValueIndex%4] = 2;
        $this->gamePlate[floor($secondValueIndex/4)][$secondValueIndex%4] = 2;
    }

    public function move() {

        if(isset($_GET["up"])) {
            $this->arrange("up");
            $this->fusion("up");
            $this->arrange("up");
        }else if (isset($_GET["right"])) {
            $this->arrange("right");
            $this->fusion("right");
            $this->arrange("right");
        }else if (isset($_GET["left"])) {
            $this->arrange("left");
            $this->fusion("left");
            $this->arrange("left");
        }else if (isset($_GET["down"])) {
            $this->arrange("down");
            $this->fusion("down");
            $this->arrange("down");
        } else {
            //ERREUR
        }
        do {
            $randValueX = rand(0,3);
            $randValueY = rand(0,3);
        } while($this->gamePlate[$randValueX][$randValueY] != 0);
        $this->gamePlate[$randValueX][$randValueY] = 4/rand(1,2);

    }

    private function fusion(string $move) {
        for($i = 0; $i < 4; $i++) {
            if($move == "up" || $move == "right") {
                for($j = 0; $j < 3; $j++) {
                    if($this->gamePlate[$j][$i] == $this->gamePlate[$j+1][$i] && $move == "up") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j+1][$i] = 0;
                    }else if($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j+1] && $move == "right") {
                        $this->gamePlate[$i][$j] *= 2;
                        $this->gamePlate[$i][$j+1] = 0;
                    }
                }
            }else if($move == "down" || $move == "left") {
                for($j = 3; $j > 0; $j++) {
                    if ($this->gamePlate[$j-1][$i] == $this->gamePlate[$j][$i] && $move == "down") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j-1][$i] = 0;
                    } else if ($this->gamePlate[$i][$j-1] == $this->gamePlate[$i][$j] && $move == "left") {
                        $this->gamePlate[$i][$j] *= 2;
                        $this->gamePlate[$i][$j-1] = 0;
                    }
                }
            }
        }
    }

    /* URSS
     for($i=0; $i<4; $i++){
        for($j=0; $j<4; $j++) {

        }
     }
     */

    private function arrange(string $move) {
        if($move=="left") {
            for($i=0; $i<4; $i++){
                for($j=0; $j<4; $j++) {

                }
            }
        }
    }

    public function display(): string {
        $str = "<div class='grid-container'>";
        for($i=0; $i<4; $i++){
            for($j=0; $j<4; $j++) {
                $str .= "<div class='grid-item tile tile-".$this->gamePlate[$i][$j]."'>".$this->gamePlate[$i][$j]."</div>";
            }
        }
        $str .= "</div>";
        return $str;
    }
}
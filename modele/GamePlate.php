<?php


class GamePlate {

    private $gamePlate;

    public function __construct() {
        $this->gamePlate = array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0));
        $firstValueIndex = rand(0,15);
        do $secondValueIndex = rand(0,15);
        while($secondValueIndex == $firstValueIndex);
        $this->gamePlate[floor($firstValueIndex/4)][$firstValueIndex%4] = 2;
        $this->gamePlate[floor($secondValueIndex/4)][$secondValueIndex%4] = 2;
    }

    public function move() {
        //TODO move
        if(isset($_GET["up"])) {


        }else if (isset($_GET["right"])) {

        }else if (isset($_GET["left"])) {
//            for ($i=3; $i>0; $i++){
//                for ($j=0; $j<4; $j++){
//                    if($this->gamePlate[$i][$j]==$this->gamePlate[$i-1][$j]) {
//                        $this->gamePlate[$i-1][$j] *= 2;
//                        $this->gamePlate[$i][$j] = 0;
//                    }else if($this->gamePlate[$i-1][$j] == 0) {
//                        $this->gamePlate[$i-1][$j]=$this->gamePlate[$i][$j];
//                        $this->gamePlate[$i][$j] = 0;
//                    }
//                }
//            }

        }else if (isset($_GET["down"])) {

        }else {
            //ERREUR
        }

        //TODO rand new

    }

    private function fusion(string $move) {
        if($move == "up" || $move == "down") {
            for($i = 0; $i < 4; $i++) {
                if($this->gamePlate[1][$i] == $this->gamePlate[2][$i]) {
                    $this->gamePlate[2][$i] *= 2;
                    $this->gamePlate[1][$i] = 0;
                } else {
                    if($this->gamePlate[2][$i] == $this->gamePlate[3][$i]) {
                        $this->gamePlate[3][$i] *= 2;
                        $this->gamePlate[2][$i] = 0;
                    }
                    if($this->gamePlate[0][$i] == $this->gamePlate[1][$i]) {
                        $this->gamePlate[1][$i] *= 2;
                        $this->gamePlate[0][$i] = 0;
                    }
                }
            }
        }else if($move == "right" || $move == "left") {
            for($i = 0; $i < 4; $i++) {
                if($this->gamePlate[$i][1] == $this->gamePlate[$i][2]) {
                    $this->gamePlate[$i][2] *= 2;
                    $this->gamePlate[$i][1] = 0;
                } else {
                    if($this->gamePlate[$i][2] == $this->gamePlate[$i][3]) {
                        $this->gamePlate[$i][3] *= 2;
                        $this->gamePlate[$i][2] = 0;
                    }
                    if($this->gamePlate[$i][0] == $this->gamePlate[$i][1]) {
                        $this->gamePlate[$i][1] *= 2;
                        $this->gamePlate[$i][0] = 0;
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

    public function display() {

    }

}
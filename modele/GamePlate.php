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
        if($move == "vertical") {                       // (2,0,2,16) -> (2,2,16) -> (4,16)
                                                        // (2,2,4,4) -> (2,2,4,4) -> (4,4,4)
                                                        // <=  (0,32,4,4)

        }else if($move == "horizontal") {

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
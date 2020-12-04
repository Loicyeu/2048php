<?php

include_once PATH_VUE."/VueGame.php";

/**
 * Classe représentant le plateau de jeu.
 */
class GamePlate {

    private $gamePlate;
    private $pseudo;
    private $score;

    /**
     * GamePlate constructor.
     * Génère un nouveau plateau de jeu avec deux carreaux initialisé à 2 et placé aléatoirement..
     * @param string $pseudo le pseudo du joueur
     * @param array $gamePlate  plateau de jeu.
     * @param int $score
     */
    private function __construct(string $pseudo, array $gamePlate, int $score) {
        $this->gamePlate = $gamePlate;
        $this->pseudo = $pseudo;
        $this->score = $score;
        $_SESSION['gameplate'] = $gamePlate;
    }

    /**
     * Génère un nouveau plateau de jeu avec deux carreaux initialisé à 2 et placé aléatoirement.
     * @param string $pseudo Le pseudo du joueur
     * @return GamePlate Le nouveau plateau de jeu
     */
    public static function create_new(string $pseudo) {
        $gamePlate = array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0));
        $firstValueIndex = rand(0,15);
        do $secondValueIndex = rand(0,15);
        while($secondValueIndex == $firstValueIndex);
        $gamePlate[floor($firstValueIndex/4)][$firstValueIndex%4] = 2;
        $gamePlate[floor($secondValueIndex/4)][$secondValueIndex%4] = 2;
        $dao = new DAOParties();
        try{
            $dao->create_current_game($pseudo, $gamePlate, 0);
        } catch (SQLException $e) {

        }
        return new GamePlate($pseudo, $gamePlate, 0);
    }

    /**
     * Récupère le plateau de jeu en cours du joueurs.
     * @param string $pseudo
     * @return GamePlate Le plateau de jeu en cours du joueurs
     */
    public static function load(string $pseudo) {
        $dao = new DAOParties();
        try {
            $game = $dao->get_current_game($pseudo);
            return new GamePlate($pseudo, $game['gameplate'], $game['score']);
        } catch (SQLException $e) {
            //TODO
        }
    }

    /**
     * Méthode permettant de faire un déplacement, et tester si le joueur a gagné.
     * @return GamePlate Vrai si le joueur a gagné, faux sinon.
     */
    public function move(): GamePlate {
//        $vueGame = new VueGame();
//        $vueGame->display_test($this->get_html());

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

        if($this->has_won()) {
            //TODO win
            // - set db game win
        }

        if(!$this->anyZeros()) {
            if($this->isFull()) {
                //TODO game lost
                // - set db game lost
                echo "game lost";
                return $this;
            }
        }
        do {
            $randValueX = rand(0,3);
            $randValueY = rand(0,3);
        } while($this->gamePlate[$randValueX][$randValueY] != 0);
        $this->gamePlate[$randValueX][$randValueY] = 4/rand(1,2);

        $dao = new DAOParties();
        $dao->update_current_game($this->pseudo, $this->gamePlate, $this->score);
        $_SESSION['gameplate'] = $this->gamePlate;
        return $this;
    }

    /**
     * Méthode qui permet de faire les fusions sur les lignes ou colonnes selon un déplacement choisi.
     * @param string $move Un déplacement choisi entre "up", "left", "down", "right"
     */
    private function fusion(string $move): void {
        for($i = 0; $i < 4; $i++) {
            if($move == "up" || $move == "right") {
                for($j = 0; $j < 3; $j++) {
                    if($this->gamePlate[$j][$i] == $this->gamePlate[$j+1][$i] && $move == "up") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j+1][$i] = 0;
                        $this->score += $this->gamePlate[$j][$i];
                    }else if($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j+1] && $move == "right") {
                        $this->gamePlate[$i][$j] *= 2;
                        $this->gamePlate[$i][$j+1] = 0;
                        $this->score += $this->gamePlate[$i][$j];
                    }
                }
            }else if($move == "down" || $move == "left") {
                for($j = 3; $j > 0; $j--) {
                    if ($this->gamePlate[$j][$i] == $this->gamePlate[$j-1][$i] && $move == "down") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j-1][$i] = 0;
                        $this->score += $this->gamePlate[$j][$i];
                    } else if ($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j-1] && $move == "left") {
                        $this->gamePlate[$i][$j] *= 2;
                        $this->gamePlate[$i][$j-1] = 0;
                        $this->score += $this->gamePlate[$i][$j];
                    }
                }
            }
        }
    }

    /**
     * Méthode qui permet de décaler tous les carreaux sur les lignes ou colonnes selon un déplacement choisi.
     * @param string $move Un déplacement choisi entre "up", "left", "down", "right"
     */
    private function arrange(string $move): void {

        if($move == "down") {
            for($j = 3; $j >= 0; $j--){
                $emptytiles = 0;
                for($i = 3; $i >= 0; $i --) {
                    if($this->gamePlate[$i][$j]==0) {
                        $emptytiles ++;
                    } else if($emptytiles != 0) {
                        $this->gamePlate[$i+$emptytiles][$j] = $this->gamePlate[$i][$j];
                        $this->gamePlate[$i][$j] = 0;
                    }
                }
            }
        } else if($move == "up") {
            for($j = 0; $j < 4; $j++){
                $emptytiles = 0;
                for($i = 0; $i < 4; $i++) {
                    if($this->gamePlate[$i][$j] == 0) {
                        $emptytiles ++;
                    } else if($emptytiles != 0) {
                        $this->gamePlate[$i-$emptytiles][$j] = $this->gamePlate[$i][$j];
                        $this->gamePlate[$i][$j] = 0;
                    }
                }
            }
        } else if($move == "right") {
            for($i = 3; $i >= 0; $i--){
                $emptytiles = 0;
                for($j = 3; $j > -1 ; $j --) {
                    if($this->gamePlate[$i][$j] == 0) {
                        $emptytiles ++;
                    } else if($emptytiles != 0){
                        $this->gamePlate[$i][$j+$emptytiles] = $this->gamePlate[$i][$j];
                        $this->gamePlate[$i][$j] = 0;
                    }
                }
            }
        } else if($move == "left") {
            for($i = 3; $i >= 0; $i--){
                $emptytiles = 0;
                for($j = 0; $j < 4; $j ++) {
                    if($this->gamePlate[$i][$j] == 0) {
                        $emptytiles ++;
                    } else if($emptytiles != 0){
                        $this->gamePlate[$i][$j-$emptytiles] = $this->gamePlate[$i][$j];
                        $this->gamePlate[$i][$j] = 0;
                    }
                }
            }
        }
    }

    /**
     * Méthode permettant de savoir si le joueur a gagné, cet a dire si il a un carreau a 2048.
     * @return bool Vrai si il a gagné, faux sinon.
     */
    private function has_won(): bool {
        for($i = 0; $i < 4; $i++) {
            for($j = 1; $j < 4; $j++) {
                if($this->gamePlate[$i][$j] == 2048) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Méthode permettant de savoir si la grille est pleine et qu'aucune fusion n'est possible.
     * @return bool Vrai si la grille est pleine et sans possibilité de fusion, faux sinon.
     */
    private function isFull(): bool {
//        for ($i=0; $i<3 ;$i++) {
//            for ($j=0; $j<3 ;$j++) {
//                if($this->gamePlate[$i][$j]==$this->gamePlate[$i][$j+1] && $this->gamePlate[$i][$j]!=0) {
//                    return false;
//                }
//            }
//        }
//        return true;
        for($i=0; $i<3; $i++) {
            for($j=0; $j<3; $j++) {
                if(

                    ($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j+1]
                        || $this->gamePlate[$i][$j] == 0
                        || $this->gamePlate[$i][$j+1] == 0 )

                    ||

                    ($this->gamePlate[$i][$j] == $this->gamePlate[$i+1][$j]
                        || $this->gamePlate[$i][$j] == 0
                        || $this->gamePlate[$i+1][$j] == 0))

                {
                    return false;
                }
            }
        }
        return true;
    }

    private function anyZeros() : bool {
        for($i=0; $i<4; $i++) {
            for($j=0; $j<4; $j++) {
                if($this->gamePlate[$i][$j] == 0) return true;
            }
        }
        return false;
    }


    /**
     * Méthode permettant de récupéré le plateau de jeu en HTML pour être affiché.
     * @return string Le plateau de jeu en version HTML.
     */
    public function get_html(): string {
        $str = "<div class='score'>".$this->score."</div>";
        $str .= "<div class='grid-container'>";
        for($i=0; $i<4; $i++){
            for($j=0; $j<4; $j++) {
                $value = $this->gamePlate[$i][$j]==0?"":$this->gamePlate[$i][$j];
                $str .= "<div class='tile tile-".$value."'>".$value."</div>";
            }
        }
        $str .= "</div>";
        return $str;
    }

}
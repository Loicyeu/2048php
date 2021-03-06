<?php


/**
 * Classe représentant le plateau de jeu.
 */
class GamePlate {

    //region ATTRIBUTES
    /**
     * @var array Le plateau de jeu.
     */
    private $gamePlate;
    /**
     * @var string Le pseudo du joueur.
     */
    private $pseudo;
    /**
     * @var int Le score du joueur.
     */
    private $score;
    /**
     * @var DAOParties Le DAO des parties.
     */
    private $dao;
    //endregion


    /**
     * GamePlate constructor.
     * Génère un nouveau plateau de jeu avec deux carreaux initialisé à 2 et placés aléatoirement.
     * @param string $pseudo Le pseudo du joueur.
     * @param array $gamePlate Le plateau de jeu.
     * @param int $score le score du joueur.
     */
    private function __construct(string $pseudo, array $gamePlate, int $score) {
        $this->gamePlate = $gamePlate;
        $this->pseudo = $pseudo;
        $this->score = $score;
        $this->dao = new DAOParties();
    }


    //region STATIC
    /**
     * Génère un nouveau plateau de jeu avec deux carreaux initialisé à 2 et placé aléatoirement.
     * @param string $pseudo Le pseudo du joueur.
     * @return GamePlate Le nouveau plateau de jeu.
     * @throws SQLException Si une erreur SQL se produit.
     */
    public static function create_new(string $pseudo): GamePlate {
//        $gamePlate = array(array(128, 32, 4, 2), array(256, 32, 8, 4), array(1024, 256, 64, 8), array(1024, 512, 128, 64));
//        Pour commencer sur une partie gagnante au prochain coup, dé-commentez la ligne ci dessus et commentez les 6 prochaines lignes
        $gamePlate = array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0));
        $firstValueIndex = rand(0,15);
        do {
            $secondValueIndex = rand(0,15);
        } while($secondValueIndex == $firstValueIndex);
        $gamePlate[floor($firstValueIndex/4)][$firstValueIndex%4] = 2;
        $gamePlate[floor($secondValueIndex/4)][$secondValueIndex%4] = 2;
        $dao = new DAOParties();
        try{
            $dao->create_current_game($pseudo, $gamePlate, 0);
        } catch (SQLException $e) {
            throw new SQLException($e->getMessage());
        }
        return new GamePlate($pseudo, $gamePlate, 0);
    }

    /**
     * Récupère le plateau de jeu en cours du joueurs.
     * @param string $pseudo Le pseudo du joueur.
     * @return GamePlate Le plateau de jeu en cours du joueurs.
     * @throws SQLException Si une erreur SQL se produit.
     */
    public static function load(string $pseudo): GamePlate {
        $dao = new DAOParties();
        try {
            if($dao->exists_current_game($pseudo)) {
                $game = $dao->get_current_game($pseudo);
                return new GamePlate($pseudo, $game['gameplate'], $game['score']);
            }else{
                return self::create_new($pseudo);
            }
        } catch (SQLException $e) {
            throw new SQLException($e->getMessage());
        }
    }

    /**
     * Récupère le plateau de jeu au mouvement précédent du joueurs.
     * @param string $pseudo Le pseudo du joueur.
     * @return GamePlate Le plateau de jeu en cours du joueurs.
     * @see GamePlate::load() Si le joueur a déjà utiliser cette action au tour précédent.
     * @throws SQLException Si une erreur SQL se produit.
     */
    public static function load_previous(string $pseudo): GamePlate {
        $dao = new DAOParties();
        try {
            if($dao->exists_current_game($pseudo)) {
                $game = $dao->get_previous_current_game($pseudo);
                return new GamePlate($pseudo, $game['gameplate'], $game['score']);
            }else{
                return self::create_new($pseudo);
            }
        } catch (SQLException $e) {
            throw new SQLException($e->getMessage());
        }
    }
    //endregion


    //region PUBLIC INSTANCE
    /**
     * Méthode permettant de faire un déplacement, et tester si le joueur a gagné.
     * @param string $move Un déplacement choisi entre "up", "left", "down", "right".
     * @return string Retourne <code>won</code> si le joueur a gagné, <code>lost</code> si le joueur a perdu ou <code>continue</code> si la partie n'est pas terminé.
     * @throws SQLException Si une erreur SQL se produit.
     */
    public function move(string $move): string {

        $before = $this->gamePlate;

        $this->arrange($move);
        $this->fusion($move);
        $this->arrange($move);

        $after = $this->gamePlate;


        if($this->has_won()) {
            $this->dao->add_score($this->pseudo, true, $this->score);
            return "won";
        }

        if(!$this->any_zeros() && $this->is_full()) {
            $this->dao->add_score($this->pseudo, false, $this->score);
            return "lost";
        }

        if($before != $after) {
            do {
                $randValueX = rand(0,3);
                $randValueY = rand(0,3);
            } while($this->gamePlate[$randValueX][$randValueY] != 0);
            $this->gamePlate[$randValueX][$randValueY] = 4/rand(1,2);
        }

        if($this->is_full()) {
            $this->dao->add_score($this->pseudo, false, $this->score);
            return "lost";
        }

        $this->dao->update_current_game($this->pseudo, $this->gamePlate, $this->score);
        return "continue";
    }

    /**
     * Méthode permettant de récupérer le plateau de jeu et le score en HTML pour être affiché.
     * @return string Le plateau de jeu en version HTML.
     */
    public function to_html(): string {
        $str = <<<EOF
            <div class='scoreHead'>
                <div class='score'>Score : $this->score</div>
                <form action='/' method='get' class='scoreButtons'>
                    <button class="btn-square" type='submit' name='previous' title='Précédent'>
                        <img src='/assets/backward-solid.svg' alt='Précédent'>
                    </button>
                    <button class="btn-square" type='submit' name='reset' title='Recommencer'>
                        <img src='/assets/redo-solid.svg' alt='Recommencer'>
                    </button>
                </form>
            </div>
            <div class='grid-container'>
        EOF;
        for($i=0; $i<4; $i++){
            for($j=0; $j<4; $j++) {
                $value = $this->gamePlate[$i][$j]==0?"":$this->gamePlate[$i][$j];
                $str .= "<div class='tile".($value!=""?" tile-$value":"")."'>$value</div>";
            }
        }
        return $str . "</div>";
    }
    //endregion


    //region PRIVATE INSTANCE
    /**
     * Méthode qui permet de faire les fusions sur les lignes ou colonnes selon un déplacement choisi.
     * @param string $move Un déplacement choisi entre "up", "left", "down", "right".
     */
    private function fusion(string $move): void {
        for($i = 0; $i < 4; $i++) {
            if($move == "up" || $move == "left") {
                for($j = 0; $j < 3; $j++) {
                    if($this->gamePlate[$j][$i] == $this->gamePlate[$j+1][$i] && $move == "up") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j+1][$i] = 0;
                        $this->score += $this->gamePlate[$j][$i];
                    }else if($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j+1] && $move == "left") {
                        $this->gamePlate[$i][$j] *= 2;
                        $this->gamePlate[$i][$j+1] = 0;
                        $this->score += $this->gamePlate[$i][$j];
                    }
                }
            }else if($move == "down" || $move == "right") {
                for($j = 3; $j > 0; $j--) {
                    if ($this->gamePlate[$j][$i] == $this->gamePlate[$j-1][$i] && $move == "down") {
                        $this->gamePlate[$j][$i] *= 2;
                        $this->gamePlate[$j-1][$i] = 0;
                        $this->score += $this->gamePlate[$j][$i];
                    } else if ($this->gamePlate[$i][$j] == $this->gamePlate[$i][$j-1] && $move == "right") {
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
     * @param string $move Un déplacement choisi entre "up", "left", "down", "right".
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
            for($j = 0; $j < 4; $j++) {
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
    private function is_full(): bool {
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
            if($this->gamePlate[$i][3] == $this->gamePlate[$i+1][3]
                || $this->gamePlate[3][$i] == $this->gamePlate[3][$i+1]) {
                return false;
            }
        }
        return true;
    }

    /**
     * Méthode permettant de savoir s'il reste des cases vide sur le plateau.
     * @return bool Vrai s'il reste des cases vides, faux sinon.
     */
    private function any_zeros() : bool {
        for($i=0; $i<4; $i++) {
            for($j=0; $j<4; $j++) {
                if($this->gamePlate[$i][$j] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    //endregion

}
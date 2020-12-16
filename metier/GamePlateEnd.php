<?php

include_once PATH_METIER."/CreateHTMLException.php";

/**
 * Classe représentant le plateau de jeu final avec les scores et les informations sur le joueur.
 */
class GamePlateEnd {

    //region ATTRIBUTES
    /**
     * @var DAOParties Le DAO de la table JOUEURS.
     */
    private $dao;
    /**
     * @var string Le pseudo du joueur.
     */
    private $pseudo;
    //endregion


    /**
     * Constructeur de GamePlateEnd.
     * @param string $pseudo Le pseudo du joueur
     */
    private function __construct (string $pseudo) {
        $this->dao = new DAOParties();
        $this->pseudo = $pseudo;
    }


    //region STATIC
    /**
     * Méthode servant de constructeur pour la classe GamePlateEnd.
     * @param string $pseudo Le pseudo du joueur.
     * @return GamePlateEnd Une instance de la classe GamePlateEnd.
     */
    public static function build(string $pseudo): GamePlateEnd {
        return new GamePlateEnd($pseudo);
    }
    //endregion


    //region PUBLIC INSTANCE
    /**
     * @param string $gameplate Le plateau de jeu.
     * @return string Le plateau de jeu final avec les scores et les informations sur le joueur.
     * @throws CreateHTMLException Si le HTML n'a pu être générer.
     */
    public function to_html(string $gameplate): string {
        return <<<EOF
            <div class="m-5 d-flex">
                <div class="mr-5">
                    $gameplate
                </div>
                <div class="my-auto">
                    {$this->create_player_informations()}
                    {$this->create_score_tab()}
                </div>
            </div>
        EOF;
    }
    //endregion


    //region PRIVATE INSTANCE
    /**
     * Méthode permettant de créer et de mettre au format HTML les statistiques du joueur.
     * @return string Retourne les statistiques du joueur au format HTML.
     * @throws CreateHTMLException Si le HTML n'a pu être générer a cause d'une erreur SQL.
     */
    private function create_player_informations(): string {
        try{
            return $this->dao->get_player_informations($this->pseudo)->to_html();
        }catch (SQLException $e){
            throw new CreateHTMLException("Le html n'a pas pu être généré du a une erreur SQL");
        }
    }

    /**
     * Méthode permettant de créer et de mettre au format HTML le tableau des scores.
     * @return string Retourne le tableau des scores au format HTML.
     * @throws CreateHTMLException Si le HTML n'a pu être générer a cause d'une erreur SQL.
     */
    private function create_score_tab(): string {
        try {
            $scores = $this->dao->get_best_games(3);
            $str = <<<EOF
                <div class='scoresTab'>
                    <table class='table'>
                        <thead class='bg-grey2048'>
                             <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Pseudo</th>
                                <th scope='col'>Score</th>                              
                                <th scope='col'>Gagné ?</th>
                             </tr>
                        </thead>
                        <tbody>
            EOF;
            for($i=1; $i<sizeof($scores)+1; $i++) {
                $str .= <<<EOF
                    <tr class="bg-lgrey2048">
                        <th scope='row'>$i</th>
                        <td>{$scores[$i-1]['pseudo']}</td>
                        <td>{$scores[$i-1]['score']}</td>
                EOF .  "<td>".($scores[$i-1]['win']==1 ? "Oui" : "Non")."</td>
                    </tr>";
            }
            return $str . "</tbody></table></div>";
        } catch (SQLException $e) {
            throw new CreateHTMLException("Le html n'a pas pu être généré du a une erreur SQL");
        }
    }
    //endregion

}
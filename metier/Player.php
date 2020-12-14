<?php


/**
 * Classe Player
 * Représente un joueur avec ses statistiques.
 */
class Player {

    //region ATTRIBUTES
    private $pseudo;
    private $bestScore;
    private $nbGame;
    private $nbGameWin;
    //endregion


    /**
     * Constructeur de la classe Player.
     * @param string $pseudo Le pseudo du joueur.
     * @param int $bestScore Le meilleur score du joueur.
     * @param int $nbGame Le nombre de parties jouées par le joueur.
     * @param int $nbGameWin Le nombre de parties gagnées par le joueur.
     */
    public function __construct(string $pseudo, int $bestScore, int $nbGame, int $nbGameWin) {
        $this->pseudo = $pseudo;
        $this->bestScore = $bestScore;
        $this->nbGame = $nbGame;
        $this->nbGameWin = $nbGameWin;
    }

    public function to_html(): string {
        $ratio = number_format($this->nbGameWin/$this->nbGame, 2);
        return <<<EOF
        <div class="card rounded border-0 mb-2">
            <div class="card-header bg-grey2048">
                <h4 class="card-title text-center m-0">$this->pseudo</h4>
            </div>
            <div class="card-body bg-lgrey2048 rounded-bottom">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-lgrey2048">Meilleur score : <b>$this->bestScore pts</b></li>
                    <li class="list-group-item bg-lgrey2048">Parties jouées : <b>$this->nbGame</b></li>
                    <li class="list-group-item bg-lgrey2048">Parties gagnées : <b>$this->nbGameWin</b></li>
                    <li class="list-group-item bg-lgrey2048">Ratio : <b>$ratio</b></li>
                </ul>
            </div>
        </div>
        EOF;
    }


    //region PUBLIC INSTANCE
    /**
     * Getter permettant de récupérer le pseudo du joueur.
     * @return string Le pseudo du joueur.
     */
    public function get_pseudo(): string {
        return $this->pseudo;
    }

    /**
     * Getter permettant de récupérer le meilleur score du joueur.
     * @return int Le meilleur score du joueur.
     */
    public function get_bestScore(): int {
        return $this->bestScore;
    }

    /**
     * Getter permettant de récupérer le nombre de parties jouées.
     * @return int Le nombre de parties jouées.
     */
    public function get_nbGame(): int {
        return $this->nbGame;
    }

    /**
     * Getter permettant de récupérer le nombre de parties gagnées.
     * @return int Le nombre de parties gagnées.
     */
    public function get_nbGameWin(): int {
        return $this->nbGameWin;
    }
    //endregion

}
<?php


/**
 * Classe Player
 * Représente un joueur avec ses statistiques.
 */
class Player {

    private $pseudo;
    private $bestScore;
    private $nbGame;
    private $nbGameWin;

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


}
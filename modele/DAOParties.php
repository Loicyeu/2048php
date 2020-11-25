<?php

include_once PATH_MODELE."/BDException.php";
include_once PATH_MODELE."/SqliteConnexion.php";

class DAOParties {

    private $connexion;

    /**
     * DAOParties constructor.
     */
    public function __construct() {
        $this->connexion = SqliteConnexion::getInstance()->getConnexion();
    }

    /**
     * Méthode permettant de créer une partie de 2048 dans la base donnée.
     * @param bool $win Vrai si le joueur a gagné, faux sinon.
     * @param int $score Le score du joueur.
     * @return bool Vrai si la partie a été ajouté, faux sinon.
     * @throws SQLException Si un erreur se passe lors de la requête SQL.
     */
    public function add_score(bool $win, int $score) {
        if(!isset($_SESSION['pseudo']))
            throw new RuntimeException("Aucun joueur n'est connecté.");

        try{
            $statement = $this->connexion->prepare("INSERT INTO PARTIES(pseudo, gagne, score) VALUES(?, ?, ?)");
            $statement->execute(array($_SESSION['pseudo'], $win, $score));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            throw new SQLException("Problème requête SQL sur la table parties");
        }
    }


    public function create_current_game() {
        if(!isset($_SESSION['pseudo']))
            throw new RuntimeException("Aucun joueur n'est connecté.");

    }
}
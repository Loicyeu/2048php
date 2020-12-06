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
     * Méthode permettant d'ajouter une partie terminée de 2048 dans la base de donnée et de supprimer la partie en cours correspondante.
     * @param string $pseudo le pseudo du joueur
     * @param bool $win Vrai si le joueur a gagné, faux sinon.
     * @param int $score Le score du joueur.
     * @return bool Vrai si la partie a été ajouté, erreur sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function add_score(string $pseudo, bool $win, int $score): bool {
        try{
            $statement = $this->connexion->prepare("INSERT INTO PARTIES(pseudo, gagne, score) VALUES(?, ?, ?)");
            $statement->execute(array($pseudo, $win, $score));
            $this->delete_current_game($pseudo);
            return true;
        }catch (PDOException $e){
            throw new SQLException("Problème requête SQL sur la table parties");
        }
    }


    /**
     * Méthode permettant de créer une nouvelle partie en cours dans la base de donnée.
     * Si une partie en cours est trouvé, elle sera alors supprimé et remplacé.
     * @param string $pseudo Le pseudo du joueur
     * @param array $gamePlate Le plateau de jeu initialisé
     * @param int $score Le score actuel du joueur
     * @return boolean Vrai si la partie a été créé, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function create_current_game(string $pseudo, array $gamePlate, int $score): bool {
        try{
            if($this->exists_current_game($pseudo))
                $this->delete_current_game($pseudo);
            $statement = $this->connexion->prepare("INSERT INTO CURRENT_PARTIES VALUES(?, ?, ?, ?, ?)");
            $statement->execute(array($pseudo, serialize($gamePlate), $score, serialize($gamePlate), $score));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }

    /**
     * Méthode permettant de mettre a jour la partie actuelle dans la base de donnée.
     * @param string $pseudo Le pseudo du joueur
     * @param array $gamePlate Le plateau de jeu actuel
     * @param int $score le score actuel
     * @return bool Vrai si la partie a été sauvegardé, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function update_current_game(string $pseudo, array $gamePlate, int $score): bool {
        try{
            $previous = $this->get_current_game($pseudo);
            $statement = $this->connexion->prepare("UPDATE CURRENT_PARTIES SET gameplate=?, score=?, previousgameplate=?, previousscore=? WHERE pseudo=?");
            return $statement->execute(array(serialize($gamePlate), $score, serialize($previous["gameplate"]), $previous["score"], $pseudo));
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }

    /**
     * Méthode permettant de récupérer la partie actuelle dans la base de donnée
     * @param string $pseudo Le pseudo du joueur
     * @return array Un dictionnaire contenant la <tt>gameplate</tt> et le <tt>score</tt>
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function get_current_game(string $pseudo): array {
        try {
            $statement = $this->connexion->prepare("SELECT gameplate, score FROM CURRENT_PARTIES WHERE pseudo=?");
            $statement->execute(array($pseudo));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $result["gameplate"] = unserialize($result["gameplate"]);
            return $result;
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }

    /**
     * Méthode permettant de récupérer la partie actuelle avec un mouvement de retard dans la base de donnée
     * @param string $pseudo Le pseudo du joueur
     * @return array Un dictionnaire contenant la <tt>gameplate</tt> et le <tt>score</tt>
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function get_previous_current_game(string $pseudo): array {
        try {
            $statement = $this->connexion->prepare("SELECT previousgameplate as gameplate, previousscore as score FROM CURRENT_PARTIES WHERE pseudo=?");
            $statement->execute(array($pseudo));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $result["gameplate"] = unserialize($result["gameplate"]);
            return $result;
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }

    /**
     * Méthode permettant de supprimer la partie en cours d'un joueur
     * @param string $pseudo le pseudo du joueur
     * @return bool vrai si la partie a été supprimé, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function delete_current_game(string $pseudo): bool {
        try {
            $statement = $this->connexion->prepare("DELETE FROM CURRENT_PARTIES WHERE pseudo=?");
            $statement->execute(array($pseudo));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }

    /**
     * Méthode permettant de savoir si un joueur a une partie en cours dans la base de donnée.
     * @param string $pseudo Le pseudo du joueur.
     * @return bool Vrai si le joueur a une partie en cours, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function exists_current_game(string  $pseudo): bool {
        try {
            $statement = $this->connexion->prepare("SELECT COUNT(pseudo) AS nb FROM CURRENT_PARTIES WHERE pseudo=? LIMIT 1");
            $statement->execute(array($pseudo));
            return $statement->fetch(PDO::FETCH_ASSOC)['nb'];
        }catch (PDOException $e) {
            throw new SQLException("Problème requête SQL sur la table current_parties");
        }
    }
}

























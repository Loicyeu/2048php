<?php

include_once PATH_MODELE."/BDException.php";
include_once PATH_MODELE."/SqliteConnexion.php";
include_once PATH_METIER."/Player.php";

/**
 * Classe DAOParties
 * Gère les tables PARTIES et CURRENT_PARTIES de la base de donnée.
 */
class DAOParties {

    //region ATTRIBUTES
    /**
     * @var PDO La connexion SQLite.
     */
    private $connexion;

    private const ERROR_MESSAGE_PARTIES = "Problème requête SQL sur la table parties";
    private const ERROR_MESSAGE_CURRENT = "Problème requête SQL sur la table current_parties";
    //endregion


    /**
     * Constructeur de DAOParties.
     */
    public function __construct() {
        $this->connexion = SqliteConnexion::getInstance()->getConnexion();
    }


    //region PUBLIC INSTANCE
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
            $statement->execute(array($pseudo, $win?1:0, $score));
            $this->delete_all_current_game($pseudo);
            return true;
        }catch (PDOException $e){
            throw new SQLException(self::ERROR_MESSAGE_PARTIES);
        }
    }

    /**
     * Méthode permettant de récupérer les <code>number</code> meilleurs scores.
     * @param int $number Le nombre de meilleurs score a prendre.
     * @return array Un tableau de tableau comportant les pseudos, scores et si les joueurs ont gagnés.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function get_best_games(int $number): array {
        try{
            $statement = $this->connexion->prepare("SELECT pseudo, gagne as win, score FROM PARTIES ORDER BY score DESC LIMIT ?");
            $statement->execute(array($number));
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }

    /**
     * Méthode permettant de récupérer le nombre de parties jouées, de parties gagnées et le meilleur score du joueur.
     * @param string $pseudo le pseudo du joueur.
     * @return Player Un player avec les données souhaitées.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function get_player_informations(string $pseudo): Player {
        try{
            $statement = $this->connexion->prepare("SELECT score as bestScore FROM PARTIES WHERE pseudo=? ORDER BY score DESC LIMIT 1");
            $statement->execute(array($pseudo));
            $result1 = $statement->fetchAll(PDO::FETCH_COLUMN);
            $statement = $this->connexion->prepare("SELECT COUNT(pseudo) as nbGame FROM PARTIES WHERE pseudo=?");
            $statement->execute(array($pseudo));
            $result2 = $statement->fetchAll(PDO::FETCH_COLUMN);
            $statement = $this->connexion->prepare("SELECT COUNT(pseudo) as nbGameWin FROM PARTIES WHERE pseudo=? AND gagne=1");
            $statement->execute(array($pseudo));
            $result3 = $statement->fetchAll(PDO::FETCH_COLUMN);
            return new Player($pseudo, $result1[0], $result2[0], $result3[0]);
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
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
            if($this->exists_current_game($pseudo)) {
                $this->delete_all_current_game($pseudo);
            }
            $statement = $this->connexion->prepare("INSERT INTO CURRENT_PARTIES VALUES(?, ?, ?, ?)");
            $statement->execute(array($pseudo, 0, serialize($gamePlate), $score));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
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
            $number = $this->get_current_game_number($pseudo);
            if($number==-1) {
                throw new SQLException("Aucune partie en cours trouvé.");
            }
            $statement = $this->connexion->prepare("INSERT INTO CURRENT_PARTIES VALUES(?, ?, ?, ?)");
            return $statement->execute(array($pseudo, $number+1, serialize($gamePlate), $score));
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
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
            $statement = $this->connexion->prepare("SELECT gameplate, score FROM CURRENT_PARTIES WHERE pseudo=? ORDER BY number DESC LIMIT 1");
            $statement->execute(array($pseudo));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $result["gameplate"] = unserialize($result["gameplate"]);
            return $result;
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }

    /**
     * Méthode permettant de récupérer la partie actuelle avec un mouvement de retard dans la base de donnée.
     * Cette méthode supprime également le mouvement actuel de la base de donnée.
     * S'il n'y a pas de mouvement précédent alors la méthode retourne la partie actuelle.
     * @param string $pseudo Le pseudo du joueur.
     * @return array Un dictionnaire contenant la <tt>gameplate</tt> et le <tt>score</tt>.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function get_previous_current_game(string $pseudo): array {
        try {
            $statement = $this->connexion->prepare("SELECT gameplate, score FROM CURRENT_PARTIES WHERE pseudo=? ORDER BY number DESC LIMIT 1 OFFSET 1");
            $statement->execute(array($pseudo));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(!$result) {
                return $this->get_current_game($pseudo);
            }
            $this->delete_current_game($pseudo);
            $result["gameplate"] = unserialize($result["gameplate"]);
            return $result;
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }

    /**
     * Méthode permettant de supprimer la partie en cours d'un joueur
     * @param string $pseudo le pseudo du joueur
     * @return bool vrai si la partie a été supprimé, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function delete_all_current_game(string $pseudo): bool {
        try {
            $statement = $this->connexion->prepare("DELETE FROM CURRENT_PARTIES WHERE pseudo=?");
            $statement->execute(array($pseudo));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
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
            $number = $this->get_current_game_number($pseudo);
            if($number==-1) {
                throw new SQLException(self::ERROR_MESSAGE_CURRENT);
            }
            $statement = $this->connexion->prepare("DELETE FROM CURRENT_PARTIES WHERE pseudo=? AND number=?");
            $statement->execute(array($pseudo, $number));
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }

    /**
     * Méthode permettant de savoir si un joueur a une partie en cours dans la base de donnée.
     * @param string $pseudo Le pseudo du joueur.
     * @return bool Vrai si le joueur a une partie en cours, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function exists_current_game(string $pseudo): bool {
        try {
            $statement = $this->connexion->prepare("SELECT COUNT(pseudo) AS nb FROM CURRENT_PARTIES WHERE pseudo=? LIMIT 1");
            $statement->execute(array($pseudo));
            return $statement->fetch(PDO::FETCH_ASSOC)['nb'];
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }
    //endregion


    //region PRIVATE INSTANCE
    /**
     * Méthode permettant d'obtenir le numéro de la partie précédente.
     * @param string $pseudo le pseudo du joueur.
     * @return int Retourne le numéro de la partie en cours, -1 si il n'y en a pas.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    private function get_current_game_number(string $pseudo): int {
        try {
            $statement = $this->connexion->prepare("SELECT number FROM CURRENT_PARTIES WHERE pseudo=? ORDER BY number DESC LIMIT 1");
            $statement->execute(array($pseudo));
            return $statement->fetch(PDO::FETCH_ASSOC)['number'];
        }catch (PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_CURRENT);
        }
    }
    //endregion

}
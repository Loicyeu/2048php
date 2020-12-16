<?php

include_once PATH_MODELE."/BDException.php";
include_once PATH_MODELE."/SqliteConnexion.php";

/**
 * Classe DAOUser.
 * Gère la classe JOUEURS.
 */
class DAOUser {

    //region ATTRIBUTES
    /**
     * @var PDO La connexion SQLite
     */
    private $connexion;

    private const ERROR_MESSAGE_JOUEURS = "Problème requête SQL sur la table joueur";
    //endregion


    /**
     * Constructeur de DAOUser.
     */
    public function __construct() {
        $this->connexion = SqliteConnexion::getInstance()->getConnexion();
    }


    //region PUBLIC INSTANCE
    /**
     * Méthode permettant de savoir si un couple pseudo/mot de passe existe.
     * @param string $pseudo Le pseudo a tester
     * @param string $password Le mot de passe du joueur
     * @return boolean vrai si le joueur existe dans la base de données, faux si il n'existe pas
     * @throws SQLException Si une erreur se passe lors de la requête SQL
     */
    public function exists(string $pseudo, string $password): bool {
        try {
            $statement = $this->connexion->prepare("SELECT password FROM JOUEURS WHERE pseudo=?");
            $statement->execute(array($pseudo));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return password_verify($password, $result["password"]);
        } catch(PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_JOUEURS);
        }
    }

    /**
     * Méthode permettant de savoir un pseudo existe dans la base de données.
     * @param string $pseudo Le pseudo a tester
     * @return bool Vrai si le pseudo existe, faux sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL
     */
    public function exists_pseudo(string $pseudo): bool {
        try {
            $statement = $this->connexion->prepare("SELECT pseudo FROM JOUEURS WHERE pseudo=?");
            $statement->execute(array($pseudo));
            return  $statement->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_JOUEURS);
        }
    }

    /**
     * Méthode permettant de créer un utilisateur dans la base de donnée.
     * @param string $pseudo Le pseudo du nouvel utilisateur
     * @param string $password Le mot de passe du nouvel utilisateur
     * @return bool Vrai si l'utilisateur a été créer, erreur sinon.
     * @throws SQLException Si une erreur se passe lors de la requête SQL.
     */
    public function create(string $pseudo, string $password): bool {
        try {
            $statement = $this->connexion->prepare("INSERT INTO JOUEURS VALUES(?, ?)");
            $statement->execute(array($pseudo, password_hash($password, PASSWORD_DEFAULT)));
            return $statement->fetch(PDO::FETCH_ASSOC)==1;
        } catch(PDOException $e) {
            throw new SQLException(self::ERROR_MESSAGE_JOUEURS);
        }
    }
    //endregion

}
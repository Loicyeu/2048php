<?php

include_once PATH_MODELE."/BDException.php";
include_once PATH_MODELE."/SqliteConnexion.php";

class DAOUser {

    private $connexion;

    public function __construct() {
        $this->connexion = SqliteConnexion::getInstance()->getConnexion();
    }

    /**
     * @param string $pseudo
     * @param string $password
     * @return boolean vrai si le user existe dans la base de données, faux si il n'éxiste pas
     */
    public function exists(string $pseudo, string $password) {
        try {
            $statement = $this->connexion->prepare("select * from PARTIES"); //select j.password from joueurs j where j.pseudo=?
//            $statement->bindParam(1, $pseudo);
            $statement->execute();
            $result= $statement->fetch(PDO::FETCH_ASSOC);
            echo $result;
            return password_verify($password);

        } catch(PDOException $e) {
            print_r($e->getMessage());
            print_r($e->getLine());
//            throw new SQLException("problème requête SQL sur la table joueur");
        }
    }

}
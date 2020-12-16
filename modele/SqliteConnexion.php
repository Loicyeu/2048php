<?php

require_once("BDException.php");

/**
 * Classe SqliteConnexion.
 */
class SqliteConnexion {

    //region ATTRIBUTES
    /**
     * @var SqliteConnexion L'instance de la classe.
     */
	private static $instance;

    /**
     * @var PDO Une connexion à la base de données.
     */
	private $connexion;
	//endregion


    /**
     * constructeur de SqliteConnexion.
     * @throws ConnexionException
     */
	private function  __construct() {
		try {
			$dir = PATH_DATABASE;
			$this->connexion = new PDO("sqlite:$dir");
			$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			throw new ConnexionException("problème de connexion");
		}
	}


	//region STATIC
    /**
     * Méthode permettant de récupérer la connexion a Sqlite
     * @return SqliteConnexion
     */
	public static function getInstance(): SqliteConnexion{  
		if(is_null(self::$instance)){
			self::$instance = new SqliteConnexion();
		}
		return self::$instance;
	}
	//endregion


    //region PUBLIC INSTANCE
    /**
     * Méthode qui retourne une connexion à la base de données.
     * @return PDO Une connexion à la base de données SQLite.
     */
	public function getConnexion(): PDO {
		return $this->connexion;
	}

    /**
     * Méthode qui ferme la connexion à la base de données.
     */
	public function closeConnexion() {
		$this->connexion=null;
	}
	//endregion
}

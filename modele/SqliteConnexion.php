<?php
require_once("BDException.php");

class SqliteConnexion {
	
	private static $instance;
	private $connexion;

	private function  __construct() {
		try {

			//à la place utiliser une constante qui sera initialisée dans config/config.php
			$dir = dirname(__DIR__);
			echo $dir;
			// pas de host, ni de user, ni de password 
			$this->connexion = new PDO("sqlite:$dir/db2048.db");
			$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			throw new ConnexionException("problème de connexion");
		}
	}

	public static function getInstance(): SqliteConnexion{  
		if(is_null(self::$instance)){
			self::$instance = new SqliteConnexion();
		}
		return self::$instance;
	}


	public function getConnexion(): PDO{
		return $this->connexion;
	}

	public function closeConnexion() {
		$this->connexion=null;
	}

}
?>

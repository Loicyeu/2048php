<?php

// Classe generale de definition d'exception
class BDException extends Exception{
 public function __construct($chaine){
 	parent::__construct($chaine);
}

}


// Exception relative à un probleme de connexion
class ConnexionException extends BDException{
 public function __construct($chaine){
 	parent::__construct($chaine);
 }


}

// Exception relative à un probleme SQL
class SQLException extends BDException{
	 public function __construct($chaine){
 	parent::__construct($chaine);
}
}

<?php
session_start();

/**
 * Class BDException
 * Classe générale de définition d'exception
 */
class BDException extends Exception {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}


/**
 * Class ConnexionException
 * Exception relative à un probleme de connexion
 */
class ConnexionException extends BDException {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }


}

/**
 * Class SQLException
 * Exception relative à un probleme SQL
 */
class SQLException extends BDException {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }
}
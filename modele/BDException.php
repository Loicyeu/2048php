<?php

/**
 * Classe BDException.
 * Classe générale de définition d'exception.
 */
class BDException extends Exception {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}

/**
 * Classe ConnexionException.
 * Exception relative à un problème de connexion.
 */
class ConnexionException extends BDException {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }


}

/**
 * Classe SQLException.
 * Exception relative à un problème SQL.
 */
class SQLException extends BDException {

    public function __construct($chaine) {
        parent::__construct($chaine);
    }
}
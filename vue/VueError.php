<?php

/**
 * Classe VueError.
 * Vue d'une erreur.
 */
class VueError {

    /**
     * Méthode permettant d'afficher une erreur.
     * @param string $error L'erreur a afficher.
     * @param string $pageToGo La page vers laquelle rediriger, par défaut la page d'accueil.
     */
    public function display(string $error="", string $pageToGo="/") {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo "<h1>$error</h1>";
        echo "<a href='$pageToGo'><-- Retour</a>";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
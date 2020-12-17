<?php

/**
 * Classe VueError.
 * Vue d'une erreur.
 */
class VueError {

    /**
     * Méthode permettant d'afficher une erreur.
     * Et vous propose un service alternatif de qualité pour jouer au 2048.
     * @param string $error L'erreur a afficher.
     * @param string $pageToGo La page vers laquelle rediriger, par défaut la page d'accueil.
     */
    public function display(string $error="", string $pageToGo="/") {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo <<<EOF
        <div class="h-100 pt-5">
            <div class="container-fluid m-auto text-center">
                <img class="mx-auto" src="/assets/2048_logo.png" alt="Logo 2048" width="72" height="72">
                <h1>Malgré tous nos efforts des erreurs subsistent et vous en avez fait les frais...</h1>
                <h4 class="text-secondary">
                    Nous vous proposons donc d'aller voir ailleurs : <a href="https://2048.lgazeau.fr" title="La référence en 2048">2048.lgazeau.fr</a>
                </h4>
                <h3 class="text-danger mt-5">--> $error <--</h3>
                <p>Sinon vous pouvez revenir la où vous en étiez : <a href='$pageToGo'>Retour ?</a></p>
            </div>
        </div>
        EOF;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
<?php

/**
 * Classe VueGame.
 * Vue représentant la partie.
 */
class VueGame {

    //region PUBLIC INSTANCE
    /**
     * Méthode permettant d'afficher le plateau de jeu, le score et les flèches de déplacement.
     * @param string $html Le plateau de jeu et le score en html.
     */
    public function display(string $html) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo <<<EOF
            <div class='d-flex'>
                <div class='m-5'>
                    $html
                </div>
                <form action='/' method='GET' class='move-grid'>
                    <button type='submit' name='move' value='up' class='up btn-square'>
                        <img src='assets/arrow-up-solid.svg' alt='/\'/>
                    </button>
                    <button type='submit' name='move' value='left' class='left btn-square'>
                        <img src='assets/arrow-left-solid.svg' alt='>'/>
                    </button>
                    <button type='submit' name='move' value='right' class='right btn-square'>
                        <img src='assets/arrow-right-solid.svg' alt='V'/>
                    </button>
                    <button type='submit' name='move' value='down' class='down btn-square'>
                        <img src='assets/arrow-down-solid.svg' alt='<'/>
                    </button>
                </form>
            </div>
            EOF;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    /**
     * Méthode permettant d'afficher le menu de départ ou le joueur peut choisir s'il veut charger sa sauvegarde,
     * ou la supprimer et recommencer une partie.
     */
    public function display_home() {
        include(PATH_HTMLCSS . "/htmlHead.php");

        echo <<<EOF
        <div class='m-5'>
            <div class='scoreHead'>
                <div class='score'>Score : 0</div>
                <div class='scoreButtons'>
                    <button title='Précédent' class='btn-square'>
                        <img src='/assets/backward-solid.svg' alt='Précédent'>
                    </button>
                    <button title='Recommencer' class='btn-square'>
                        <img src='/assets/redo-solid.svg' alt='Recommencer'>
                    </button>
                </div>
            </div>
        EOF;

        $str = "<div class='grid-container'>";
        for ($i=0; $i<16; $i++) {
            $str .= "<div class='tile'></div>";
        }
        $str .= "</div></div>";
        echo $str;

        echo <<<EOF
        <div class='menu m-5'>
            <h1 class='menu'>Le jeu du 2048</h1>
            <form method='post' action='/' class='text-center'>
                <input class='menu' type='submit' value='Nouvelle partie' name='new' title='Attention cette action supprimera la sauvegarde en cours'>
                <input class='menu' type='submit' value='Charger partie' name='save'>
            </form>
        </div>
        EOF;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }
    //endregion

}
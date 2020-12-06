<?php

class VueGame {

    /**
     * Méthode permettant d'afficher le plateau de jeu, le score et les flèches de déplacement.
     * @param string $html Le plateau de jeu et le score en html.
     */
    public function display(string $html) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo $html;
        echo "<form action='/' method='GET' class='move-grid'>
                <button type='submit' name='move' value='up' class='up'>
                    <img src='assets/arrow-up-solid.svg' alt='/\'/>
                </button>
                <button type='submit' name='move' value='left' class='left'>
                    <img src='assets/arrow-left-solid.svg' alt='>'/>
                </button>
                <button type='submit' name='move' value='right' class='right'>
                    <img src='assets/arrow-right-solid.svg' alt='V'/>
                </button>
                <button type='submit' name='move' value='down' class='down'>
                    <img src='assets/arrow-down-solid.svg' alt='<'/>
                </button>
            </form>";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    /**
     * Méthode permettant d'afficher le menu de départ ou le joueur peut choisir s'il veut charger sa sauvegarde,
     * ou la supprimer et recommencer une partie.
     */
    public function display_home() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        $str = "<div class='grid-container blur'>";
        for ($i=0; $i<16; $i++)
            $str .= "<div class='tile'></div>";
        $str .= "</div>";

        echo $str;
        echo "
        <div class='menu'>
            <h1 style='text-align: center; margin-top: 5px'>Le jeu du 2048</h1>
            <form method='post' action='/' style='text-align: center'>
                <input type='submit' value='Nouvelle partie' name='new' title='Attention cette action supprimera la sauvegarde en cours'>
            </form>
            <form method='post' action='/' style='text-align: center'>
                <input type='submit' value='Charger partie' name='save'>
            </form>
        </div>
        ";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
<?php

class VueResult {

    public function display(bool $win, string $html) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo $html;
        echo "<div class='menu'><h1 class='menu' style='text-align: center; margin-top: 5px'>Le jeu du 2048</h1>";

        if($win) {
            echo "<h2 class='won'>Félicitation !</h2>";
        }else {
            echo "<h2 class='lost'>Dommage...</h2>";
        }

        echo "</div>";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }
}
<?php

class VueResult {

    public function display(bool $win, string $html) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo <<<EOF
        $html
        <form class='menu m-5 d-flex flex-column justify-content-center' action="/" method="post">
            <h1 class='menu text-center' style="text-shadow: 10px 0 8px black">Le jeu du 2048</h1>
        EOF;

        if($win) {
            echo <<<EOF
            <h2 class='won' style="text-shadow: 10px 0 8px green">Félicitation !</h2>
            <button class="btn bg-grey2048 mx-auto mt-4" type="submit" style="box-shadow: 10px 0 8px #BBADA0">On recommence ?</button>
            EOF;
        }else {
            echo <<<EOF
            <h2 class='lost' style="text-shadow: 10px 0 8px red">Dommage...</h2>
            <button class="btn bg-grey2048 mx-auto mt-4" type="submit" name="new" style="box-shadow: 10px 0 8px #BBADA0">Retenter votre chance ?</button>
            EOF;
        }

        echo <<<EOF
            <button class="btn bg-grey2048 mx-auto mt-4" type="submit" name="disconnect" style="box-shadow: 10px 0 8px #BBADA0">Se déconnecter ?</button>
        </form>
        EOF;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }
}
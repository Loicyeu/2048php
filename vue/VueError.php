<?php

class VueError {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    public function displayTest(string $test) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo "<h1>".$test."</h1>";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
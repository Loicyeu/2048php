<?php

include_once PATH_VUE."/Vue.php";

class VueError implements Vue {

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
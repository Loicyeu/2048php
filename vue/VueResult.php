<?php

class VueResult {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo "bien vu";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }
}
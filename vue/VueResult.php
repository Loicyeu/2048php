<?php

include_once PATH_VUE."/Vue.php";

class VueResult implements Vue {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }
}
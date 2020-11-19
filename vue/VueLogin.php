<?php
session_start();

include_once PATH_VUE."/Vue.php";

class VueLogin implements Vue {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo "
        <form method='post' action='index.php'>
            <label for='pseudo'>Pseudo  : </label>
            <input type='text' id='pseudo' name='pseudo'><br>
            <label for='password'>Mot de passe : </label>
            <input type='password' id='password' name='password'><br>
            <input type='submit' value='Se connecter'>
        </form>
        ";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
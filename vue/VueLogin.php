<?php

include_once PATH_VUE."/Vue.php";

class VueLogin implements Vue {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
//        echo "
//        <form method='post' action='index.php' class='form-group'>
//            <label for='pseudo'>Pseudo  : </label>
//            <input type='text' id='pseudo' name='pseudo'><br>
//            <label for='password'>Mot de passe : </label>
//            <input type='password' id='password' name='password'><br>
//            <input type='submit' value='Se connecter'>
//        </form>
//        ";

        echo "
        <div class='text-center h-100'>
            <form class='form-signin w-25' action='index.php' method='post'>
                <!--<img class='mb-4' src='/docs/4.5/assets/brand/bootstrap-solid.svg' alt='' width='72' height='72'>-->
                <h1 class='h3 mb-3 font-weight-normal'>Please sign in</h1>
                <label for='pseudo' class='sr-only'>Email address</label>
                <input type='text' id='pseudo' name='pseudo' class='form-control' placeholder='Pseudo' required autofocus>
                <label for='password' class='sr-only'>Password</label>
                <input type='password' id='password' name='password' class='form-control' placeholder='Mot de passe' required>
                <br>
                <input type='submit' value='Se connecter'  class='btn btn-lg btn-primary btn-block'>
                <p class='mt-5 mb-3 text-muted'>© 2020-2021</p>
            </form>
        </div>
        ";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
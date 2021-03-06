<?php

/**
 * Classe VueRegister.
 * Vue représentant l'inscription au jeu.
 */
class VueRegister {

    /**
     * Méthode permettant l'affichage de la vue pour s'inscrire.
     */
    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo <<<EOF
        <div class='text-center h-100 pt-5'>
            <form class='w-25 m-auto form-section' action='/?register' method='post'>
                <img class='mb-4' src='assets/2048_logo.png' alt='' width='72' height='72'>
                <h1 class='h3 mb-3 font-weight-normal'>Créer un compte</h1>
                
                <div class='form-label-group'>
                    <input type='text' id='pseudo' name='pseudo' class='form-control' placeholder='Pseudo' required autofocus>
                    <label for='pseudo'>Pseudo</label>
                </div>
                
                <div class='form-label-group'>
                    <input type='password' id='password' name='password' class='form-control' placeholder='Mot de passe' required>
                    <label for='password'>Mot de passe</label>
                </div>
            
                <div class='form-label-group'>
                    <input type='password' id='passwordRepeat' name='passwordRepeat' class='form-control' placeholder='Répéter mot de passe' required>
                    <label for='passwordRepeat'>Répéter mot de passe</label>
                </div>
                
                <br>
                <input type='submit' value='Créer le compte'  class='btn btn-lg btn-primary btn-block'>
                <br>
                <a href='/' class='text-success'>Se connecter ?</a>
                <p class='mt-5 mb-3 text-muted'>Timothé CABON et Loïc HENRY<br>© 2020-2021</p>
            </form>
        </div>
        EOF;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}
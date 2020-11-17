<?php
// Chemin complet de la racine du site sur le serveur.
define("HOME_SITE", dirname(__DIR__));

// Chemin vers les répertoires liés au modèle MVC
define("PATH_CONTROLEUR", HOME_SITE."/controleur");
define("PATH_MODELE", HOME_SITE."/modele");
define("PATH_VUE", HOME_SITE."/vue");

// Données pour la connexion au SGBD
define("PATH_DATABASE", HOME_SITE."/db2048.db");
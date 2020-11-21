<?php
session_start();

include_once "config/config.php";
include_once PATH_CONTROLEUR."/Router.php";

print_r($_GET);
print_r($_POST);

$router = new Router();
$router->route();

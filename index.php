<?php
session_start();

include_once "config/config.php";
include_once PATH_CONTROLEUR."/Router.php";

$router = new Router();
$router->route();

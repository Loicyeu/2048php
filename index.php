<?php
session_start();

include_once "config/config.php";
include_once PATH_CONTROLEUR."/Router.php";

//echo $_SERVER["REQUEST_URI"]."<br>";
//echo $_SERVER["PHP_SELF"];

$router = new Router();
$router->route();

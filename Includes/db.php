<?php
// permet d'avoir accès à la BDD et représente la configuration

define('DB_HOST', 'localhost');
define('DB_NAME', 'sneak-me');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

function getConnection()
{
    /* Utilisation de PDO dans un try and catch afin de se connecter à la bdd */
    // PHP se connecte au SQL s'il y arrive sinon il renvoie une erreur
    try{
        return new PDO('mysql:host='.DB_HOST.';port=3306;dbname='.DB_NAME,DB_USER,DB_PASSWORD,[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On veut un tableau associatif en résultat
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);
    }catch(Exception $exception){
        echo '<h1>'.$exception->getMessage().'</h1>';
        echo '<a href="https://www.google.fr/search?='.$exception->getMessage().'" target="_blank">Recherche google</a>';
        die; // On arrête le code PHP
    }
}

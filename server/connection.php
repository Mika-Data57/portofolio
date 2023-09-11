<?php
$envFilePath = '../.env';
if(!file_exists($envFilePath)){
    die("Le fichier .env est introuvable !");
}
// Paramètres de connexion à la base de données
$envVariables = parse_ini_file($envFilePath);

$server = $envVariables["DB_HOST"]; // Serveur MySQL
$user = $envVariables["DB_USER"]; // Nom d'utilisateur MySQL
$pass = $envVariables["DB_PASS"]; // Mot de passe MySQL
$database = $envVariables["DB_NAME"]; // Nom de la base de données

// Création de la connexion MySQLi
$mysqli = new mysqli($server, $user, $pass, $database);

// Vérification de la connexion
if ($mysqli->connect_error) {
    die("Échec de la connexion : " . $mysqli->connect_error);
}
?>

<?php
// Inclure la page de connexion
require_once("connection.php");

// Requête pour récupérer les données de la table `thumbnail`
$query = "SELECT `id` AS `card_id`, `title`, `description`, `ref_img`, `created_date` FROM `thumbnail`";

// Exécution de la requête
$result = $mysqli->query($query);

// Vérification des résultats
if ($result) {
    // Création d'un tableau pour les données
    $data = array();
    // Parcours des lignes de résultat
    while ($row = $result->fetch_assoc()) {
        // Ajout de chaque ligne au tableau
        $data[] = $row;
    }
    // Libération des résultats
    $result->free();
    
    // Encodage du tableau en format JSON
    $json = json_encode($data, JSON_PRETTY_PRINT);
    // Affichage du JSON
    header('Content-Type: application/json');
    echo $json;

} else {
    echo("Erreur lors de l'exécution de la requête");
}
// Fermeture de la connexion
$mysqli->close();
?>
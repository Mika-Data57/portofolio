<?php 
// Inclure la page de connexion
require_once("connection.php");

// Vérifier si l'ID est passé en GET
if (isset($_POST['card_id']) && !empty($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
    
    $results = ["thumbnail" => [],
                "carousel" => []];
    
    //Table thumbnail
    $query = "SELECT `title`, `description`, `ref_img`, `created_date` FROM `thumbnail` WHERE `id` = {$card_id}";
    $result_thumb = $mysqli->query($query);
    if ($result_thumb) {
        while ($row = $result_thumb->fetch_assoc()) {
            // Ajout de chaque ligne au tableau
            $results["thumbnail"] = $row;
        }
        // Libération des résultats
        $result_thumb->free();
    }
    //Table carousel
    $query = "SELECT `img_url` FROM `carousel` WHERE `card_id` = {$card_id}";
    $result_car = $mysqli->query($query);
    if ($result_car) {
        while ($row = $result_car->fetch_assoc()) {
            // Ajout de chaque ligne au tableau
            array_push($results["carousel"], $row);
        }
        // Libération des résultats
        $result_car->free();
    }
    echo(json_encode($results, JSON_PRETTY_PRINT));
}

?>
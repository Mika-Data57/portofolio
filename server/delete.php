<?php
// Inclure la page de connexion
require_once("connection.php");

// Vérifier si l'ID est passé en GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $image_url = $_GET['img'];

    // Préparer et exécuter la requête DELETE
    $query = "DELETE FROM `thumbnail` WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Supprimer le fichier JPEG
        $image_path = "../" . $image_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        // Rediriger vers une page après la suppression (par exemple, index.html)
        header("Location: ../index.html");
        exit();
    } else {
        echo "Erreur lors de la suppression !";
    }
} else {
    echo "ID de la carte non valide";
}

?>
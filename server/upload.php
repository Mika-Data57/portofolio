<?php
// Inclure la page de connexion
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $createdDate = date('d-m-y h:i:s');
    
    // Vérification et traitement de l'image
    if (isset($_FILES['ref_img']) && $_FILES['ref_img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/img/';
        $uploadFile = $uploadDir . basename($_FILES['ref_img']['name']);
        
        // Déplacez le fichier téléchargé vers le dossier de destination
        if (move_uploaded_file($_FILES['ref_img']['tmp_name'], $uploadFile)) {
            // Préparer la requête d'insertion
            $uploadFile = str_replace('../', '', $uploadFile);
            $stmt = $mysqli->prepare("INSERT INTO thumbnail (`title`, `description`, `ref_img`, `created_date`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $description, $uploadFile, $createdDate);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo "Super ! Votre souvenir de voyage et votre photo ont bien été ajoutés !";
            } else {
                echo "Erreur lors de l'insertion des données : " . $stmt->error;
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé ou une erreur est survenue.";
    }
}
?>

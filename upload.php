<?php

global $target_file;

if(isset($_FILES['fileToUpload']['name'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $valid_extensions = array('xlsx', 'ods', 'xls', 'csv'); 
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image

    if (!in_array(strtolower($fileType), $valid_extensions)) {
        $uploadOk = 0;
        echo 'Extension de fichier invalide';
    } else {
        $uploadOk = 0;
       //  echo "<div class='alert alert-success'><strong>Opération réussie !</strong>Votre nouvelle liste d'étudiants a été ajoutée.</div>";
    }

}

?>
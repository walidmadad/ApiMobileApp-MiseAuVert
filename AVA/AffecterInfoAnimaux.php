<?php
require_once 'database.php';

$affichage = array();
if (!empty($_POST['id_animal']) && !empty($_POST['carnet']) && !empty($_POST['vaccin']) && !empty($_POST['vermi'])&& !empty($_POST['regle']) && !empty($_POST['poids']) && !empty($_POST['age'])) {
    $id_animal = $_POST['id_animal'];
    $regle = $_POST['regle'];
    $carnet = $_POST['carnet'];
    $vaccin= $_POST['vaccin'];
    $vermi = $_POST['vermi'];
    $poids = $_POST['poids'];
    $age = $_POST['age'];

    $conn = connectToDatabase();
    $sqlstmt = $conn->prepare("UPDATE affectation SET Regle=?, Vermifuge_a_jour=?, Vaccin_a_jour=?, Carnet_Vaccination=?, Poids=?, Age=? WHERE animal_id=?");
    $sqlstmt->bind_param("ssssssi",$regle,$vermi,$vaccin,$carnet,$poids,$age,$id_animal);
    if ($sqlstmt->execute()) {
        $affichage = array("status" => "success", "message" => "Animal affecté avec succès");
    } else {
        $affichage = array("status" => "failed", "message" => "Erreur lors de l'affectation de l'animal au box");
    }
}else {
    $affichage = array("status" => "failed", "message" => "Tous les champs sont requis");
}

echo json_encode($affichage, JSON_PRETTY_PRINT);

<?php

require_once 'database.php';

$conn = connectToDatabase();

$sqlstmt = $conn->prepare("SELECT * FROM proprietaire");
$sqlstmt->execute();

$result = $sqlstmt->get_result();

$affichage = array();
if($conn) {
    while ($row = $result->fetch_assoc()) {

        $affichage[] = array(
            "status" => "success",
            "message" => "Data Affichage successfully",
            "id" => $row['id_proprietaire'],
            "nom" => $row['nom_Propietaire'],
            "prenom" => $row['prenom_Propietaire']
            );
        }
} else {
    $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
}

echo json_encode($affichage, JSON_PRETTY_PRINT);
<?php
require_once 'database.php';
$affichage = array();
if (!empty($_POST['id_animal'])){
    $id_animal = $_POST['id_animal'];
    $conn = connectToDatabase();
    $sqlstmt = $conn->prepare("SELECT * FROM affectation WHERE animal_id=?");
    $sqlstmt->bind_param('i', $id_animal);
    $sqlstmt->execute();
    $result = $sqlstmt->get_result();
    if($conn) {
        while ($row = $result->fetch_assoc()) {

            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully",
                "regle" => $row['Regle'],
                "carnet" => $row['Carnet_Vaccination'],
                "vermi" => $row['Vermifuge_a_jour'],
                "vaccin" => $row['Vaccin_a_jour']
            );
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}else {
    $affichage = array("status" => "failed", "message" => "Tous les champs sont requis");
}

echo json_encode($affichage, JSON_PRETTY_PRINT);

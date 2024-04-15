<?php
require_once 'database.php';
if(!empty($_POST['id'])){
    $id_proprietaire = $_POST['id'];


    $conn = connectToDatabase();

    $sqlstmt = $conn->prepare("SELECT id_Animal, nom_animal FROM animal WHERE id_proprietaire = ?");
    $sqlstmt->bind_param("i", $id_proprietaire);
    $sqlstmt->execute();



    $result = $sqlstmt->get_result();

    $affichage = array();
    if($conn) {
        while ($row = $result->fetch_assoc()) {
            $id_animal = $row['id_Animal'];
            
            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully",
                "id" => $row['id_Animal'],
                "nom" => $row['nom_animal']
            );
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}
else{
    $affichage = array("status" => "failed", "message" => "All fields are required ");
}
echo json_encode($affichage, JSON_PRETTY_PRINT);
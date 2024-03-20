<?php
require_once 'database.php';
$conn = connectToDatabase();

$sqlstmt = $conn->prepare("SELECT libelle, id_espece FROM Espece");
$sqlstmt->execute();

$result = $sqlstmt->get_result();

$affichage = array();
if($conn) {
    while ($row = $result->fetch_assoc()) {
        $affichage[] = array("status" => "success", "message" => "Data Affichage successfully", "id_espece" => $row['id_espece'], "libelle" => $row['libelle']);
    }
} else {
    $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
}

echo json_encode($affichage, JSON_PRETTY_PRINT);
?>

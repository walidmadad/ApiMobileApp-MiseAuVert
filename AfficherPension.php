<?php
require_once 'database.php';
$conn = connectToDatabase();

$sqlstmt = $conn->prepare("SELECT nom_pension, id_pension FROM pension");
$sqlstmt->execute();

$result = $sqlstmt->get_result();

$affichage = array();
if($conn){
    while($row = $result->fetch_assoc()){
        $affichage[] = array("status"=>"succes","message"=>"Data Affichage successfuly","id_pension"=>$row['id_pension'], "nom_pension"=>$row['nom_pension']);

    }
}else{
    $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
}
echo json_encode($affichage, JSON_PRETTY_PRINT);
<?php
require_once 'database.php';
if(!empty($_POST['nom_animal']) && !empty($_POST['id_proprietaire'])){
    $nom_animal = $_POST['nom_animal'];
    $id_proprietaire = $_POST['id_proprietaire'];

    $conn = connectToDatabase();

    $sqlstmtIdAnimal = $conn->prepare("SELECT id_Animal FROM animal WHERE nom_animal = ? AND id_proprietaire = ?");
    $sqlstmtIdAnimal->bind_param("si", $nom_animal, $id_proprietaire);
    $sqlstmtIdAnimal->execute();
    $result = $sqlstmtIdAnimal->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $id_animal = $row['id_Animal'];

        $sqlstmtAffectation = $conn->prepare("DELETE FROM affectation WHERE animal_id = ?");
        $sqlstmtAffectation->bind_param("i", $id_animal);
        if($sqlstmtAffectation->execute()) {
            $sqlstmt = $conn->prepare("DELETE FROM animal WHERE id_Animal = ?");

            $sqlstmt->bind_param("i", $id_animal);

            if($sqlstmt->execute()) {
                echo "L'animal et ses affectations ont été supprimés avec succès.";
            } else {
                echo "Erreur lors de la suppression de l'animal.";
            }
        } else {
            echo "Erreur lors de la suppression de l'affectation.";
        }
    } else {
        echo "Aucun animal trouvé avec ces informations.";
    }
} else {
    echo "Les données nécessaires sont manquantes.";
}
?>

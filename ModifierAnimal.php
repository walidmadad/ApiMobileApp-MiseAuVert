<?php

require_once 'database.php';

if (!empty($_POST['id_animal']) && !empty($_POST['nom_animal']) && !empty($_POST['poids']) && !empty($_POST['age']) && !empty($_POST['espece']) && !empty($_POST['regle']) && !empty($_POST['carnet']) && !empty($_POST['vaccin']) && !empty($_POST['vermifuge']) && !empty($_POST['dateFin']) && !empty($_POST['pension']) && !empty($_POST['typeGardiennage'])) {

    // Récupérez les données du formulaire
    $id_animal = $_POST['id_animal'];
    $nom_animal = $_POST['nom_animal'];
    $espece = $_POST['espece'];
    $age = $_POST['age'];
    $poids = $_POST['poids'];
    $regle = $_POST['regle'];
    $carnet = $_POST['carnet'];
    $vaccin = $_POST['vaccin'];
    $vermifuge = $_POST['vermifuge'];
    $dateFin = $_POST['dateFin'];
    $id_type_gardiennage = "";
    $pension = $_POST['pension'];
    $typeGardiennage = $_POST['typeGardiennage'];
    $id_pension = "";
    $id_box = "";
    $id_espece ="";

    // Connectez-vous à la base de données
    $conn = connectToDatabase();

    if ($conn) {
        // Récupérez l'identifiant de la pension et du type de gardiennage à partir des noms fournis
        // Cela suppose que les tables contenant ces informations ont des champs nommés "nom_pension" et "libelle" respectivement
        $sql1 = "SELECT id_pension FROM pension WHERE nom_pension = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $pension);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $id_pension);
        mysqli_stmt_fetch($stmt1);
        mysqli_stmt_close($stmt1);

        $sql2 = "SELECT id_TypeGardiennage FROM TypeGardiennage WHERE libelle = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $typeGardiennage);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_bind_result($stmt2, $id_type_gardiennage);
        mysqli_stmt_fetch($stmt2);
        mysqli_stmt_close($stmt2);

        $sql3 = "SELECT id_espece FROM espece WHERE libelle = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $espece);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_bind_result($stmt3, $id_espece);
        mysqli_stmt_fetch($stmt3);
        mysqli_stmt_close($stmt3);

        $sqlstmt1 = $conn->prepare("UPDATE animal SET nom_animal=?, id_espece=? WHERE id_animal=?");
        $sqlstmt1->bind_param("ssi", $nom_animal, $id_espece, $id_animal);
        if ($sqlstmt1->execute()) {
            $sqlstmt3 = $conn->prepare("UPDATE affectation SET Poids=?, Age=?, Regle=?, Carnet_Vaccination=?, Vaccin_a_jour=?, Vermifuge_a_jour=?, Date_fin=? WHERE animal_id=?");
            $sqlstmt3->bind_param("sssssssi", $poids, $age, $regle, $carnet, $vaccin, $vermifuge, $dateFin, $id_animal);
            if ($sqlstmt3->execute()) {
                echo "Animal mis à jour avec succès";
            } else {
                echo "Échec de la mise à jour des informations d'affectation de l'animal : " . $sqlstmt3->error;
            }
        } else {
            echo "Échec de la mise à jour des informations de l'animal : " . $sqlstmt1->error;
        }
    } else {
        echo "Échec de la connexion à la base de données";
    }
} else {
    echo "Tous les champs sont obligatoires";
}
?>

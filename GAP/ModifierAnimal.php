<?php
require_once 'database.php';

if (
    isset($_POST['id_animal'], $_POST['id_proprietaire'], $_POST['nom_animal'], $_POST['poids'], $_POST['age'], $_POST['espece'], $_POST['regle'], $_POST['carnet'], $_POST['vaccin'], $_POST['vermifuge'], $_POST['dateFin'], $_POST['pension'], $_POST['typeGardiennage'])
) {
    $id_animal = $_POST['id_animal'];
    $id_proprietaire = $_POST['id_proprietaire'];
    $nom_animal = $_POST['nom_animal'];
    $espece = $_POST['espece'];
    $age = $_POST['age'];
    $poids = $_POST['poids'];
    $regle = $_POST['regle'];
    $carnet = $_POST['carnet'];
    $vaccin = $_POST['vaccin'];
    $vermifuge = $_POST['vermifuge'];
    $dateFin = $_POST['dateFin'];
    $pension = $_POST['pension'];
    $typeGardiennage= $_POST['typeGardiennage'];
    $id_pension = "";
    $id_box = "";
    $id_espece ="";

    $conn = connectToDatabase();

    if ($conn) {

        $sql1 = "SELECT id_pension FROM pension WHERE nom_pension = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $pension);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $id_pension);
        mysqli_stmt_fetch($stmt1);
        mysqli_stmt_close($stmt1);

        $sql2 = "SELECT id_TypeGardiennage FROM typegardiennage WHERE Libelle = ?";
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

        $sql = "SELECT * FROM box WHERE id_TypeGardiennage = $id_type_gardiennage AND id_pension = $id_pension";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            echo "Erreur de préparation de la requête : " . mysqli_error($conn);
            exit();
        }
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_assoc($result);
                $id_box = $row['id_box'];
            } else {
                echo -1;
                exit();
            }
        } else {
            echo "Error: " . $stmt->error;
            exit();
        }

        $sqlstmt1 = $conn->prepare("UPDATE animal SET nom_animal=?, id_espece=?, id_proprietaire=? WHERE id_animal=?");
        $sqlstmt1->bind_param("sssi", $nom_animal, $id_espece, $id_proprietaire, $id_animal);
        if ($sqlstmt1->execute()) {
            $sqlstmt2 = $conn->prepare("UPDATE affectation SET Poids=?, Age=?, Regle=?, Carnet_Vaccination=?, Vaccin_a_jour=?, Vermifuge_a_jour=?, Date_fin=?, box_id=? WHERE animal_id=?");
            $sqlstmt2->bind_param("ssssssssi", $poids, $age, $regle, $carnet, $vaccin, $vermifuge, $dateFin, $id_box, $id_animal);
            if ($sqlstmt2->execute()) {
                echo "Animal mis à jour avec succès";
            } else {
                echo "Échec de la mise à jour des informations de l'animal : " . $sqlstmt2->error;
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

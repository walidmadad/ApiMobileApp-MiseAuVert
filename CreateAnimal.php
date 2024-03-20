<?php
require_once 'database.php';
if (!empty($_POST['id_proprietaire']) && !empty($_POST['nom_animal']) && !empty($_POST['poids']) && !empty($_POST['age']) && !empty($_POST['espece']) && !empty($_POST['regle']) && !empty($_POST['carnet']) && !empty($_POST['vaccin']) && !empty($_POST['vermifuge']) && !empty($_POST['dateFin']) && !empty($_POST['pension']) && !empty($_POST['typeGardiennage'])) {
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
    $typeGardiennage= $_POST['typeGardiennage'];
    $id_pension = "";
    $id_box = "";
    $id_proprietaire =$_POST['id_proprietaire'];
    $id_animal = "";
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

        $sqlstmt1 = $conn->prepare("INSERT INTO animal(nom_animal, id_espece, id_proprietaire) VALUES(?,?,?)");
        $sqlstmt1->bind_param("sss",$nom_animal,$id_espece, $id_proprietaire);
        if ($sqlstmt1->execute()) {
            $sqlstmt2 = $conn->prepare("SELECT id_Animal FROM animal WHERE nom_animal=?");
            $sqlstmt2->bind_param("s",$nom_animal);
            $sqlstmt2->execute();
            $result = $sqlstmt2->get_result();
            if($result->num_rows >0){
                $row = $result->fetch_assoc();
                $id_animal = $row['id_Animal'];
            }
            else{
                echo -1;
            }
            $sqlstmt3 = $conn->prepare("INSERT INTO affectation(animal_id,Poids,Age,Regle,Carnet_Vaccination,Vaccin_a_jour,Vermifuge_a_jour,Date_fin,box_id) VALUES(?,?,?,?,?,?,?,?,?)");
            $sqlstmt3->bind_param("sssssssss",$id_animal,$poids,$age,$regle,$carnet,$vaccin,$vermifuge,$dateFin,$id_box);

            if ($sqlstmt3->execute()) {
                echo "Animal Ajouter";
            } else {
                echo "Failed to insert into affectation table: " . $sqlstmt3->error;
            }
        } else {
            echo "Failed to insert into animal table: " . $sqlstmt1->error;
        }
    } else {
        echo "Database connection failed";
    }
} else {
    echo "All fields are required";
}
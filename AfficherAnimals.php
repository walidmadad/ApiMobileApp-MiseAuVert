<?php
require_once 'animal.php';
require_once 'database.php';
if(!empty($_POST['id_proprietaire'])){
    $id_proprietaire = $_POST['id_proprietaire'];


    $conn = connectToDatabase();

    $sqlstmt = $conn->prepare("SELECT id_Animal, nom_animal FROM animal WHERE id_proprietaire = ?");
    $sqlstmt->bind_param("i", $id_proprietaire);
    $sqlstmt->execute();



    $result = $sqlstmt->get_result();

    $affichage = array();
    if($conn) {
        while ($row = $result->fetch_assoc()) {
            $id_animal = $row['id_Animal'];
            $animal = new animal();
            $id_box = $animal->getIdBox($id_animal);
            $id_pension = $animal->getIdPension($id_box);
            $id_typeGardiennage = $animal->getIdTypeGardiennage($id_box);
            $id_espece = $animal->getIdEspece($id_animal);

            $pension = $animal->getPension($id_pension);
            $typeGardiennage = $animal->getTypeGardiennage($id_typeGardiennage);
            $nomAnimal = $animal->getNomAnimal($id_animal);
            $espece = $animal->getEspece($id_espece);
            $poids = $animal->getPoids($id_animal);
            $age = $animal->getAge($id_animal);
            $carnet = $animal->getCarnet($id_animal);
            $vaccin = $animal->getVaccin($id_animal);
            $vermifuge = $animal->getVermifuge($id_animal);
            $regle= $animal->getRegle($id_animal);
            $dateFin = $animal->getDateFin($id_animal);

            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully", "id_Animal" => $row['id_Animal'],
                "nom_animal" => $row['nom_animal'],
                "pension" => $pension,
                "typeGardiennage" => $typeGardiennage,
                "poids" => $poids,
                "age" => $age,
                "carnet" => $carnet,
                "vaccin" => $vaccin,
                "vermifuge" => $vermifuge,
                "regle" => $dateFin,
                "espece" => $espece);
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}
echo json_encode($affichage, JSON_PRETTY_PRINT);
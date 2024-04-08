<?php
require_once 'database.php';
require_once 'animal.php';
if(!empty($_POST['id_proprietaire']) && !empty($_POST['nom_animal'])){
    $id_proprietaire = $_POST['id_proprietaire'];
    $nom_animal = $_POST['nom_animal'];



    $animal = new animal();

    $id_animal = $animal->getIdAnimal($id_proprietaire, $nom_animal);
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

    $result = array();
    $result = array(
        "status" => "success",
        "pension" => $pension,
        "typegardiennage" => $typeGardiennage,
        "nom" => $nomAnimal,
        "poids" => $poids,
        "age" => $age,
        "carnet" => $carnet,
        "vaccin" => $vaccin,
        "vermifuge" => $vermifuge,
        "regle" => $regle,
        "dateFin" => $dateFin,
        "espece" => $espece,
        "id_animal" => $id_animal
    );
}
else {
    $result = array("status" => "failed", "message" => "All fields are required");
}
echo json_encode($result, JSON_PRETTY_PRINT);
?>
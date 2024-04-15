<?php
require_once 'database.php';
class animal
{
    function getIdAnimal($id, $nom){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT id_Animal FROM animal WHERE id_proprietaire = ? AND nom_animal = ?");
        $sqlstmt->bind_param("is", $id, $nom);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id_Animal'];
    }
    function getIdBox($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT box_id FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['box_id'];
    }
    function getIdPension($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT id_pension FROM box WHERE id_box = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id_pension'];
    }
    function getIdTypeGardiennage($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT id_TypeGardiennage FROM box WHERE id_box = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id_TypeGardiennage'];
    }
    function getIdEspece($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT id_espece FROM animal WHERE id_Animal = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id_espece'];
    }

    function getPension($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT nom_pension FROM pension WHERE id_pension = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['nom_pension'];
    }
    function getTypeGardiennage($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Libelle FROM typegardiennage WHERE id_TypeGardiennage = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Libelle'];
    }
    function getNomAnimal($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT nom_animal FROM animal WHERE id_Animal = ?");
        $sqlstmt->bind_param("i", $id,);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['nom_animal'];
    }

    function getPoids($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Poids FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Poids'];
    }
    function getAge($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Age FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Age'];
    }
    function getCarnet($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Carnet_Vaccination FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Carnet_Vaccination'];
    }
    function getVaccin($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Vaccin_a_jour FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Vaccin_a_jour'];
    }
    function getVermifuge($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Vermifuge_a_jour FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Vermifuge_a_jour'];
    }
    function getRegle($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Regle FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Regle'];
    }
    function getDateFin($id){
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT Date_fin FROM affectation WHERE animal_id = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Date_fin'];
    }

    function getEspece($id)
    {
        $conn = connectToDatabase();
        $sqlstmt = $conn->prepare("SELECT libelle FROM espece WHERE id_espece = ?");
        $sqlstmt->bind_param("i", $id);
        $sqlstmt->execute();
        $result = $sqlstmt->get_result();
        $row = $result->fetch_assoc();
        return $row['libelle'];
    }

}
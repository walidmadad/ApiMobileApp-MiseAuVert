<?php
require_once 'database.php';
if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['CP']) && !empty($_POST['ville']) && !empty($_POST['tel']) && !empty($_POST['dateNaissance']) && !empty($_POST['email']) && !empty($_POST['password'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'] . ", " . $_POST['CP'] . " " . $_POST['ville'];
    $tel = $_POST['tel'];
    $dateNaissance = $_POST['dateNaissance'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn = connectToDatabase();

    if($conn){
        $sql ="INSERT INTO proprietaire(nom_Propietaire, prenom_Propietaire, Adresse_Propietaire, TELEPHONE_Propietaire, email_Proprietaire, password_proprietaire, date_naissance_proprietaire) VALUES('".$nom."','".$prenom."','".$adresse."','".$tel."', '".$email."','".$password."','".$dateNaissance."')";
        if(mysqli_query($conn, $sql)){
            echo "succes";
        }
    }else{
        echo "database connection failed";
    }
}else{
    echo "all fields are required";
}


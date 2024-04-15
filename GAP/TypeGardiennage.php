<?php
require_once 'database.php';
if(!empty($_POST['nom_animal']) && !empty($_POST['id_proprietaire'])) {
    $nom_animal = $_POST['nom_animal'];
    $id_proprietaire = $_POST['id_proprietaire'];
    $conn = connectToDatabase();


}
<?php
function connectToDatabase() {
    $conn = mysqli_connect("localhost", "prof1234", "prof_1234!", "la_mise_au_vert");
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    return $conn;
}

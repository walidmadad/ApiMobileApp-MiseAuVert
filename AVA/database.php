<?php
function connectToDatabase() {
    $conn = mysqli_connect("localhost", "root", "", "la_mise_au_vert");
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    return $conn;
}

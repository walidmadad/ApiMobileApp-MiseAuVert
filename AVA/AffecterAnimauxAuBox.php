<?php
require_once 'database.php';

$affichage = array(); // Initialisation de $affichage en dehors de la condition

if (!empty($_POST['id_pension']) && !empty($_POST['id_typeGardiennage']) && !empty($_POST['dateFin']) && !empty($_POST['id_animal'])) {
    $id_pension = $_POST['id_pension'];
    $id_typeGardiennage = $_POST['id_typeGardiennage'];
    $id_animal = $_POST['id_animal'];
    $dateFin = $_POST['dateFin'];

    $conn = connectToDatabase();
    if ($conn) {
        $sqlstmt = $conn->prepare("SELECT id_box FROM box WHERE id_TypeGardiennage = ? AND id_pension = ? ");
        $sqlstmt->bind_param("ii", $id_typeGardiennage, $id_pension);
        $sqlstmt->execute();

        $result = $sqlstmt->get_result();

        if ($result->num_rows > 0) { // Vérifier s'il y a des résultats
            while ($row = $result->fetch_assoc()) {
                $dateNow = date('Y-m-d');

                $sqlstmt4 = $conn->prepare("INSERT INTO date(Date) VALUES (?) ON DUPLICATE KEY UPDATE Date = Date");
                $sqlstmt4->bind_param("s", $dateNow);
                $sqlstmt4->execute();

                $id_box = $row['id_box'];
                $sqlstmt2 = $conn->prepare("INSERT INTO affectation(box_id, animal_id, Date_fin, Date_debut) VALUES(?,?,?,?) ");
                $sqlstmt2->bind_param("iiss", $id_box, $id_animal, $dateFin, $dateNow);
                if ($sqlstmt2->execute()) {
                    $affichage = array("status" => "success", "message" => "Animal affecté à un box avec succès");
                } else {
                    $affichage = array("status" => "failed", "message" => "Erreur lors de l'affectation de l'animal au box");
                }
            }
        } else {
            $affichage = array("status" => "failed", "message" => "Aucun box trouvé pour les critères donnés");
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Connexion à la base de données échouée");
    }
} else {
    $affichage = array("status" => "failed", "message" => "Tous les champs sont requis");
}

echo json_encode($affichage, JSON_PRETTY_PRINT);
?>

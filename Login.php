<?php
require_once 'database.php';
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = array();
    $conn = connectToDatabase();

    if ($conn) {
        $sql = "SELECT * FROM proprietaire WHERE email_Proprietaire = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($res) != 0) {
                $row = mysqli_fetch_assoc($res);

                if (password_verify($password, $row["password_proprietaire"])) {
                    $result = array(
                        "status" => "success",
                        "message" => "Login successful",
                        "nom" => $row["nom_Propietaire"],
                        "prenom" => $row["prenom_Propietaire"],
                        "id" => $row["id_proprietaire"]
                    );
                } else {
                    $result = array("status" => "failed", "message" => "Email or password incorrect");
                }
            } else {
                $result = array("status" => "failed", "message" => "Email or password incorrect");
            }
        } else {

            $result = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
        }
    } else {

        $result = array("status" => "failed", "message" => "Database connection failed: " . mysqli_connect_error());
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}
echo json_encode($result, JSON_PRETTY_PRINT);
?>

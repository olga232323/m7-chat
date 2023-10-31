<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Conexión a la base de datos
    include_once("conexion.php");

    // Resto del código para validar el inicio de sesión...
    $stmt = $conn->prepare("SELECT ID, Contraseña, NombreCompleto FROM Usuarios WHERE CorreoElectronico = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $hashedPassword, $nombreCompleto);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashedPassword)) {
            // Inicio de sesión exitoso
            $_SESSION["user_id"] = $userID;
            echo "Inicio de sesión exitoso. Bienvenido, $nombreCompleto.";
        } else {
            echo "Inicio de sesión fallido. Verifique sus credenciales.";
        }
    } else {
        echo "Inicio de sesión fallido. Verifique sus credenciales.";
    }

    $stmt->close();
    $conn->close();
}
?>
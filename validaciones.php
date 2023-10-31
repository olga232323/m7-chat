<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $password = $_POST["password"];

    // Conexión a la base de datos
    include_once("conexion.php");

    // Resto del código para validar el inicio de sesión...
    $stmt = $conn->prepare("SELECT user_id, contraseña FROM Usuarios WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $hashedPassword);
        $stmt->fetch();

        // Verificar la contraseña con Bcrypt
        if (password_verify($password, $hashedPassword)) {
            // Inicio de sesión exitoso
            $_SESSION["user_id"] = $userID;
            header("Location: chat.html"); // Redirección si el inicio de sesión es exitoso
            exit;
        }
    }

    // Si llegamos a este punto, se ejecuta solo en caso de inicio de sesión fallido.
    header("Location: index.php?error=Inicio de sesión fallido. Verifique sus credenciales.");
    exit;

    $stmt->close();
    $conn->close();
}
?>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $nombreCompleto = $_POST["nombreCompleto"];
    $password = $_POST["password"];

    // Validación de datos (puedes agregar más validaciones según tus necesidades)
    if (empty($user) || empty($nombreCompleto) || empty($password)) {
        header("Location: indexRegister.php?error=Por favor, complete todos los campos.");
        exit;
    }

    // Conexión a la base de datos
    include_once("conexion.php");

    // Verificar si el nombre de usuario ya está en uso
    $stmt = $conn->prepare("SELECT user_id FROM Usuarios WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: indexRegister.php?usrex=El nombre de usuario ya está en uso.");
        exit;
    }

    // Hashear la contraseña antes de almacenarla en la base de datos con BCRYPT
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO Usuarios (username, nombre_real, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $nombreCompleto, $hashedPassword);

    if ($stmt->execute()) {
        // Registro exitoso, redirige al usuario a la página de inicio de sesión
        header("Location: indexRegister.php?message=Registro exitoso. Ahora puedes iniciar sesión.");
        exit;
    } else {
        header("Location: indexRegister.php?error=Error al registrar el usuario. Por favor, inténtalo de nuevo.");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>

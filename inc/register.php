<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $nombreCompleto = $_POST["nombreCompleto"];
    $password = $_POST["password"];

    // Validación de datos (puedes agregar más validaciones según tus necesidades)
    if (empty($user)) {
        header("Location: ../indexRegister.php?emptyUsr");
        exit;
    } else if(empty($nombreCompleto)){
        header("Location: ../indexRegister.php?emptyNom");
        exit;
    }else if(empty($password)){
        header("Location: ../indexRegister.php?emptyPwd");
        exit;
    }

    // Conexión a la base de datos
    require_once("conexion.php");

    // Verificar si el nombre de usuario ya está en uso
    $query = "SELECT user_id FROM Usuarios WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: ../indexRegister.php?usrex");
        exit;
    }

    // Hashear la contraseña antes de almacenarla en la base de datos con BCRYPT
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO Usuarios (username, nombre_real, contraseña) VALUES (?, ?, ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $user, $nombreCompleto, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        // Registro exitoso, redirige al usuario a la página de inicio de sesión
        header("Location: ../indexRegister.php?message");
        exit;
    } else {
        header("Location: ../indexRegister.php?error");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<?php

if (!filter_has_var(INPUT_POST, 'inicio')) {
    header('Location: ../index.php');
    exit();
} else {
    $user = $_POST["user"];
    $password = $_POST["password"];

    // Conexión a la base de datos
    include_once("./conexion.php");

    // Resto del código para validar el inicio de sesión...
    $query = "SELECT user_id, contraseña FROM Usuarios WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $userID, $hashedPassword);
        mysqli_stmt_fetch($stmt);

        // Verificar la contraseña con Bcrypt
        // if (password_verify($password, $hashedPassword)) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION["user_id"] = $userID;
            $_SESSION["username"] = $user;
            $_SESSION['loginOk'] = isset($_POST['loginOk']) ? $_POST['loginOk'] : "";
            // $_SESSION["loginOk"];
            header("Location: ../chat_index.php"); // Redirección si el inicio de sesión es exitoso
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit();
        // }
    }

    // Si llegamos a este punto, se ejecuta solo en caso de inicio de sesión fallido.
    if (empty($user)) {
        header("Location: ../index.php?emptyUsr");

        exit;
    } else if (empty($password)){
        header("Location: ../index.php?emptyPwd");
        exit;
    }
    header("Location: ../index.php?error");
    exit();

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
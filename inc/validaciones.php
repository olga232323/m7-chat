<?php
if (!filter_has_var(INPUT_POST, 'inicio')) {
    header('Location: ../index.php');
    exit();
} else {
    // Conexión a la base de datos
    include_once("./conexion.php");
    // Sanear post
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validaciones de usuario o pwd empty
    if (empty($user)) {
        header("Location: ../index.php?emptyUsr");
        exit();
    } else if (empty($password)) {
        header("Location: ../index.php?emptyPwd");
        exit();
    } else {
        try {
            // Resto del código para validar el inicio de sesión...
            $query = "SELECT user_id, contraseña FROM Usuarios WHERE username = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            $resultadoConsulta = mysqli_stmt_get_result($stmt);

            // mysqli_stmt_bind_result($stmt, $userID, $hashedPassword);

            // $resultadoConsulta = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            // mysqli_close($conn);
            while ($fila = mysqli_fetch_assoc($resultadoConsulta)) {
                $userid = $fila['user_id'];
                $hashedPassword = $fila['contraseña'];
            }
            if (password_verify($password, $hashedPassword)) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['username'] = $user;
                $_SESSION["user_id"] = $userid;
                $_SESSION['loginOk'] = isset($_POST['loginOk']) ? $_POST['loginOk'] : "";
                header("Location: ../chat_index.php"); // Redirección si el inicio de sesión es exitoso
                exit();
            }else{
                header("Location: ../index.php?error");
            }

        } catch (Exception $e) {
            echo "Error in the database connection" . $e->getMessage();
            mysqli_close($conn);
            die();
        }

    }
}
?>
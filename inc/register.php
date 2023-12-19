<?php
if (!filter_has_var(INPUT_POST, 'regOk')) {
    header('Location: ../indexRegister.php');
    exit();
} else {
    try {
        // Conexión a la base de datos
        require_once("conexion.php");
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $nombreCompleto = mysqli_real_escape_string($conn, $_POST['nombreCompleto']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Primero, desactivamos la autoejecución de consultas
        mysqli_autocommit($conn, false);

        // Iniciamos transacción
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE); // cuando tenemos que hacer modificaciones de leer y de borrar sino, MYSQLI_TRANS_START_READ_ONLY

        // Validación de datos (puedes agregar más validaciones según tus necesidades)
        if (empty($user)) {
            header("Location: ../indexRegister.php?emptyUsr");
            mysqli_close($conn);
            exit();
        } else if (empty($nombreCompleto)) {
            header("Location: ../indexRegister.php?emptyNom");
            mysqli_close($conn);
            exit();
        } else if (empty($password)) {
            header("Location: ../indexRegister.php?emptyPwd");
            mysqli_close($conn);
            exit();
        }

        /* PRIMERA CONSULTA */
        // Verificar si el nombre de usuario ya está en uso
        $query = "SELECT user_id FROM Usuarios WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);

        $resultadoPrimeraConsulta = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($resultadoPrimeraConsulta) != 0) {
            header("Location: ../indexRegister.php?usrex");
            mysqli_close($conn);
        }

        // Hashear la contraseña antes de almacenarla en la base de datos con BCRYPT
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        /* SEGUNDA CONSULTA */
        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO Usuarios (username, nombre_real, contraseña) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $user, $nombreCompleto, $hashedPassword);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_commit($conn); // confirmamos las dos consultas
        mysqli_close($conn);

        // Registro exitoso, redirige al usuario a la página de inicio de sesión
        header("Location: ../indexRegister.php?message");


    } catch (Exception $e) {
        mysqli_rollback($conn); // Deshacemos las inserciones en el caso de que se genere alguna excepción
        echo "Error in the database connection" . $e->getMessage();
        header("Location: ../indexRegister.php?error");
        mysqli_close($conn);
        die();
    }
}
?>
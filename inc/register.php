<?php
if (!filter_has_var(INPUT_POST, 'regOk')) {
    header('Location: ../indexRegister.php');
    exit();
} else {
    try {
        // Conexión a la base de datos
        require_once("conexion.php");
        $user = $_POST['user'];
        $nombreCompleto = $_POST['nombreCompleto'];
        $password = $_POST['password'];

        // Iniciamos transacción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        // Validación de datos (puedes agregar más validaciones según tus necesidades)
        if (empty($user)) {
            header("Location: ../indexRegister.php?emptyUsr");
            $conn = null;
            exit();
        } else if (empty($nombreCompleto)) {
            header("Location: ../indexRegister.php?emptyNom");
            $conn = null;
            exit();
        } else if (empty($password)) {
            header("Location: ../indexRegister.php?emptyPwd");
            $conn = null;
            exit();
        }

        /* PRIMERA CONSULTA */
        // Verificar si el nombre de usuario ya está en uso
        $query = "SELECT user_id FROM Usuarios WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $user);
        $stmt->execute();

        $resultadoPrimeraConsulta = $stmt->fetchAll();
        $stmt->closeCursor();

        if (!empty($resultadoPrimeraConsulta)) {
            header("Location: ../indexRegister.php?usrex");
            $conn = null;
            exit();
        }

        // Hashear la contraseña antes de almacenarla en la base de datos con BCRYPT
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        /* SEGUNDA CONSULTA */
        // Insertar el nuevo usuario en la base de datos
        $query2 = "INSERT INTO Usuarios (username, nombre_real, contraseña) VALUES (:username, :nombre_real, :contrasena)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bindParam(':username', $user);
        $stmt2->bindParam(':nombre_real', $nombreCompleto);
        $stmt2->bindParam(':contrasena', $hashedPassword);
        $stmt2->execute();

        $stmt2->closeCursor();
        $conn->commit(); // confirmamos las dos consultas
        $conn = null;

        // Registro exitoso, redirige al usuario a la página de inicio de sesión
        header("Location: ../indexRegister.php?message");
        exit();

    } catch (PDOException $e) {
        $conn->rollBack(); // Deshacemos las inserciones en el caso de que se genere alguna excepción
        echo "Error in the database connection" . $e->getMessage();
        // header("Location: ../indexRegister.php?error");
        $conn = null;
        die();
    }
}
?>
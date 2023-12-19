<?php
if (!filter_has_var(INPUT_POST, 'inicio')) {
    header('Location: ../index.php');
    exit();
} else {
    // Conexión a la base de datos
    $user = $_POST['user'];
    $password = $_POST['password'];
   
    include_once("./conexion.php");
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
            $user = $_POST['user'];
            $password = $_POST['password'];
            $query = "SELECT user_id, contraseña FROM Usuarios WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $user);
            $stmt->execute();
            $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todas las filas como un array asociativo
            $stmt->closeCursor();
            foreach ($resultadoConsulta as $fila) {
                $userid = $fila['user_id'];
                $hashedPassword = $fila['contraseña']; // Verifica si 'contraseña' es el nombre correcto del campo
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
                // Error en el inicio de sesión
                header("Location: ../index.php?error");
            }

        } catch (PDOException $e) {
            echo "Error in the database connection" . $e->getMessage();
            $conn = null;
            die();
        }

    }
}
?>
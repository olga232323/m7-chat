<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['loginOk'])) {
    header('Location: ./inc/cerrar_sesion.php');
    exit();
}

// Verifica si se ha enviado un formulario (se hizo clic en el botón)
if (isset($_GET['agregarAmigo'])) {
    include("./conexion.php");

    // Obtén el ID del usuario actual desde la sesión
    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

    // Obtén el ID del usuario al que se quiere agregar como amigo (puedes obtenerlo de la forma que desees)
    $idAmigo = mysqli_real_escape_string($conn, $_GET['idAmigo']);

    try {
        $sqlAmistades = "INSERT INTO amistades (user_id_1, user_id_2, estado_solicitud) VALUES (?, ?, 'pendiente')";
        $stmtTablaAmistades = mysqli_stmt_init($conn);
        
        if (mysqli_stmt_prepare($stmtTablaAmistades, $sqlAmistades)) {
            mysqli_stmt_bind_param($stmtTablaAmistades, "ii", $user_id, $idAmigo);
            mysqli_stmt_execute($stmtTablaAmistades);
            mysqli_stmt_close($stmtTablaAmistades);
            
            // Cierra la conexión a la base de datos
            mysqli_close($conn);
            header('Location: ../chat_index.php');
            exit();
        } else {
            echo "Error in the database connection";
        }
    } catch (Exception $e) {
        echo "Error in the database connection" . $e->getMessage();
        mysqli_close($conn);
        die();
    }
}

// Inserta la solicitud de amistad en la tabla 'amistades' con el estado 'pendiente'
?>

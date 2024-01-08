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
    $user_id = $_SESSION['user_id'];

    // Obtén el ID del usuario al que se quiere agregar como amigo (puedes obtenerlo de la forma que desees)
    $idAmigo =$_GET['idAmigo'];

    try {
        $sqlAmistades = "INSERT INTO Amistades (user_id_1, user_id_2, estado_solicitud)
VALUES (:user_id, :idAmigo, 'pendiente'), (:idAmigo, :user_id, 'pendiente')";
        $stmtTablaAmistades = $conn->prepare($sqlAmistades);
        $stmtTablaAmistades->bindParam(':user_id', $user_id);
        $stmtTablaAmistades->bindParam(':idAmigo', $idAmigo);
        $stmtTablaAmistades->bindParam(':idAmigo', $idAmigo);
        $stmtTablaAmistades->bindParam(':user_id', $user_id);

        $stmtTablaAmistades->execute();
        $stmtTablaAmistades->closeCursor();
        $conn=null;


            header('Location: ../chat_index.php');
            echo "<script>alert('Solicitud enviada correctamente.')</script>";

            exit();
        } 
     catch (PDOException $e) {
        echo "Error in the database connection" . $e->getMessage();
        $conn=null;
        die();
    }
}

// Inserta la solicitud de amistad en la tabla 'amistades' con el estado 'pendiente'
?>

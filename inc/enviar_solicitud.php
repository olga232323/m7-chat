<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['loginOk'])) {
    header('Location: ./cerrar_sesion.php');
    exit();
}

// Verifica si se ha enviado un formulario (se hizo clic en el botón)
if (isset($_POST['agregarAmigo'])) {
    include("./conexion.php");

    $user_id = $_SESSION['user_id'];
    $idAmigo = $_POST['idAmigo'];

    try {
        $sqlAmistades = "INSERT INTO Amistades (user_id_1, user_id_2, estado_solicitud, enviadoPor)
        VALUES (:user_id, :idAmigo, 'pendiente', :user_id), (:idAmigo, :user_id, 'pendiente', :user_id)";
                $stmtTablaAmistades = $conn->prepare($sqlAmistades);
                $stmtTablaAmistades->bindParam(':user_id', $user_id);
                $stmtTablaAmistades->bindParam(':idAmigo', $idAmigo);
                $stmtTablaAmistades->bindParam(':idAmigo', $idAmigo);
                $stmtTablaAmistades->bindParam(':user_id', $user_id);
        
                $stmtTablaAmistades->execute();
                $stmtTablaAmistades->closeCursor();
        $conn = null;
        echo "ok";

        exit();
    } catch (PDOException $e) {
        echo "Error in the database connection" . $e->getMessage();
        $conn = null;
        die();
    }
}
?>
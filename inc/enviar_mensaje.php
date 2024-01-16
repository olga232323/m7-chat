<?php
session_start();
// if (!isset($_SESSION['loginOk']) || !isset($_POST['enviarMensaje'])) {
//   header('Location: ' . './cerrar_sesion.php');
//   exit();
// } else {
  include("./conexion.php");
  // SANEAR POST
  $username = $_SESSION['username'];
  $userID = $_SESSION['user_id'];
  $idAmigo = $_POST['idAmigo'];
  $mensajeEscrito = $_POST['mensaje'];
  try {
    /* Insert para insertar en la base de datos el mensaje que enviamos */
    $sqlNuevoMensaje = "INSERT INTO Mensajes (sender_id, receiver_id, contenido, fecha_envio)
    VALUES (:sender_id, :receiver_id, :contenido, NOW());";
    $stmtTablaMensaje = $conn->prepare($sqlNuevoMensaje);
    $stmtTablaMensaje->bindParam(':sender_id', $userID);
    $stmtTablaMensaje->bindParam(':receiver_id', $idAmigo);
    $stmtTablaMensaje->bindParam(':contenido', $mensajeEscrito);
    $stmtTablaMensaje->execute();

    $stmtTablaMensaje->closeCursor();
    $conn = null;
    echo 'ok';

  } catch (PDOException $e) {
    echo "Error in the database connection" . $e->getMessage();
    $conn = null;
    die();
  }

// }
?>
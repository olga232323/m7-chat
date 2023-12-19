<?php
session_start();
if (!isset($_SESSION['loginOk']) || !isset($_POST['enviarMensaje'])) {
  header('Location: ' . './cerrar_sesion.php');
  exit();
} else {
  include("./conexion.php");
  // SANEAR POST
  $username = mysqli_real_escape_string($conn, $_SESSION['username']);
  $userID = mysqli_real_escape_string($conn, $_SESSION['user_id']);
  $idAmigo = mysqli_real_escape_string($conn, $_GET['idAmigo']);
  $mensajeEscrito = mysqli_real_escape_string($conn, $_POST['mensaje']);
  try {
    /* Insert para insertar en la base de datos el mensaje que enviamos */
    $sqlNuevoMensaje = "INSERT INTO Mensajes (sender_id, receiver_id, contenido, fecha_envio)
    VALUES (?, ?, ?, NOW());";
    $stmtTablaMensaje = mysqli_stmt_init($conn);
    $stmtTablaMensaje = mysqli_prepare($conn, $sqlNuevoMensaje);
    mysqli_stmt_bind_param($stmtTablaMensaje, "iis", $userID, $idAmigo, $mensajeEscrito);
    mysqli_stmt_execute($stmtTablaMensaje);

    mysqli_stmt_close($stmtTablaMensaje);
    mysqli_close($conn);
    header('Location: ' . '../chat_index.php?idAmigo='. $idAmigo . '');

  } catch (Exception $e) {
    echo "Error in the database connection" . $e->getMessage();
    mysqli_close($conn);
    die();
  }

}
?>
<?php
// if (!isset($_SESSION['loginOk'])) {
//   header('Location: ' . './cerrar_sesion.php');
//   exit();
// } else {
session_start();
try {
  include("./conexion.php");
  $username = $_SESSION['username'];
  $userID = $_SESSION['user_id'];
  $idAmigo = $_POST['idAmigo'];

  /* Consulta para obtener el listado de mensajes del usuario que ha ingresado con el usuario selecionado */
  $sqlMensajes = "SELECT m.*, u_sender.username as sender_username, u_receiver.username as receiver_username
FROM Mensajes m
JOIN Usuarios u_sender ON m.sender_id = u_sender.user_id
JOIN Usuarios u_receiver ON m.receiver_id = u_receiver.user_id
WHERE (m.sender_id = :sender_id AND m.receiver_id = :receiver_id) OR (m.sender_id = :receiver_id AND m.receiver_id = :sender_id)
ORDER BY m.fecha_envio DESC";

  $stmtTablaMensajes = $conn->prepare($sqlMensajes);
  $stmtTablaMensajes->bindParam(':sender_id', $userID);
  $stmtTablaMensajes->bindParam(':receiver_id', $idAmigo);
  $stmtTablaMensajes->bindParam(':sender_id', $idAmigo);
  $stmtTablaMensajes->bindParam(':receiver_id', $userID);

  $stmtTablaMensajes->execute();

  $resultadoConsulta3 = $stmtTablaMensajes->fetchAll(PDO::FETCH_ASSOC);

  $stmtTablaMensajes->closeCursor();

  $conn = null;

  if (empty($resultadoConsulta3)) {
    echo 'empty';
  } else {
    echo json_encode($resultadoConsulta3);
  }

} catch (PDOException $e) {
  echo "Error in the database connection" . $e->getMessage();
  $conn = null;
  die();
}
// }
?>
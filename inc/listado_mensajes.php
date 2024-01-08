<?php
if (!isset($_SESSION['loginOk'])) {
  header('Location: ' . './inc/cerrar_sesion.php');
  exit();
} else {
  try {
    include("./inc/conexion.php");
    $username = $_SESSION['username'];
    $userID = $_SESSION['user_id'];
    $idAmigo = $_GET['idAmigo'];

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
      echo "<div class='d-flex flex-row justify-content-center'>
        <div>
          <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>No tienes mensajes con esta persona.</p>
        </div>
      </div>";
    }

    foreach ($resultadoConsulta3 as $fila) {
      $mensaje = $fila['contenido'];
      $senderId = $fila['sender_id'];
      $fechaEnvio = $fila['fecha_envio'];
      $sender_username = $fila['sender_username'];

      if ($senderId == $userID) {
        echo "<div class='d-flex flex-row justify-content-end'>
            <div>
                <p class='small p-2 me-3 mb-1 text-white rounded-3 bg-primary'>" . $mensaje . "</p>
                <p class='small me-3 text-muted'>Enviado por: " . $sender_username . "</p>
                <p class='small me-3 mb-3 text-muted'>Fecha: " . $fechaEnvio . "</p>
            </div>
        </div>";
      } else if ($senderId == $idAmigo) {
        echo "<div class='d-flex flex-row justify-content-start'>
            <div>
                <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>" . $mensaje . "</p>
                <p class='small ms-3 text-muted'>Enviado por: " . $sender_username . "</p>
                <p class='small ms-3 mb-3 text-muted'>Fecha: " . $fechaEnvio . "</p>
            </div>
        </div>";
      }
    }

  } catch (PDOException $e) {
    echo "Error in the database connection" . $e->getMessage();
    $conn = null;
    die();
  }
}
?>
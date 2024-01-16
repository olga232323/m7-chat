<?php
session_start();
include("./conexion.php");
$user_id = $_SESSION['user_id'];
try {
  // Consulta para obtener las solicitudes de amistad pendientes
  $sql = "SELECT a.friendship_id, a.estado_solicitud, u.username AS username_user_id_2, u.user_id AS user_id_user_id_2 FROM amistades a INNER JOIN usuarios u ON a.user_id_2 = u.user_id WHERE a.user_id_1 = :user_id_1 AND a.estado_solicitud = 'pendiente' AND a.enviadoPor <> :user_id_1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id_1', $user_id);
  $stmt->execute();
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($resultado) == 0) {
    echo 'empty'; 
  } else {
    echo json_encode($resultado);
  }
} catch (PDOException $e) {
  echo json_encode( array( 'error' => $ex->getMessage() ) );
}
?>
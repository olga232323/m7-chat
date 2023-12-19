<?php
if (!isset($_SESSION['loginOk'])) {
  header('Location: ' . './inc/cerrar_sesion.php');
  exit();
} else {
  include("./inc/conexion.php");
  // SANEAR POST
  $username = $_SESSION['username'];
  $userID = $_SESSION['user_id'];
  try {
    /* Consulta para obtener el listado de amistades del usuario que ha ingresado */
    $sqlAmistades = "SELECT U.nombre_real, U.user_id FROM Usuarios U JOIN Amistades A ON U.user_id = A.user_id_2 WHERE A.user_id_1 = :userID AND A.estado_solicitud = 'aceptada'";

    $stmtTablaAmistades = $conn->prepare($sqlAmistades);
    $stmtTablaAmistades->bindParam(':userID', $userID);
    $stmtTablaAmistades->execute();

    $resultadoConsulta = $stmtTablaAmistades->fetchAll();
    $stmtTablaAmistades->closeCursor();

    $conn = null;

    if (count($resultadoConsulta) == 0) {
      echo "<li class='p-2'>
        <div class='d-flex flex-row'>
          <div class='pt-1'>
            <p class='fw-bold mb-0'>No tienes amigos agregados</p>
          </div>
        </div>
      </li>";
    } else {
      echo "<h5>Tus Amigos:</h5>";
      foreach ($resultadoConsulta as $fila) {
        $nombreAmistad = $fila['nombre_real'];
        $idAmistad = $fila['user_id'];
        echo "<li class='p-2'>
          <a href='./chat_index.php?idAmigo=" . $idAmistad . "' class='d-flex justify-content-between text-decoration-none text-dark'>
            <div class='d-flex flex-row'>
              <div class='pt-1'>
                <p class='fw-bold mb-0 text-center'>" . $nombreAmistad . "</p>
              </div>
            </div>
          </a>
        </li>
        ";
      }
    }

  } catch (PDOException $e) {
    $conn->rollBack(); // Deshacemos las inserciones en el caso de que se genere alguna excepción
    echo "Error in the database connection" . $e->getMessage();
    $conn = null;
    die();
  }
}
?>
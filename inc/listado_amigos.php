<?php
if (!isset($_SESSION['loginOk'])) {
  header('Location: ' . './inc/cerrar_sesion.php');
  exit();
} else {
  include("./inc/conexion.php");
  // SANEAR POST
  $username = mysqli_real_escape_string($conn, $_SESSION['username']);
  $userID = mysqli_real_escape_string($conn, $_SESSION['user_id']);
  try {
    /* Consulta para obtener el listado de amistades del usuario que ha ingresado */
    $sqlAmistades = "SELECT U.nombre_real, U.user_id FROM Usuarios U JOIN Amistades A ON U.user_id = A.user_id_2 WHERE A.user_id_1 = ? AND A.estado_solicitud = 'aceptada'";

    $stmtTablaAmistades = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmtTablaAmistades, $sqlAmistades);
    mysqli_stmt_bind_param($stmtTablaAmistades, "i", $userID);
    mysqli_stmt_execute($stmtTablaAmistades);

    $resultadoConsulta = mysqli_stmt_get_result($stmtTablaAmistades);

    mysqli_stmt_close($stmtTablaAmistades);
    mysqli_close($conn);

    if (mysqli_num_rows($resultadoConsulta) == 0) {
      echo "<li class='p-2'>
        <div class='d-flex flex-row'>
          <div class='pt-1'>
            <p class='fw-bold mb-0'>No tienes amigos agregados</p>
          </div>
        </div>
      </li>";
    }

    while ($fila = mysqli_fetch_assoc($resultadoConsulta)) {
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

  } catch (Exception $e) {
    mysqli_rollback($conn); // Deshacemos las inserciones en el caso de que se genere alguna excepción
    echo "Error in the database connection" . $e->getMessage();
    mysqli_close($conn);
    die();
  }
}
?>
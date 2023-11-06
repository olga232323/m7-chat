<?php
if (!filter_has_var(INPUT_POST, 'inicio')) { // No permite acceder a listado_mensajes.php sin haberse logueado
  header('Location: ' . './test/login.php');
  exit();
} else {
  include("./conexion.php");
  // SANEAR POST
  // $username = mysqli_real_escape_string($conn, $_GET['username']);
  // $usernameAmigo = mysqli_real_escape_string($conn, $_GET['nombreAmistad']);
  // $idAmigo = mysqli_real_escape_string($conn, $_GET['idAmistad']);
  $username = "usuario1";
  $usernameAmigo = "usuario2";
  if (isset($_GET['idAmigo']));
  // $idAmigo = $_GET['idAmigo'];
  // $idAmigo = 3;
  $useride = 1;
  try {
    // Desactivamos la autoejecución de las consultas
    // mysqli_autocommit($conn, false);
    // mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    // /* Primera consulta para obtener el user_id del usuario que ha ingresado */
    // $sqlObtenerUserId = "SELECT user_id FROM Usuarios WHERE username = ?";
    // // $stmtObtenerUserId = mysqli_stmt_init($conn);
    // $stmtObtenerUserId = mysqli_prepare($conn, $sqlObtenerUserId);
    // mysqli_stmt_bind_param($stmtObtenerUserId, "s", $username); // username sustituye el interrogante que hemos puesto en la plantilla
    // mysqli_stmt_execute($stmtObtenerUserId);

    // $resultadoPrimeraConsulta = mysqli_stmt_get_result($stmtObtenerUserId);
    // // Almacenamos el resultado de la consulta en un array asociativo
    // $userLogged = mysqli_fetch_assoc($resultadoPrimeraConsulta);

    /* Primera consulta para obtener el listado de mensajes del usuario que ha ingresado con el usuario selecionado */
    $sqlMensajes = "SELECT * FROM mensajes WHERE sender_id = ? AND receiver_id = ? OR sender_id = ? AND receiver_id = ?";

    $stmtTablaMensajes = mysqli_stmt_init($conn);
    $stmtTablaMensajes = mysqli_prepare($conn, $sqlMensajes);
    mysqli_stmt_bind_param($stmtTablaMensajes, "iiii", $useride, $idAmigo, $idAmigo, $useride);
    mysqli_stmt_execute($stmtTablaMensajes);

    $resultadoSegundaConsulta = mysqli_stmt_get_result($stmtTablaMensajes);

    mysqli_commit($conn); // Commit de las dos consultas

    // mysqli_stmt_close($stmtObtenerUserId);
    mysqli_stmt_close($stmtTablaMensajes);

    mysqli_close($conn);

    if (mysqli_num_rows($resultadoSegundaConsulta) == 0) {
      echo "<div class='d-flex flex-row justify-content-start'>
        <div>
          <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>No tienes mensajes con esta persona.</p>
        </div>
      </div>";
    }

    while ($fila = mysqli_fetch_assoc($resultadoSegundaConsulta)) {
      $mensaje = $fila['contenido'];
      $senderId = $fila['sender_id'];
      $receiverId = $fila['receiver_id'];
      $fechaEnvio = $fila['fecha_envio'];

      if($senderId === $useride){
        echo "<div class='d-flex flex-row justify-content-end'>
          <div>
            <p class='small p-2 me-3 mb-1 text-white rounded-3 bg-primary'>" . $mensaje . "</p>
            <p class='small me-3 mb-3 rounded-3 text-muted'>" . $fechaEnvio . "</p>
          </div>
        </div>";
      } else if($senderId === $idAmigo){
        echo "<div class='d-flex flex-row justify-content-start'>
          <div>
            <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>" . $mensaje . "</p>
            <p class='small ms-3 mb-3 rounded-3 text-muted float-end'>" . $fechaEnvio . "</p>
          </div>
        </div>";
      }
    }

  } catch (Exception $e) {
    mysqli_rollback($conn); // Deshacemos las inserciones en el caso de que se genere alguna excepción
    echo "Error in the database connection". $e->getMessage();
    mysqli_close($conn);
    die();
  }
}
?>
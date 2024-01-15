<?php
session_start();
if (!isset($_SESSION['loginOk'])) {
  header('Location: ' . './inc/cerrar_sesion.php');
  exit();
} else {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./src/LOGO/logopro-removebg-preview.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Whatsapp 2</title>
    <link rel="stylesheet" type="text/css" href="./css/chat_style.css">
  </head>

  <body>
    <section>
      <div class="container py-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="chat3" style="border-radius: 15px;">
              <div class="card-body">
                <div class="row">
                  <!-- Barra de búsqueda y amistades -->
                  <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                    <div class="p-3">
                      <!-- Barra de búsqueda --><!-- Barra de búsqueda -->
                      <!-- Formulario de búsqueda en la misma página -->
                      <?php
                      include("./inc/conexion.php");
                      // include("./inc/busqueda_usuarios.php");

                      $resultados = array();


                      ?>
                        <div class="input-group mb-3">
                          <input type="search" class="form-control rounded" name="busqueda_realizada" id="busqueda_realizada" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="search-addon" />

                          <div class="input-group-append">
                            <!-- <a class="btn btn-secondary" onclick="window.location.href='./solicitudes_amistad.php'">+</a> -->
                           
                            <?php if (isset($_POST['buscar'])) { ?>
                              
                          <?php
                          }
                          ?>
                        </div>
                         
                      </div>
                      <div id="resultadosBusqueda"> 
                     </div>
                    </div>
                  </div>
                  
                  <!-- Chat general -->
                  <div class="col-md-6 col-lg-7 col-xl-8">
                    <!-- Listado de mensajes -->
                    <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px; overflow: auto;">
                      <?php
                      // Recibimos el listado de mensajes de listado_mensajes.php
                      if (!isset($_GET['idAmigo'])) {
                      ?>
                        <div class='d-flex flex-row justify-content-center align-items-center '>
                          <div>
                            <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>Selecciona una
                              persona para chatear!</p>
                          </div>
                        </div>
                      <?php
                      } else {
                        include_once("./inc/listado_mensajes.php");
                      }
                      ?>
                    </div>
                    <!-- Barra enviar mensaje -->
                    <?php
                    if (isset($_GET['idAmigo'])) {
                      echo "<div class='text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2'>
                        <form method='POST' action='./inc/enviar_mensaje.php?idAmigo=" . $_GET['idAmigo'] . "' class='d-flex w-100'>
                          <input type='text' name='mensaje' class='form-control flex-grow-1' id='mensaje'
                            placeholder='Escriba un mensaje'>
                          <input type='submit' name='enviarMensaje' value='Enviar' class='btn btn-secondary'>
                        </form>
                      </div>";
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- Lista de  solicitudes -->
      <section>
        <div class="container py-5" style="padding-top: 0!important">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="chat3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row">

                            <h1 style="text-align: center;">Solicitudes de Amistad:</h1>

<?php
include('./inc/conexion.php');
$user_id = $_SESSION['user_id'];

try {
    // Consulta para obtener las solicitudes de amistad pendientes
    $sql = "SELECT a.friendship_id, a.estado_solicitud, u.username AS username_user_id_2, u.user_id AS user_id_user_id_2 FROM amistades a INNER JOIN usuarios u ON a.user_id_2 = u.user_id WHERE a.user_id_1 = :user_id_1 AND a.estado_solicitud = 'pendiente'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id_1', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($result) == 0) {
        echo "<div class='d-flex flex-row justify-content-center align-items-center '>
                <div>
                  <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>No tienes solicitudes de Amistad.</p>
                </div>
              </div>";
    } else {
        echo "<ol style='padding: 2%; margin-left: 10%; overflow-y: scroll; overflow-x: auto; scrollbar-width: thin; width: 80%!important;max-height: 100px'>";
        foreach ($result as $fila) {
            $amigo_username = $fila['username_user_id_2'];
            $friendship_id = $fila['friendship_id'];
            $amigo_id = $fila['user_id_user_id_2'];
            echo "<li>
                    $amigo_username
                    <a style='text-decoration: none; color: black;' href='./inc/aceptar_solicitud.php?friendship_id=$friendship_id&amigo_id=$amigo_id'>✅</a>
                    <a style='text-decoration: none; color: black;' href='./inc/borrar_solicitud.php?friendship_id=$friendship_id&amigo_id=$amigo_id'>❌</a>
                </li>";
        }
        echo "</ol>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    
}

$stmt->closeCursor();
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </body>
  <div class="position-absolute top-0 end-0 p-2">
  <form action="./inc/cerrar_sesion.php">
    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
  </form>
</div>


  </html>
  <script src="./js/buscar.js"></script>

<?php
}
?>
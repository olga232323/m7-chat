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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                      include("./inc/busqueda_usuarios.php");

                      $resultados = array();

                      if (isset($_POST['buscar']) && $_POST['busqueda_realizada'] !== '') {
                        $nombre = $_POST['busqueda_realizada'];
                        $resultados = buscarUsuarios($conn, $nombre);
                      }

                      ?>
                      <form action="chat_index.php" method="POST">
                        <div class="input-group mb-3">
                          <input type="search" class="form-control rounded" name="busqueda_realizada"
                            id="busqueda_realizada" placeholder="Búsqueda" aria-label="Búsqueda"
                            aria-describedby="search-addon" />

                          <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit" name="buscar">Buscar</button>
                            <!-- <a class="btn btn-secondary" onclick="window.location.href='./solicitudes_amistad.php'">+</a> -->

                            <?php if (isset($_POST['buscar'])) { ?>
                              <button class="btn btn-secondary" type="button"
                                onclick="window.location.href='./chat_index.php'">
                                &times;
                              </button>
                            <?php } ?>
                          </div>
                        </div>
                      </form>
                      <div>
                        <!-- Resultados de búsqueda -->
                        <div id="resultadosBusqueda" style="max-height: 400px; overflow-y: auto;">
                          <?php
                          if (!empty($resultados)) {
                            echo "<h5>Resultados de la búsqueda:</h5>";
                            echo "<ul style='list-style:none'>";
                            foreach ($resultados as $resultado) {
                              $nombreAmistad = $resultado['nombre_real'];
                              $idAmistad = $resultado['user_id'];
                              $usuarioActual = $_SESSION['user_id'];

                              // Verificar si son amigos o si hay una solicitud pendiente
                              if (!sonAmigos($conn, $usuarioActual, $idAmistad)) {
                                echo "<li class='p-2'>
                                <div class='d-flex flex-row'>
                                  <div class='pt-1'>
                                    <div class='row align-items-center'>
                                      <div class='col-6 text-center'>
                                        <p class='fw-bold text-left'>" . $nombreAmistad . "</p>
                                      </div>
                                      <div class='col-6 text-center'>
                                        <a class='btn d-inline-flex text-right' href='./inc/enviar_solicitud.php?agregarAmigo&idAmigo=" . $idAmistad . "' style='background-color: white; border: none; margin-bottom: 50%;'>
                                          ✅
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              ";
                              } else {
                                echo "<li class='p-2'>
                                      <a href='./chat_index.php?idAmigo=" . $idAmistad . "' class='text-decoration-none text-dark d-flex justify-content-between'>
                                          <div class='d-flex flex-row'>
                                              <div class='pt-1'>
                                                  <p class='fw-bold mb-0'>" . $nombreAmistad . "</p>
                                              </div>
                                          </div>
                                      </a>
                                  </li>";
                              }
                            }

                            echo "</ul>";
                          } elseif (isset($_POST['buscar']) && $_POST['busqueda_realizada'] !== '') {
                            echo "<p>Usuario no encontrado</p>";
                          } elseif (isset($_POST['buscar']) && $_POST['busqueda_realizada'] == '') {
                            echo "<p>No has escrito nada.</p>";
                          } elseif (!isset($_POST['buscar'])) { ?>
                            <!-- Amistades -->
                            <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                              <ul class="list-unstyled mb-0">
                                <!-- Buscar el chat con el usuario seleccionado -->
                                <?php
                                // Recibimos el listado de amigos de listado_amigos.php
                                include_once("./inc/listado_amigos.php");
                                ?>
                              </ul>
                            </div>
                            <?php
                          }
                          ?>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- Chat general -->
                  <div class="col-md-6 col-lg-7 col-xl-8">
                    <!-- Listado de mensajes -->
                    <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                      style="position: relative; height: 400px; overflow: auto;">
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
      <div class="container py-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="chat3" style="border-radius: 15px;">
              <div class="card-body">
                <div class="row">

                  <h1 style="text-align: center;">Solicitudes de Amistad:</h1>
                  <p id="resultado">dkhjfkdsj
              </p>

                  <!-- solicitudes php iba aqui-->
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
  <script src="./js/solicitudes.js"></script>

  </html>
  <?php
}
?>
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
                      // include("./inc/busqueda_usuarios.php");

                      $resultados = array();


                      ?>
                        <div class="input-group mb-3">
                          <input type="search" class="form-control rounded" name="busqueda_realizada"
                            id="busqueda_realizada" placeholder="Búsqueda" aria-label="Búsqueda"
                            aria-describedby="search-addon" />

                          <div class="input-group-append">
<<<<<<< HEAD
                            <!-- <a class="btn btn-secondary" onclick="window.location.href='./solicitudes_amistad.php'">+</a> -->
                           
                            <?php if (isset($_POST['buscar'])) { ?>
                              
                          <?php
                          }
                          ?>
                        </div>
                         
                      </div>
                      <div id="resultadosBusqueda" style="
    position: absolute;
    background-color: white;
    overflow-y: scroll;
    max-height: 300px; width: 28%;
"> 
=======
                      <div id="resultadosBusqueda"> 
>>>>>>> 5e37752774b636c63686f49437d6b47297589489
                     </div>
                     <div id="listarAmigos">
                      </div>
                    </div>
                  </div>
                  
                  <!-- Chat general -->
                  <div class="col-md-6 col-lg-7 col-xl-8">
                    <!-- Listado de mensajes -->
                    <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                      style="position: relative; height: 400px; overflow: auto;">
                        <div class='d-flex flex-row justify-content-center align-items-center '>
                          <div>
                            <p id="infoCuboChat" class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>Selecciona una
                              persona para chatear!</p>
                          </div>
                        </div>
                        <p id="listaMensajes"></p>
                        <!-- Aquí iba include listado_mensajes -->
                    </div>
                    <!-- Barra enviar mensaje -->
                    <div id="barraMensaje"></div>
                    <?php $userIDMensajes=(isset($_SESSION['user_id']))?$_SESSION['user_id']:''; ?>
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
                  <p id="resultado"></p>
                  <!-- solicitudes php iba aqui-->
                  <h1 style="text-align: center;">Solicitudes de Amistad:</h1>
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
    <script type="text/javascript">
    var userID='<?php echo $userIDMensajes;?>';
    </script>
  <script src="./js/mensajes.js"></script>
    <script src="./js/buscar.js"></script>
  </html>
<<<<<<< HEAD
  <script src="./js/buscar.js"></script>
  <script src="./js/amigos.js"></script>

<?php
}
=======
>>>>>>> 5e37752774b636c63686f49437d6b47297589489
?>
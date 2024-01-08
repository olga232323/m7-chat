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
    <script src="https://cdn.jsdelivr.net/npm bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
                                <div class="col-2">
                                <a href="./chat_index.php" class="btn btn-secondary btn-sm float-left" >Volver Atrás</a>

                                </div>
                            </div>
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
        echo "<ol style='margin-left: 10%;'>";
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
    die();
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
<?php
}

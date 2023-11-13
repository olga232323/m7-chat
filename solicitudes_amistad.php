<!DOCTYPE html>
<html>

<head>
    <title>Solicitudes de Amistad</title>
</head>

<body>
    <h1>Solicitudes de Amistad</h1>

    <?php
    session_start();
    include("./inc/conexion.php");

    $user_id = $_SESSION['user_id'];

    // Consulta para obtener las solicitudes de amistad pendientes
    $sql = "SELECT a.friendship_id, a.estado_solicitud, u.username AS username_user_id_2, u.user_id AS user_id_user_id_2 FROM amistades a INNER JOIN usuarios u ON a.user_id_2 = u.user_id WHERE a.user_id_1 = ? AND a.estado_solicitud = 'pendiente'";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<ul>";
        while ($fila = mysqli_fetch_assoc($result)) {
            $amigo_username = $fila['username_user_id_2'];
            $friendship_id = $fila['friendship_id'];
            $amigo_id = $fila['user_id_user_id_2'];
            echo "<li>
                    $amigo_username
                    <a href='./inc/aceptar_solicitud.php?friendship_id=$friendship_id&amigo_id=$amigo_id'>Aceptar</a>
                </li>";
        }
        echo "</ul>";

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    ?>
</body>

</html>
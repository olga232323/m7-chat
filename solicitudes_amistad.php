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
    $sql = "SELECT friendship_id, username, estado_solicitud
            FROM amistades
            INNER JOIN usuarios ON user_id_1 = user_id
            WHERE user_id_2 = ? AND estado_solicitud = 'pendiente'";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $friendship_id, $amigo_username, $estado_solicitud);

        echo "<ul>";
        while (mysqli_stmt_fetch($stmt)) {
            echo "<li>
                    $amigo_username
                    <a href='./inc/aceptar_solicitud.php?friendship_id=$friendship_id&amigo_username=$amigo_username'>Aceptar</a>
                </li>";
        }
        echo "</ul>";

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    ?>
</body>
</html>

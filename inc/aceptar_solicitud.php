<?php
session_start();

if (!isset($_SESSION['loginOk'])) {
    header('Location: ./cerrar_sesion.php');
    exit();
}

if (isset($_GET['friendship_id'])) {
    include("./conexion.php");

    $user_id = $_SESSION['user_id'];
    $friendship_id = mysqli_real_escape_string($conn, $_GET['friendship_id']);
    $amigo_username = mysqli_real_escape_string($conn, $_GET['amigo_username']);

    // Recoger el friendship_id que coincida
    $sql2 = "SELECT friendship_id FROM amistades WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
    $stmt2 = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt2, $sql2)) {
        mysqli_stmt_bind_param($stmt2, "iiii", $amigo_username, $user_id, $user_id, $amigo_username);
        mysqli_stmt_execute($stmt2);
        $resultadoConsulta = mysqli_stmt_get_result($stmt2);

        mysqli_stmt_close($stmt2);

        $friendship_id2 = null;

        while ($fila = mysqli_fetch_assoc($resultadoConsulta)) {
            $friendship_id2 = $fila['friendship_id'];
        }

        if ($friendship_id2 !== null) {
            // Consulta para obtener la fila de la solicitud de amistad
            $sql = "SELECT user_id_1, user_id_2 FROM amistades WHERE friendship_id = ? AND estado_solicitud = 'pendiente'";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $friendship_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $user_id_1, $user_id_2);

                if (mysqli_stmt_fetch($stmt)) {
                    // Verifica que el usuario actual sea uno de los usuarios de la solicitud
                    if ($user_id == $user_id_1 || $user_id == $user_id_2) {
                        // Cierra el resultado de la consulta anterior
                        mysqli_stmt_close($stmt);

                        // Actualiza la fila en la tabla 'amistades' para ambos usuarios
                        $update_sql = "UPDATE `amistades` SET `estado_solicitud`='aceptada' WHERE `friendship_id` IN (?, ?)";
                        $update_stmt = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($update_stmt, $update_sql)) {
                            mysqli_stmt_bind_param($update_stmt, "ii", $friendship_id, $friendship_id2);
                            mysqli_stmt_execute($update_stmt);
                            mysqli_stmt_close($update_stmt);

                            mysqli_close($conn);
                            header('Location: ../solicitudes_amistad.php');
                            exit();
                        }
                    }
                }

                mysqli_stmt_close($stmt);
            }
        }
    }

    mysqli_close($conn);
}

header('Location: ../solicitudes_amistad.php');
exit();

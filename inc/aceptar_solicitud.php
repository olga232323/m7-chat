<?php
session_start();
include("./conexion.php");

if (!isset($_SESSION['loginOk'])) {
    header('Location: ./cerrar_sesion.php');
    exit();
}

if (isset($_GET['friendship_id']) && isset($_GET['amigo_id'])) {
    $user_id = $_SESSION['user_id'];
    $friendship_id = $_GET['friendship_id'];
    $amigo_id =$_GET['amigo_id'];

    try {
        // Retrieve the second friendship_id that corresponds to the friend's user_id
        $sql2 = "SELECT friendship_id FROM amistades WHERE (user_id_2 = :user_id AND user_id_1 = :amigo_id)";
        $stmt2 = $conn->prepare($sql2);

        if (mysqli_stmt_prepare($stmt2, $sql2)) {
            mysqli_stmt_bind_param($stmt2, "ii", $user_id, $amigo_id);
            mysqli_stmt_execute($stmt2);
            $result = mysqli_stmt_get_result($stmt2);
            while ($fila = mysqli_fetch_assoc($result)) {
                $friendship_id2 = $fila['friendship_id'];
            }

            if ($friendship_id2 !== null) {
                // Update the rows in the 'amistades' table for both users
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
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}


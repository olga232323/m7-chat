<?php
session_start();

if (!isset($_SESSION['loginOk'])) {
    header('Location: ./cerrar_sesion.php');
    exit();
}

if (isset($_GET['friendship_id'])) {
    include("./conexion.php");

    $friendship_id = mysqli_real_escape_string($conn, $_GET['friendship_id']);
    $amigo_username = mysqli_real_escape_string($conn, $_GET['amigo_username']);

    // Actualiza la fila en la tabla 'amistades' para ambos usuarios
    $update_sql = "UPDATE `amistades` SET `estado_solicitud`='aceptada' WHERE `friendship_id` IN (?, ?)";
    $update_stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($update_stmt, $update_sql)) {
        mysqli_stmt_bind_param($update_stmt, "ii", $friendship_id, $amigo_username);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
    }

    mysqli_close($conn);
}

header('Location: ../solicitudes_amistad.php');
exit();

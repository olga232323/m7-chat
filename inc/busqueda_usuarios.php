<?php
include("./inc/conexion.php"); // Asegúrate de incluir conexión.php

function buscarUsuarios($conn, $nombre) {
    $consulta = "SELECT * FROM usuarios WHERE username LIKE '%" . $nombre . "%'";
    $result = mysqli_query($conn, $consulta);

    if ($result) {
        $results = array();

        while ($fila = mysqli_fetch_assoc($result)) {
            $nombreAmistad = $fila['nombre_real'];
            $idAmistad = $fila['user_id'];

            $results[] = array(
                'nombre_real' => $nombreAmistad,
                'user_id' => $idAmistad
            );
        }

        return $results;
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

function sonAmigos($conn, $user_id_1, $user_id_2) {
    $consulta = "SELECT estado_solicitud FROM Amistades
                 WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
    $stmt = mysqli_prepare($conn, $consulta);
    mysqli_stmt_bind_param($stmt, "iiii", $user_id_1, $user_id_2, $user_id_2, $user_id_1);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $estado_solicitud);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    if ($estado_solicitud === 'aceptada') {
        return true; // Son amigos
    } else {
        return false; // No son amigos o hay una solicitud pendiente
    }
}
?>

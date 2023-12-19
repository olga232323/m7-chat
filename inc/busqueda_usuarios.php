<?php
include("./inc/conexion.php");

function buscarUsuarios($conn, $nombre)
{
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $userID = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    
    try {
        $consulta = "SELECT user_id, nombre_real FROM usuarios WHERE (username LIKE ? OR nombre_real LIKE ?) AND NOT user_id = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $consulta);

        $parametro = '%' . $nombre . '%';
        mysqli_stmt_bind_param($stmt, "ssi", $parametro, $parametro, $userID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $results = array();

        while ($fila = mysqli_fetch_assoc($result)) {
            $nombreAmistad = $fila['nombre_real'];
            $idAmistad = $fila['user_id'];

            $results[] = array(
                'nombre_real' => $nombreAmistad,
                'user_id' => $idAmistad
            );
        }

        mysqli_stmt_close($stmt);
        return $results;

    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

function sonAmigos($conn, $user_id_1, $user_id_2)
{
    $user_id_1 = mysqli_real_escape_string($conn, $user_id_1);
    $user_id_2 = mysqli_real_escape_string($conn, $user_id_2);

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
    } else if ($estado_solicitud === 'pendiente') {
        return true; // No son amigos pero hay una solicitud pendiente
    } else {
        return false; // No son amigos
    }
}
?>
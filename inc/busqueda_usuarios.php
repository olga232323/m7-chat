<?php
include("conexion.php");

// function buscarUsuarios($conn, $nombre)
// // {
    session_start();
    $userID = $_SESSION['user_id'];
    $parametro = '%a%';

    try {
        // $consulta = "SELECT user_id, nombre_real FROM usuarios WHERE (username LIKE :parametro OR nombre_real LIKE :parametro) AND user_id <> :userID";
        // $consulta = "SELECT user_id, nombre_real FROM usuarios WHERE ((username LIKE '%a%'  OR nombre_real LIKE '%a%') AND user_id <> 36)";
        // <> is equal to not qual or !=
        $stmt = $conn->prepare("SELECT u.user_id, u.nombre_real, a.estado_solicitud FROM usuarios u LEFT JOIN amistades a ON (u.user_id = a.user_id_1) WHERE (u.username LIKE :parametro OR u.nombre_real LIKE :parametro) AND u.user_id <> :userID;");
        // <> not equal !=
        $stmt->bindParam(':parametro', $parametro);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $stmt->closeCursor();
        // $results = array();
        
        // foreach ($result as $fila) {
        //     $nombreAmistad = $fila['nombre_real'];
        //     $idAmistad = $fila['user_id'];
        
        //     $results[] = array(
        //         'nombre_real' => $nombreAmistad,
        //         'user_id' => $idAmistad
        //     );
        // }
        

        echo json_encode($result);

        

    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
// }

// function sonAmigos($conn, $user_id_1, $user_id_2)
// {
//     $consulta = "SELECT estado_solicitud FROM Amistades
//                  WHERE (user_id_1 = :user_id_1 AND user_id_2 = :user_id_2) OR (user_id_1 = :user_id_2 AND user_id_2 = :user_id_1)";
//     $stmt = $conn->prepare($consulta);
//     $stmt->bindParam(':user_id_1', $user_id_1);
//     $stmt->bindParam(':user_id_2', $user_id_2);
//     $stmt->execute();
//     $estado_solicitud = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $stmt->closeCursor();

//     $soli = ''; // Initialize $soli

//     if (!empty($estado_solicitud)) {
//         foreach ($estado_solicitud as $estado_soli) {
//             $soli =  $estado_soli['estado_solicitud'];
//         }
//     }

//     if ($soli === 'aceptada') {
//         return true; // Son amigos
//     } else if ($soli === 'pendiente') {
//         return true; // No son amigos, pero hay una solicitud pendiente
//     } else {
//         return false; // No son amigos
//     }
// }


?>
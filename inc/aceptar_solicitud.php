<?php
session_start();
include("./conexion.php");

if (!isset($_SESSION['loginOk'])) {
    header('Location: ./cerrar_sesion.php');
    exit();
}

if (isset($_POST['friend_id']) && isset($_POST['amigo_id'])) {
    $user_id = $_SESSION['user_id'];
    $friendship_id = $_POST['friend_id'];
    $amigo_id = $_POST['amigo_id'];

    try {
        // Retrieve the second friendship_id that corresponds to the friend's user_id
        $sql2 = "SELECT friendship_id FROM amistades WHERE (user_id_2 = :user_id AND user_id_1 = :amigo_id)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':user_id', $user_id);
        $stmt2->bindParam(':amigo_id', $amigo_id);
        $stmt2->execute();
        $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $fila) {
            $friendship_id2 = $fila['friendship_id'];
        }

        if ($friendship_id2 !== null) {
            // Update the rows in the 'amistades' table for both users
            $update_sql = "UPDATE `amistades` SET `estado_solicitud`='aceptada' WHERE `friendship_id` IN (:friendship_id, :friendship_id2)";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':friendship_id', $friendship_id);
            $update_stmt->bindParam(':friendship_id2', $friendship_id2);
            $update_stmt->execute();
            $update_stmt->closeCursor();
            $conn = null;
            echo "ok";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}


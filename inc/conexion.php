<?php
$servidor = "mysql:dbname=db_chat;host:localhost";
$user="root";
$pass="";

try {
    $conn = new PDO($servidor,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (Exception $e){
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}
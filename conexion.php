<?php
 $dbserver="localhost";
 $dbuser="root";
 $dbpwd="";
 $dbbasedatos="db_cshat";


 try{
 $conn = @mysqli_connect($dbserver,$dbuser,$dbpwd,$dbbasedatos);

}catch(Exception $e){
   echo("Error: ".$e->getMessage());
   die();

}
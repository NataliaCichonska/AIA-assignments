<?php  
$id = $_GET["id"];
require_once("functions.php");
require_once("update.php");


delete_movie($id);
sleep(3);
header('Location: http://localhost:8080/');
?>
<?php  
$id = $_GET["id"];
require_once("functions.php");
require_once("update.php");
$title = $_POST["title"];
$genres = $_POST["genres"];


if (!empty($title) && !empty($genres) && 
isset($title) && isset($genres) 
) {update_movie($title, $genres, $id);}
else {echo "Niepoprawne wartości pól";}
?>
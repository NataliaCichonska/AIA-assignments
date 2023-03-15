<?php  
require_once("functions.php");
$title = $_POST["title"];
$genres = $_POST["genres"];

if (!empty($title) && !empty($genres) && 
isset($title) && isset($genres)
) {insert_data($title, $genres);}
else {echo "Niepoprawne wartości pól";}
?>
<?php  
require_once("functions.php");
$userId = $_POST["userId"];
$tag = $_POST["tag"];
$movieId = $_GET["movieId"];

if (!empty($userId) && !empty($tag) && 
isset($userId) && isset($tag) && is_numeric($userId)
) {insert_tag($userId, $tag, $movieId
);}
else {echo "Niepoprawne wartości pól";}
?>
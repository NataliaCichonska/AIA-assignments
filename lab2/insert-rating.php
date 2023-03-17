<?php  
require_once("functions.php");
$userId = $_POST["userId"];
$rating = $_POST["rating"];
$movieId = $_GET["movieId"];

if (!empty($userId) && !empty($rating) && 
isset($userId) && isset($rating) && is_numeric($userId) && is_numeric($rating)
) {insert_rating($userId, $rating, $movieId
);}
else {echo "Niepoprawne wartości pól";}
?>
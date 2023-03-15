<?php  
$movieId = $_GET["movieId"];
$userId = $_GET["userId"];
$tagValue = $_GET["tag"];
$timestamp = $_GET["timestamp"];
require_once("functions.php");


delete_tag($movieId, $userId, $tagValue, $timestamp);
?>
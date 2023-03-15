
<?php

$server_addres = "localhost";
$username="root";
$password = "";
$database_name = "filmweb";

$conn = mysqli_connect($server_addres, $username, $password, $database_name);

if(!$conn){
    die('Connection error');
}

?>
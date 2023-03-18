<?php require_once "functions.php";

    if (isset($_POST["userId"]) && !empty($_POST["userId"]) && is_numeric($_POST["userId"])){
        insert_user($_POST["userId"]);
    } else {
        echo "User Id musi być numeryczne";
    }

?>
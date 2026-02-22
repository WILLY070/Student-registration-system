<?php

    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "studentdb";
    $conn = "";
    
    try{
        $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
    }
    catch(mysqli_sql_exception){
        echo "Could not connect to the database <br>";
    }
?>
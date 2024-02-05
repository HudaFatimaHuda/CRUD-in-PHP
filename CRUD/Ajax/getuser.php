<?php
    $query = $_GET["q"];
    $conn = new mysqli('localhost','root','','php_test_user');
    if($conn->connect_error){
        echo 'Connection failed: ' . $conn->connect_error;
    }
    $sql="SELECT * FROM login WHERE email = '" . $query . "'";
    $result = $conn->query($sql); 
    echo $result->num_rows ? "Email is already registered" : ""; 
?>
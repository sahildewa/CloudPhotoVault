<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "cloudphotovault_db";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Connection Failed");
}

?>
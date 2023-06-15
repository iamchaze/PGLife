<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "pglife";


$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    die("Database Connection Not Successful!". mysqli_connect_error());
}

?>
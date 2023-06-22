<?php
include '../db_connect.php';
session_start();

if (!$conn) {
    echo 'Error: ' . mysqli_connect_error();
}
$currentUser = $_SESSION['user_id'];
$property = $_POST['dislike-btn'];

$dislike = $conn->query("DELETE FROM INTERESTED_USERS_PROPERTIES WHERE USER_ID = '$currentUser' AND PROPERTY_ID = '$property';");


?>
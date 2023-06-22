<?php
include '../db_connect.php';
session_start();

if (!$conn) {
    echo 'Error: ' . mysqli_connect_error();
}
$currentUser = $_SESSION['user_id'];
$property = $_POST['like-btn'];

$like = $conn->query("INSERT INTO INTERESTED_USERS_PROPERTIES(`USER_ID`, `PROPERTY_ID`) VALUES('$currentUser', '$property');");
if (!$like) {
    echo 'Error:' . mysqli_error($conn);
}
echo $property;
?>
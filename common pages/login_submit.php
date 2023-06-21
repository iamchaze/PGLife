<?php
session_start();
include "../db_connect.php";



if (!$conn) {
    echo 'connection error' . mysqli_connect_error();
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = md5($password);

$fetchUserData = $conn->query("SELECT * FROM USERS WHERE EMAIL ='$email' AND PASSWORD = '$hashedPassword';");
if (!$fetchUserData) {
    echo 'Something went wrong: ' . mysqli_error($conn);
    return;
}

$row = mysqli_fetch_assoc($fetchUserData);
if ($row) {
    $_SESSION['user_id'] = $row['ID'];
    $_SESSION['username'] = $row['FULL_NAME'];
    echo "Login Successful!";
    return;
} else {
    echo "Invalid Credentials " . $row['ID'];
    return;
}

?>
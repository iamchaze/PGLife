<?php include "../db_connect.php";
if (!$conn) {
    echo 'connection error' . mysqli_connect_error();
    exit;
}

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = md5($password);
$college_name = $_POST['college_name'];
$gender = $_POST['gender'];

$fetchUserData = $conn->query("SELECT EMAIL FROM USERS WHERE EMAIL = '$email';");
if (!$fetchUserData) {
    echo 'Something Went Wrong!';
    return;
}
if (mysqli_num_rows($fetchUserData) > 0) {
    echo 'This email is already registered, Please Login!';
    return;
} else {
    $signupQuery = $conn->query("INSERT INTO USERS (`EMAIL`, `PASSWORD`, `FULL_NAME`, `PHONE`, `GENDER`, `COLLEGE_NAME`) VALUES ('$email', '$hashedPassword', '$full_name', '$phone', '$gender', '$college_name')");
    if ($signupQuery) {
        echo "Sign up Complete!";
    } else {
        echo mysqli_error($conn);
    }
}
?>
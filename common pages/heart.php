<?php
include '../db_connect.php';
session_start();

if (!$conn) {
    echo 'Error: ' . mysqli_connect_error();
}
$currentUser = $_SESSION['user_id'];
$propertyid = $_POST['propertyid'];

$isLikedSql = $conn->query("SELECT * FROM INTERESTED_USERS_PROPERTIES WHERE USER_ID = $currentUser AND PROPERTY_ID = $propertyid;");
$isLiked = mysqli_num_rows($isLikedSql);

if($isLiked > 0){
    $dislike = $conn->query("DELETE FROM INTERESTED_USERS_PROPERTIES WHERE USER_ID = '$currentUser' AND PROPERTY_ID = '$propertyid';");
    if (!$dislike) {
        echo 'Error:' . mysqli_error($conn);
    }
    echo 'Disliked';
    return;
} else {
    $like = $conn->query("INSERT INTO INTERESTED_USERS_PROPERTIES(`USER_ID`, `PROPERTY_ID`) VALUES('$currentUser', '$propertyid');");
    if (!$like) {
        echo 'Error:' . mysqli_error($conn);
    }
    echo 'Liked';
    return;
}

?>
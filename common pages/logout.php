<?php
session_start();



session_destroy();
include "../db_connect.php";

$v = $_POST['logout-btn'];
echo $v;

?>
<?php
session_start();

// $current_page = $_SERVER['REQUEST_URI'];
// $dashboard_page = '/PGLife/dashboard.php';

session_destroy();
include "../db_connect.php";

$v = $_POST['logout-btn'];
echo $v;

?>
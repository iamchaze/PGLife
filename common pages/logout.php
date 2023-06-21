<?php
session_start();

// $current_page = $_SERVER['REQUEST_URI'];
// $dashboard_page = '/PGLife/dashboard.php';

session_destroy();
include "../db_connect.php";
echo 'You have been Logged Out!';

?>
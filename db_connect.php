<?php
$db_host = "zhw.h.filess.io"; // Replace with your actual host
$db_user = "VanitySales_donkeysang"; // Replace with your actual username
$db_pass = "385dd18585e19524b017f3035d940465c5c927d6"; // Replace with your actual password
$db_name = "VanitySales_donkeysang"; // Replace with your actual database name
$db_port = "3305"; // Replace with your actual port number, typically 3306 for MySQL

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check Connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>

<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'myhmsdb');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 // SSE-SECURITY-FIX: avoid leaking detailed DB connection errors to end users.
 error_log('Database connection failed: ' . mysqli_connect_error());
 die('Database connection error.');
}
?>
<?php
function check_login()
{
if(strlen($_SESSION['login'])==0)
	{	
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="./user-login.php";		
		// SSE-SECURITY-FIX: avoid dynamic externalized redirect construction.
		header("Location: ./user-login.php");
		exit;
	}
}
?>
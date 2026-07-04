<?php
require_once __DIR__ . '/include/session_bootstrap.php';
$con=mysqli_connect("localhost","root","","myhmsdb");
require_once __DIR__ . '/include/security_utils.php';
if(isset($_POST['adsub'])){
	if (!sse_verify_csrf_token($_POST['csrf_token'] ?? '')) {
		die('Invalid CSRF token.');
	}
	// SSE-SECURITY-FIX: secure admin authentication with prepared statement and password compatibility verification.
	$username=sse_clean_input($_POST['username1']);
	$password=sse_clean_input($_POST['password2']);
	$authenticatedAdmin = false;
	$stmt = mysqli_prepare($con, "SELECT username, password FROM admintb WHERE username = ? LIMIT 1");
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	if($result && mysqli_num_rows($result)===1)
	{
		$row = mysqli_fetch_assoc($result);
		if(sse_verify_password_compat($password, $row['password'])) {
			$authenticatedAdmin = true;
			sse_regenerate_session();
			$_SESSION['username']=$username;
			header("Location:admin-panel1.php");
			exit;
		}
	}
	if(!$authenticatedAdmin)
		// header("Location:error2.php");
		echo("<script>alert('Invalid Username or Password. Try Again!');
          window.location.href = 'index.php';</script>");
}
if(isset($_POST['update_data']))
{
	if (!sse_verify_csrf_token($_POST['csrf_token'] ?? '')) {
		die('Invalid CSRF token.');
	}
	// SSE-SECURITY-FIX: use prepared statement for payment update.
	$contact=sse_clean_input($_POST['contact']);
	$status=sse_clean_input($_POST['status']);
	$stmt = mysqli_prepare($con, "UPDATE appointmenttb SET payment=? WHERE contact=?");
	mysqli_stmt_bind_param($stmt, "ss", $status, $contact);
	$result=mysqli_stmt_execute($stmt);
	if($result)
		header("Location:updated.php");
}




function display_docs()
{
	global $con;
	$query="select * from doctb";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		$name=$row['name'];
		# echo'<option value="" disabled selected>Select Doctor</option>';
		echo '<option value="'.htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8').'</option>';
	}
}

if(isset($_POST['doc_sub']))
{
	if (!sse_verify_csrf_token($_POST['csrf_token'] ?? '')) {
		die('Invalid CSRF token.');
	}
	// SSE-SECURITY-FIX: parameterize insert statement.
	$name=sse_clean_input($_POST['name']);
	$stmt = mysqli_prepare($con, "INSERT INTO doctb(name) VALUES(?)");
	mysqli_stmt_bind_param($stmt, "s", $name);
	$result=mysqli_stmt_execute($stmt);
	if($result)
		header("Location:adddoc.php");
}

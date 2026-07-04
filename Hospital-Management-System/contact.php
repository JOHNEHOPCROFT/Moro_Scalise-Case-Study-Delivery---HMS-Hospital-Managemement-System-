<?php 
require_once __DIR__ . '/include/session_bootstrap.php';
$con=mysqli_connect("localhost","root","","myhmsdb");
require_once __DIR__ . '/include/security_utils.php';
if(isset($_POST['btnSubmit']))
{
	if (!sse_verify_csrf_token($_POST['csrf_token'] ?? '')) {
		die('Invalid CSRF token.');
	}
	// SSE-SECURITY-FIX: parameterize contact form insertion.
	$name = sse_clean_input($_POST['txtName']);
	$email = sse_clean_input($_POST['txtEmail']);
	$contact = sse_clean_input($_POST['txtPhone']);
	$message = sse_clean_input($_POST['txtMsg']);

	$stmt = mysqli_prepare($con, "INSERT INTO contact(name,email,contact,message) VALUES(?,?,?,?)");
	mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contact, $message);
	$result = mysqli_stmt_execute($stmt);
	
	if($result)
    {
    	echo '<script type="text/javascript">'; 
		echo 'alert("Message sent successfully!");'; 
		echo 'window.location.href = "contact.html";';
		echo '</script>';
    }
}
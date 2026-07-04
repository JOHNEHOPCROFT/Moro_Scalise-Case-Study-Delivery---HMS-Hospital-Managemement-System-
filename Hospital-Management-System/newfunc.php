<?php
require_once __DIR__ . '/include/security_utils.php';
// session_start();
$con=mysqli_connect("localhost","root","","myhmsdb");
// if(isset($_POST['submit'])){
//  $username=$_POST['username'];
//  $password=$_POST['password'];
//  $query="select * from logintb where username='$username' and password='$password';";
//  $result=mysqli_query($con,$query);
//  if(mysqli_num_rows($result)==1)
//  {
//   $_SESSION['username']=$username;
//   $_SESSION['pid']=
//   header("Location:admin-panel.php");
//  }
//  else
//   header("Location:error.php");
// }
if(isset($_POST['update_data']))
{
 // SSE-SECURITY-FIX: parameterize legacy update flow.
 $contact=sse_clean_input($_POST['contact']);
 $status=sse_clean_input($_POST['status']);
 $stmt = mysqli_prepare($con, "UPDATE appointmenttb SET payment=? WHERE contact=?");
 mysqli_stmt_bind_param($stmt, "ss", $status, $contact);
 $result=mysqli_stmt_execute($stmt);
 if($result)
  header("Location:updated.php");
}

// function display_docs()
// {
//  global $con;
//  $query="select * from doctb";
//  $result=mysqli_query($con,$query);
//  while($row=mysqli_fetch_array($result))
//  {
//   $username=$row['username'];
//   $price=$row['docFees'];
//   echo '<option value="' .$username. '" data-value="'.$price.'">'.$username.'</option>';
//  }
// }


function display_specs() {
  global $con;
  $query="select distinct(spec) from doctb";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $spec=$row['spec'];
    echo '<option data-value="'.htmlspecialchars((string) $spec, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string) $spec, ENT_QUOTES, 'UTF-8').'</option>';
  }
}

function display_docs()
{
 global $con;
 $query = "select username, docFees, spec from doctb";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result) )
 {
  $username = $row['username'];
  $price = $row['docFees'];
  $spec = $row['spec'];
  echo '<option value="' .htmlspecialchars((string) $username, ENT_QUOTES, 'UTF-8'). '" data-value="'.htmlspecialchars((string) $price, ENT_QUOTES, 'UTF-8').'" data-spec="'.htmlspecialchars((string) $spec, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string) $username, ENT_QUOTES, 'UTF-8').'</option>';
 }
}

// function display_specs() {
//   global $con;
//   $query = "select distinct(spec) from doctb";
//   $result = mysqli_query($con,$query);
//   while($row = mysqli_fetch_array($result))
//   {
//     $spec = $row['spec'];
//     $username = $row['username'];
//     echo '<option value = "' .$spec. '">'.$spec.'</option>';
//   }
// }


if(isset($_POST['doc_sub']))
{
 // SSE-SECURITY-FIX: parameterize legacy doctor insert flow.
 $username=sse_clean_input($_POST['username']);
 $stmt = mysqli_prepare($con, "INSERT INTO doctb(username) VALUES(?)");
 mysqli_stmt_bind_param($stmt, "s", $username);
 $result=mysqli_stmt_execute($stmt);
 if($result)
  header("Location:adddoc.php");
}

?>
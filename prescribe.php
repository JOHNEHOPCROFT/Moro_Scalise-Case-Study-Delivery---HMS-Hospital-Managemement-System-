<!DOCTYPE html>
<?php
require_once __DIR__ . '/include/session_bootstrap.php';
require_once __DIR__ . '/include/security_utils.php';
sse_require_authenticated_doctor('index.php');
include('func1.php');
$pid='';
$ID='';
$appdate='';
$apptime='';
$fname = '';
$lname= '';
$doctor = $_SESSION['dname'];
if(isset($_GET['pid']) && isset($_GET['ID']) && ($_GET['appdate']) && isset($_GET['apptime']) && isset($_GET['fname']) && isset($_GET['lname'])) {
// SSE-SECURITY-FIX: sanitize GET-driven routing values before use in the prescription flow.
$pid = sse_clean_input($_GET['pid']);
  $ID = sse_clean_input($_GET['ID']);
  $fname = sse_clean_input($_GET['fname']);
  $lname = sse_clean_input($_GET['lname']);
  $appdate = sse_clean_input($_GET['appdate']);
  $apptime = sse_clean_input($_GET['apptime']);
}



if(isset($_POST['prescribe']) && isset($_POST['pid']) && isset($_POST['ID']) && isset($_POST['appdate']) && isset($_POST['apptime']) && isset($_POST['lname']) && isset($_POST['fname'])){
  if (!sse_verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token.');
  }
  // SSE-SECURITY-FIX: use prepared statement for prescription creation and sanitize all inputs.
  $appdate = sse_clean_input($_POST['appdate']);
  $apptime = sse_clean_input($_POST['apptime']);
  $disease = sse_clean_input($_POST['disease']);
  $allergy = sse_clean_input($_POST['allergy']);
  $fname = sse_clean_input($_POST['fname']);
  $lname = sse_clean_input($_POST['lname']);
  $pid = sse_clean_input($_POST['pid']);
  $ID = sse_clean_input($_POST['ID']);
  $prescription = sse_clean_input($_POST['prescription']);
  
  $stmt = mysqli_prepare($con, "INSERT INTO prestb(doctor,pid,ID,fname,lname,appdate,apptime,disease,allergy,prescription) VALUES (?,?,?,?,?,?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "siisssssss", $doctor, $pid, $ID, $fname, $lname, $appdate, $apptime, $disease, $allergy, $prescription);
  $query=mysqli_stmt_execute($stmt);
    if($query)
    {
      echo "<script>alert('Prescribed successfully!');</script>";
    }
    else{
      echo "<script>alert('Unable to process your request. Try again!');</script>";
    }
  // else{
  //   echo "<script>alert('GET is not working!');</script>";
  // }initial
  // enga error?
}

?>

<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, -scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #342ac1;
    border-color: #007bff;
}
.text-primary {
    color: #342ac1!important;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        
      </li>
       <li class="nav-item">
       <a class="nav-link" href="doctor-panel.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
      </li>
    </ul>
  </div>
</nav>

</head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>

<body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo sse_e($doctor) ?>
   </h3>

   <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <form class="form-group" name="prescribeform" method="post" action="prescribe.php">
        
          <div class="row">
                  <div class="col-md-4"><label>Disease:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control" name="disease" required> -->
                  <textarea id="disease" cols="86" rows ="5" name="disease" required></textarea>
                  </div><br><br><br>
                  
                  <div class="col-md-4"><label>Allergies:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text"  class="form-control" name="allergy" required> -->
                  <textarea id="allergy" cols="86" rows ="5" name="allergy" required></textarea>
                  </div><br><br><br>
                  <div class="col-md-4"><label>Prescription:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control"  name="prescription"  required> -->
                  <textarea id="prescription" cols="86" rows ="10" name="prescription" required></textarea>
                  </div><br><br><br>
                  <input type="hidden" name="fname" value="<?php echo htmlspecialchars((string) $fname, ENT_QUOTES, 'UTF-8') ?>" />
                  <input type="hidden" name="lname" value="<?php echo htmlspecialchars((string) $lname, ENT_QUOTES, 'UTF-8') ?>" />
                  <input type="hidden" name="appdate" value="<?php echo htmlspecialchars((string) $appdate, ENT_QUOTES, 'UTF-8') ?>" />
                  <input type="hidden" name="apptime" value="<?php echo htmlspecialchars((string) $apptime, ENT_QUOTES, 'UTF-8') ?>" />
                  <input type="hidden" name="pid" value="<?php echo htmlspecialchars((string) $pid, ENT_QUOTES, 'UTF-8') ?>" />
                  <input type="hidden" name="ID" value="<?php echo htmlspecialchars((string) $ID, ENT_QUOTES, 'UTF-8') ?>" />
                  <br><br><br><br>
          <input type="hidden" name="csrf_token" value="<?php echo sse_e(sse_generate_csrf_token()) ?>" />
          <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary" style="margin-left: 40pc;">
          
        </form>
        <br>
        
      </div>
      </div>
      

  

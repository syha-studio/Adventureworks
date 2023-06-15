<?php 
session_start();
if (isset($_SESSION["login"])){
  header ("Location: index.php");
  exit;
}
require 'functions.php';

if ( isset($_POST["submit"])){
  $username = $_POST["email"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM users where username = '$username' OR email = '$username'");

  if (mysqli_num_rows($result) === 1){
    $row = mysqli_fetch_assoc ($result);
    if (password_verify ($password, $row ["sandi"])){
      $_SESSION["login"] = true;
      header("Location: index.php");
      exit;
    }
  }
  $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>DW - Adventureworks</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container p-5">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 col-md-7">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Data Warehouse Adventureworks <br>
                                            (Sales and Production)</h1>
                                    </div>
                                    <hr>
                                    <?php if (isset($error)) : ?>
                                      <div class="row text-center mb-1">
                                        <div class="col pt-1">
                                          <p style = "color : red;">Username/Password salah!!</p>
                                        </div>
                                      </div>
                                    <?php endif ?>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter username / Email" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" autocomplete="off">
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block"><i class="bi bi-box-arrow-in-right"></i> Login</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
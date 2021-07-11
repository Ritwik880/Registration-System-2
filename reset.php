
<?php
session_start();
ob_start();

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <?php include './links/link.php' ?>
    <style>
        .main {
            background-color: silver;
            /* height: 100vh;
            width: 100%; */
        }

        .container {
            display: flex;
            justify-content: center;
            text-align: center;
            height: 100vh;
            width: 50%;
            text-align: center;
        }

        h1,
        p {
            text-align: center;
            margin-top: 5px;
        }

        .btn1 {
            text-decoration: none;
            margin-bottom: 3px;
            color: darkblue;
        }
    </style>
</head>

<body>

    <?php
    include './db/dbconnect.php';
    if (isset($_POST['submit'])) {

        if (isset($_GET['token'])) {
            $token = $_GET['token'];


            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

            $pass = password_hash($password, PASSWORD_BCRYPT);
            $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
            $updatequery = "upadte registration set password='$pass' where token = '$token' ";

            $iquery = mysqli_query($con, $updatequery);
            if($iquery){
                $_SESSION['msg'] = "Your password has been updated";
                header('location:login.php');

            } else{
                $_SESSION['passmsg'] = "Your password is not updated";
                header('location:reset.php');

            }
            else{
                $_SESSION['passmsg'] = "Your password is not matching";

            }

        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="#">Source Code</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
    <div class="main">
        <h1>Create Account</h1>
        <p>Get started with your free account</p>
        <p class="bg-info text-white px-5"><?php
        if(isset($_SESSION['passmsg'])){
            echo $_SESSION['passmsg']; 

        }else{
            echo $_SESSION['passmsg'] = "";
        }
        
         ?></p>
        <div class="container my-5">

            <form action="" method="POST">

                <div class="mb-3">
                    <input placeholder="New password" type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <input placeholder="Confirm password" type="cpassword" name="cpassword" class="form-control" id="cpassword" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Update Password</button>
                <br>
                <span style="font-weight: bold;" class="my-3">Have an account?</span>
                <a class="btn1" style="font-weight: bold;" href="./login.php">Login Now</a>
            </form>

        </div>
    </div>
    <footer class="container-fluid bg-dark my-0 py-3 text-light">
        <p class="mb-0 text-center">&copy; 2021-2022</p>
        <p class="mb-0 text-center">
            <a href="#">Back to top |</a>
            <a href="#">Privacy |</a>
            <a href="#">Terms</a>
        </p>

    </footer>



</body>

</html>
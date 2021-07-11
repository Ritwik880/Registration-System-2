<?php

?>

<?php
session_start();

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
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

        $password = password_hash($password, PASSWORD_BCRYPT);

        $cpassword = password_hash($cpassword, PASSWORD_BCRYPT);

        $token = bin2hex(random_bytes(15));

        $emailquery = "SELECT * FROM `registration` WHERE email='$email' ";
        $query = mysqli_query($conn, $emailquery);

        $emailcount = mysqli_num_rows($query);
        if ($emailcount > 0) {
            echo "Email already exists";
        } else {
            if ($password === $cpassword) {
                $sql = "INSERT INTO `registration` ( `name`, `email`, `phone`, `password`, `cpassword`, `token`) VALUES ('$name', '$email', '$phone', '$password', '$cpassword', '$token', 'inactive');";

                $result = mysqli_query($conn, $sql);
                if ($conn) {

               
                    $subject = "Email Activation";
                    $body = "Hii, $name. Click here to activate your account
                    http://localhost/emailverificationregistration/activate.php?token=$token";
                    $headers = "From: arnavanand892@gmail.com";

                    if (mail($email, $subject, $body, $headers)) {
                       $_SESSION['msg'] = "check your mail to activate your account $email";
                       header('location:login.php'); 
                    } else {
                        echo "Email sending failed...";
                    }
                } else {
    ?>
                    <script>
                        alert("NO Connection");
                    </script>
    <?php
                }
            } else {
                echo "password are not matching";
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
        <div class="container my-5">

            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <button type="button" class="btn btn-primary">Login via Gmail</button>
                <button type="button" class="btn btn-danger">Login via facebook</button>


                <h5>OR</h5>
                <div class="mb-3">
                    <input placeholder="Full name" type="name" name="name" class="form-control" id="name" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <input placeholder="Email address" type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <input placeholder="Phone number" type="phone" name="phone" class="form-control" id="phone" required>
                </div>
                <div class="mb-3">
                    <input placeholder="Create password" type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <input placeholder="Repeat password" type="cpassword" name="cpassword" class="form-control" id="cpassword" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Create Account</button>
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
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

        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $emailquery = "SELECT * FROM `registration` WHERE email='$email' ";
        $query = mysqli_query($conn, $emailquery);

        $emailcount = mysqli_num_rows($query);
        if ($emailcount) {
            $namedata = mysqli_fetch_array($query);
            $name = $namedata['name'];
            $token = $tokendata['token'];

            $subject = "Password reset";
            $body = "Hii, $name. Click here to reset your password
                    http://localhost/emailverificationregistration/reset.php?token=$token";
            $headers = "From: arnavanand892@gmail.com";

            if (mail($email, $subject, $body, $headers)) {
                $_SESSION['msg'] = "check your mail to reset your password $email";
                header('location:login.php');
            } else {
                echo "Email sending failed...";
            }
        } else {
            echo "NO Email found";
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
        <h1>Recover your account</h1>
        <p>Please fill email id properly</p>
        <div class="container my-5">

            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                <div class="mb-3">
                    <input placeholder="Email address" type="email" name="email" class="form-control" id="email" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Send Mail</button>
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
<?php
    session_start();
    require 'config/dbconnect.php';
    
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        header('Location: mainpage.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>S&R Share - Register</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
        <link rel="stylesheet" href="assets/css/Footer-Basic.css">
        <link rel="stylesheet" href="assets/css/Header-Blue.css">
        <link rel="stylesheet" href="assets/css/Header-Dark.css">
        <link rel="stylesheet" href="assets/css/Highlight-Clean.css">
        <link rel="stylesheet" href="assets/css/Login-Box-En.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
        <header class="header-blue" style="height: 660px;">

            <!-- Navbar -->
            <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">S&amp;R Share</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://discord.com" target="_blank">Discord</a></li>
                        </ul>
                        <form class="d-flex me-auto navbar-form" target="_self">
                            <div class="d-flex align-items-center"></div>
                        </form>
                        <span class="navbar-text"> </span><a class="btn btn-light action-button" role="button" href="login.php">Login</a>
                    </div>
                </div>
            </nav>
            <!-- End navbar -->

            <!-- Register -->
            <div class="d-flex flex-column justify-content-center" id="login-box">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="login-box-header">
                        <h4 style="color:rgb(139,139,139);margin-bottom:0px;font-weight:400;font-size:27px;">REGISTER</h4>
                    </div>
                    <div class="email-login" style="background-color:#ffffff;">
                        <input type="text" class="email-imput form-control" style="margin-top:10px;" required="" placeholder="Username" minlength="6" name="username">
                        <input type="email" class="email-imput form-control" style="margin-top:10px;" required="" placeholder="Email" minlength="6" name="email">
                        <input type="password" class="password-input form-control" style="margin-top:10px;" required="" placeholder="Password" minlength="6" name="password">
                        <input type="password" class="password-input form-control" style="margin-top:10px;" required="" placeholder="Confirm Password" minlength="6" name="confirm_password">
                    </div>
                    <div class="submit-row" style="margin-bottom:8px;padding-top:0px;">
                        <p id="alertWrongRegister" style="color: red; display: none;"></p>
                        <input class="btn btn-primary d-block box-shadow w-100" id="submit-id-submit" type="submit" name="submit" value="Register">
                    <div id="login-box-footer" style="padding:10px 20px;padding-bottom:23px;padding-top:18px;">
                        <p style="margin-bottom:0px;">Already have an account?<a id="register-link" href="login.php">Login!</a></p>
                    </div>
                </form>
                <?php
                    if (isset($_POST["submit"])){
                        $username = $_POST["username"];
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $confirm_password = $_POST["confirm_password"];

                        if ($password != $confirm_password) {
                            echo '<script>document.getElementById("alertWrongRegister").innerHTML = "Passwords do not match!";</script>';
                            echo '<script>document.getElementById("alertWrongRegister").style.display = "block";</script>';
                        }

                        try {
                            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                            if ($conn->query($sql) === TRUE) {
                                echo '<script>document.getElementById("alertWrongRegister").innerHTML = "Registration successful!";</script>';
                                echo '<script>document.getElementById("alertWrongRegister").style.color = "green";</script>';
                                echo '<script>document.getElementById("alertWrongRegister").style.display = "block";</script>';
                            }
                        } catch (Exception $e) {
                            if ($e->getCode() == 1062) {
                                echo '<script>document.getElementById("alertWrongRegister").innerHTML = "Email already exists!";</script>';
                                echo '<script>document.getElementById("alertWrongRegister").style.display = "block";</script>';
                            } else {
                                echo '<script>document.getElementById("alertWrongRegister").innerHTML = "Error: ' . $e->getMessage() . '";</script>';
                                echo '<script>document.getElementById("alertWrongRegister").style.display = "block";</script>';
                            }
                        }
                    }
                ?>
            </div>
            <!-- End register -->

        </header>

        <!-- Footer -->
        <footer class="footer-basic" style="height: 0px;">
            <p class="copyright" style="margin: -10px 0px 0px;">RannStudio © 2022</p>
        </footer>
        <!-- End Footer -->

        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
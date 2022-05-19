<?php
session_start();
require 'config/dbconnect.php';

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header('Location: mainpage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>S&R Share - Login</title>
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
            <!-- End Navbar -->

            <!-- Login -->
            <div class="d-flex flex-column justify-content-center" id="login-box">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="login-box-header">
                        <h4 style="color:rgb(139,139,139);margin-bottom:0px;font-weight:400;font-size:27px;">LOGIN</h4>
                    </div>
                    <div class="email-login" style="background-color:#ffffff;">
                        <input type="email" class="email-imput form-control" style="margin-top:10px;" required="" placeholder="Email" minlength="6" name="email">
                        <input type="password" class="password-input form-control" style="margin-top:10px;" required="" placeholder="Password" minlength="6" name="password">
                    </div>
                    <div class="submit-row" style="margin-bottom:8px;padding-top:0px;">
                        <p id="alertWrongLogin" style="color: red; display: none;">Wrong email or password</p>
                        <input class="btn btn-primary d-block box-shadow w-100" id="submit-id-submit" type="submit" name="submit" value="Login">
                    </div>
                    <div id="login-box-footer" style="padding:10px 20px;padding-bottom:23px;padding-top:18px;">
                        <p style="margin-bottom:0px;">Don't have an account?<a id="register-link" href="register.php">Register!</a></p>
                    </div>
                </form>
                <?php
                    if (isset($_POST["submit"])){
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($row["email"] == $email && $row["password"] == $password){
                                    $_SESSION['logged'] = true;
                                    $_SESSION['userid'] = $row["id"];
                                    header('Location: mainpage.php');
                                    exit();
                                }
                            }
                        } else {
                            echo "<script>document.getElementById('alertWrongLogin').style.display = 'block';</script>";
                        }
                    }
                ?>
            </div>
            <!-- End Login -->

        </header>

        <!-- Footer -->
        <footer class="footer-basic" style="height: 0px;">
            <p class="copyright" style="margin: -10px 0px 0px;">RannStudio © 2022</p>
        </footer>
        <!-- End Footer -->

        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
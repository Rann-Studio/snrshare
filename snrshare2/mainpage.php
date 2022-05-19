<?php
    session_start();
    require 'config/dbconnect.php';
    
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
        header('Location: login.php');
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>S&R Share - Main Page</title>
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
        <header class="header-blue" style="height: 660px;background: rgb(24, 78, 142);">
            <!-- Navbar -->
            <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">S&amp;R Share</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://discord.com" target="_blank">Discord</a></li>
                            <li class="nav-item"><a class="nav-link" href="myaccount.php">My account</a></li>
                        </ul>
                        <form class="d-flex me-auto navbar-form" target="_self">
                            <div class="d-flex align-items-center"></div>
                        </form>
                        <span class="navbar-text"> </span>
                        <a class="btn btn-light action-button" role="button" href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="container">
                <div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <textarea style="width: 700px;height: 500px;margin-top: 40px;" name="editor"></textarea>
                        <div style="margin-left: 746px;margin-top: -510px;">

                            <div>
                                <p style="color: rgb(255,255,255);margin-top: 0px;">Nama File</p>
                                <input class="form-control" type="text" name="filename" style="width: 350px;margin-top: -10px;" placeholder="Nama File" required="" autocomplete="off">
                            </div>

                            <div style="margin-top: 10px;">
                                <p style="color: rgb(255,255,255);">Expirate setelah</p>
                                <select class="form-select" style="width: 350px;height: 46px;margin-top: -10px;" name="expire">
                                    <option value="never" selected="">Tidak Pernah</option>
                                    <option value="600">10 Menit</option>
                                    <option value="3600">1 Jam</option>
                                    <option value="86400">1 Hari</option>
                                    <option value="604800">1 Minggu</option>
                                    <option value="2628000">1 Bulan</option>
                                </select>
                            </div>
                            <div style="margin-top: 10px;">
                                <p style="color: rgb(255,255,255);">Visibilitas</p>
                                <select class="form-select" style="width: 350px;height: 46px;margin-top: -10px;" name="visibility">
                                    <option value="public" selected="">Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                            <div style="margin-top: 10px;">
                                <p style="color: rgb(255,255,255);margin-top: 0px;"><input type="checkbox" id="checkboxPass" onclick="enablePass()">&nbsp;Password</p>
                                <input id="filePass" class="form-control" type="password" name="password" style="width: 350px;margin-top: -10px;" placeholder="Password" disabled="">
                            </div>
                            <input class="btn btn-primary" style="width: 350px;height: 46px;margin-top: 35px;" type="submit" name="submit" value="Upload">
                        </div>
                    </form>
                    <?php
                        if (isset($_POST["submit"])){
                            if (empty($_POST["editor"])){
                                $editor = "";
                                echo "<script>alert('Textarea tidak boleh kosong!');</script>";
                            } else {
                                $editor = nl2br($_POST["editor"]);
                                $editor = preg_replace("/<br\\s*?\/??>/i", "", $editor);

                                date_default_timezone_set("Asia/Jakarta");
                                $datetime = date("Y-m-d H:i:s");
                                $filename = $_POST["filename"] . "_" . date("YmdHis") . ".txt";
                                $filetitle = $_POST['filename'];
                                
                                $expire = $_POST["expire"];
                                $visibility = $_POST["visibility"];

                                if ($expire == "never"){
                                    $expire = "0000-00-00 00:00:00";
                                } else {
                                    $expire = date("Y-m-d H:i:s", strtotime("+$expire seconds"));
                                }

                                if (isset($_POST["password"])){
                                    $password = $_POST["password"];
                                } else {
                                    $password = "false";
                                }

                                if (file_exists("uploadFiles/" . $filename)){
                                    echo "<script>alert('File sudah ada!');</script>";
                                } else {
                                    $file = fopen("uploadFiles/" . $filename, "w");
                                    fwrite($file, $editor);
                                    fclose($file);

                                    // echo "file name: " . $filename . "<br> Upload time: " . $datetime . "<br> Expire time: " . $expire . "<br> Visibility: " . $visibility . "<br> Password: " . $password;

                                    $sql = "INSERT INTO files (userid, filename, filetitle, uploadtime, expiretime, visibility, password) VALUES ('" .  $_SESSION['userid'] . "', '$filename', '$filetitle', '$datetime', '$expire', '$visibility', '$password')";
                                    if ($conn->query($sql) === TRUE) {
                                        echo "<script>alert('File berhasil diupload!');</script>";
                                    } else {
                                        echo "<script>alert('File gagal diupload!');</script>";
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </header>
        <footer class="footer-basic" style="height: 0px;">
            <p class="copyright" style="margin: -10px 0px 0px;">RannStudio © 2022</p>
        </footer>
        <script>
            function enablePass(){
                var checkbox = document.getElementById("checkboxPass");
                if (checkbox.checked == true){
                    document.getElementById("filePass").disabled = false;
                } else {
                    document.getElementById("filePass").disabled = true;
                }
            }
        </script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
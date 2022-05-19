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
    <title>S&R Share - My Account</title>
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
        <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
            <div class="container-fluid"><a class="navbar-brand" href="#">S&amp;R Share</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://discord.com" target="_blank">Discord</a></li>
                        <li class="nav-item"><a class="nav-link" href="mainpage.php">Upload</a></li>
                    </ul>
                    <form class="d-flex me-auto navbar-form" target="_self">
                        <div class="d-flex align-items-center"></div>
                    </form><span class="navbar-text"> </span><a class="btn btn-light action-button" role="button" href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div style="margin-top: 40px;">
                <p style="color: rgb(255,255,255);font-size: 20px;">Change password</p>
                <form>
                    <p style="color: rgb(255,255,255);margin-bottom: 0px;">Old password</p><input class="form-control" type="password" placeholder="Now Password" style="width: 200px;">
                    <p style="color: rgb(255,255,255);margin-bottom: 0px;margin-top: 10px;">New password</p><input class="form-control" type="password" placeholder="New Password" style="width: 200px;">
                    <p style="color: rgb(255,255,255);margin-bottom: 0px;margin-top: 10px;">Confirm password</p><input class="form-control" type="password" placeholder="Confirm Password" style="width: 200px;">
                </form><button class="btn btn-primary" type="button" style="width: 200px;margin: 1px;margin-top: 17px;">Save</button>
            </div>
            <div style="margin-left: 320px;">
                <p style="color: rgb(255,255,255);margin-top: -326px;margin-left: 100px;font-size: 18px;font-style: normal;">My files</p>
                <div class="table-responsive" style="margin-top: 5px;margin-left: 100px;">
                    <?php
                        $sql = "SELECT * FROM files WHERE userid = '".$_SESSION['userid']."'";
                        $result = mysqli_query($conn, $sql);
                        
                        echo '<table class="table">';
                        echo '<thead style="color: rgb(255,255,255);">';
                        echo '<tr>';
                        echo '<td>Nama</td>';
                        echo '<td style="text-align: center;">Action</td>';
                        echo '</tr>';
                        echo '<tbody>';
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td style="color: rgb(255,255,255);">' . $row["filetitle"] . '.txt</td>';
                                echo '<td style="color: rgb(255,255,255); text-align: center;">';
                                echo '<button class="btn btn-success" onclick="openFile(' . $row["id"] . ",'" . $row["password"] . "','" . $row["visibility"] . '\')">Open</button>';
                                echo '<button style="margin-left: 25px;" class="btn btn-success" onclick="share(' . $row["id"] . ",'" . $row["password"] . "','" . $row["visibility"] . '\')">Share</button>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr>';
                            echo '<td style="color: rgb(255,255,255);">Anda masih belum mempunyai file yang di upload</td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    ?>
                </div>
            </div>
        </div>
    </header>
    <footer class="footer-basic" style="height: 0px;">
        <p class="copyright" style="margin: -10px 0px 0px;">RannStudio © 2022</p>
    </footer>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function openFile(fileId, filePass, fileVisibility) {
            window.open("file.php?id=" + fileId + "&password="  + filePass + "&visibility=" + fileVisibility, '_blank');
        }

        function share(fileId, filePass, fileVisibility) {
            navigator.clipboard.writeText("localhost/snrshare2/file.php?id=" + fileId + "&password="  + filePass + "&visibility=" + fileVisibility);
            alert("Link telah di salin");
        }
    </script>
</body>

</html>
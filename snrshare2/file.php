<?php
    session_start();
    require 'config/dbconnect.php';

    $fileId = $filePass = $fileVisibility = "";

    try {
        $fileId = $_GET['id'];
        $filePass = $_GET['password'];
        $fileVisibility = $_GET['visibility'];

        $sql = "SELECT * FROM files WHERE id = '$fileId'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                if ($row['visibility'] == "public") { 
                    if ($row['password'] == $filePass) {
                        echo "<pre>" . file_get_contents('uploadFiles/' . $row['filename']) . "</pre>";
                    } else {
                        echo '<script>alert("Password salah");window.location = "index.html";</script>';
                    }
                }
                
                else if ($row['visibility'] == "private") {
                    if ($row['password'] == $filePass) {
                        if ($row['userid'] == $_SESSION['userid']){
                            echo "<pre>" . file_get_contents('uploadFiles/' . $row['filename']) . "</pre>";
                        } else {
                            echo '<script>alert("Anda tidak memiliki akses untuk membuka file ini");window.location = "index.html";</script>';
                            exit();
                        }
                    } else {
                        echo '<script>alert("Password salah");window.location = "index.html";</script>';
                    }
                }

                else {
                    echo '<script>alert("File ini tidak dapat dibuka");window.location = "index.html";</script>';
                    exit();
                }
            }
        } else {
            echo '<script>alert("File tidak ditemukan");window.location = "index.html";</script>';
            exit();
        }
    } catch (Exception $e) {
        // pass
    }
?>
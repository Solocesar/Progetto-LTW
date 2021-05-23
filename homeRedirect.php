<?php
    session_start();
    if(isset($_SESSION['profile'])){
        $_SESSION['profile']= $_SESSION['id'];
    }
    header("Location: profilout.php");
?>
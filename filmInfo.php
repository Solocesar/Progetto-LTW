<?php
    session_start();
    if(isset($_POST['title'])) {
        if(isset($_SESSION['title'])) {
            unset($_SESSION['title']);
            $_SESSION['title'] = $_POST['title'];
        }
    }
?>

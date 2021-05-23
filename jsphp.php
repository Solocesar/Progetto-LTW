<?php
    session_start();
    if(isset($_POST['movie'])) {
        $_SESSION['film'] = $_POST['movie'];
        $_SESSION['title'] = $_POST['title'];
        
    }
    if(isset($_POST['title'])) {
        $_SESSION['title'] = $_POST['title'];
        
    }
?>

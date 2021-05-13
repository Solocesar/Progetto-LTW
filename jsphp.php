<?php
    session_start();
    if(isset($_POST['movie'])) {
        $_SESSION['film'] = $_POST['movie'];
        
        echo session_id();
    }
?>

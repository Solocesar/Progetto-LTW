<?php
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if(isset($_POST['submit1'])&&!empty($_POST['submit1'])){
    
    $hashpassword = md5($_POST['pwd1']);
    $sql ="SELECT *FROM accounts WHERE email = '".pg_escape_string($_POST['email1'])."' AND password ='".$hashpassword."'";
    $data = pg_query($dbconn,$sql); 
    $login_check = pg_num_rows($data);
    if($login_check > 0){ 
        session_start();
        $_SESSION['email'] = $_POST['email1'];
        header('Location: http://localhost/Progetto-LTW/profilout.php');
    }else{
        
        $_SESSION['message'] = 'The email or password is wrong';
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body>
        <dev class="container">
            <form action="" method="post" >
                <img src="filmshare-02.png" />
                <p>Insert your email:</p>
                <input type="email" name= "email1" size="25"  placeholder="Insert your email" required >
                <p>Insert your password:</p>
                <input type="password" name="pwd1" size="25" placeholder="Insert your password" required>
                <div class="error">
                    <?php
                    if (isset($_SESSION['message']))
                        {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>
                </div>
                <input class="sub" type="submit" name="submit1" value="submit">
                <nav class="main-nav">
                        <ul class="main-menu">
                            <li><a href="http://localhost/Progetto-LTW/registration.php">I haven't an account</a></li>

                        </ul>

                    </nav>  
            </form>
        </dev>
    
    </body>
</html>


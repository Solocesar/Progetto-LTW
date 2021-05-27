<?php
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if(isset($_POST['submit1'])&&!empty($_POST['submit1'])){
    
    $hashpassword = md5($_POST['pwd1']);
    $sql ="SELECT *FROM user1 WHERE email = '".pg_escape_string($_POST['email1'])."' AND password ='".$hashpassword."'";
    $data = pg_query($dbconn,$sql); 
    $login_check = pg_num_rows($data);
    $id1="SELECT id FROM user1 WHERE email = '".pg_escape_string($_POST['email1'])."' ";
    $id= pg_fetch_row(pg_query($dbconn,$id1))[0]; 
    echo $id;
    if($login_check > 0){ 
        session_start();
        $_SESSION['id'] = $id;
        header('Location: profilout.php');
    }else{
        
        $_SESSION['message'] = 'email o password sbagliati';
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body>

        <div id="showcase" class="container">
            <form action="" method="post" >
            <div class="row">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-lg-4">
                        <div class="vertical-center">
                            <div class="d-flex justify-content-center">
                                <img class="avatar img-fluid" src="images/filmshare-02.png">
                            </div>
                            <div class="list-group">
                                <li class="list-group-item"><h5>Inserisci la email:</h5> <input type="email" name= "email1" size="25"  placeholder="email" required ></li>
                                <li class="list-group-item"><h5>Inserisci la password:</h5> <input type="password" name="pwd1" size="25" placeholder="password" required></li>
            
                                <?php
                                    if (isset($_SESSION['message']))
                                        {
                                            echo'
                                            <div id="error" class="alert alert-danger" role="alert">
                                                '.$_SESSION['message'].'
                                            </div>';
                                        
                                            unset($_SESSION['message']);
                                        }
                                ?>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button id="bottone" class="btn btn-primary" type="submit" name="submit1" value="submit">Log in</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="link-secondary" href="registration.php">Non ho un account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
                            
            
    
        
    
    </body>
</html>
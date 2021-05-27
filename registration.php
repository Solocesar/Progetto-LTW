<?php
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

if(isset($_POST['submit'])&&!empty($_POST['submit'])){

    /* verifica se l'email è esistente*/
    $query= "SELECT email FROM user1";
    $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
    $emails= array();
    while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
        foreach( $line as $col_value) {
            array_push($emails,  $col_value);
        }
    }

    if(in_array($_POST['email'],$emails)) {
        $_SESSION['message'] = "email già in uso";
    } 
    elseif ($_POST['pwd']!=$_POST['pwd1']) {
        $_SESSION['message'] =  "password differenti";
    }

    elseif (strlen($_POST["pwd"]) < 8) {
        $_SESSION['message'] = "password non valida";
    }
    elseif(!preg_match("#[0-9]+#",$_POST["pwd"])) {
        $_SESSION['message'] = "password non valida";
    }

    else{

    /* verifica se l'username è esistente 
    
    wip 

    */


    /* registra l'utente */

        $sql = "INSERT INTO user1 (email, password, nickname, image) VALUES('".$_POST['email']."','".md5($_POST['pwd'])."','".$_POST['nome']."', 'https://www.nerdplanet.it/wp-content/uploads/2019/04/Bumblebee-and-Optimus-Prime-in-Transformers.jpg')";
        $ret = pg_query($dbconn, $sql);
        if($ret){
        
            header('Location: login.php');
        }else{
        
            echo "Something Went Wrong";
        }
    }
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/registration.css">
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
                                    <li class="list-group-item"><h5>Inserisci il tuo nickname:</h5> <input type="text" name= "nome" size="15" placeholder="nickname" required ></li>
                                    <li class="list-group-item"><h5>Inserisci la tua email:</h5> <input type="email" name= "email" size="25"  placeholder="email" required ></li>
                                    <li class="list-group-item"><h5>Inserisci la tua password:*</h5> <input type="password" name="pwd" size="25" placeholder="password" required></li>
                                    <li class="list-group-item"><h5>Inserisci nuovamente la tua password:</h5> <input type="password" name="pwd1" size="25" placeholder="password" required></li>
                                </div>
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
                                <div class="d-flex justify-content-center">
                                    <button id="bottone" class="btn btn-primary" type="submit" name="submit" value="sign in">Iscriviti</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a class="link-secondary" href="login.php">Ho già un account</a>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p class="msgpsw">*la password deve contenere almeno 8 caratteri ed un numero</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
    
    </body>
</html>
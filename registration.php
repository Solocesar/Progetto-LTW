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
        $_SESSION['message'] = "email already in use";
    } 

    $query= "SELECT nickname FROM user1";
    $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
    $emails= array();
    while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
        foreach( $line as $col_value) {
            array_push($emails,  $col_value);
        }
    }


    if(in_array($_POST['nome'],$emails)) {
        $_SESSION['message'] = "nickname already in use";
    } 

    elseif ($_POST['pwd']!=$_POST['pwd1']) {
        $_SESSION['message2'] =  "passwords are different";
    }

    elseif (strlen($_POST["pwd"]) < 8) {
        $_SESSION['message2'] = "Your Password Must Contain At Least 8 Characters!";
    }
    elseif(!preg_match("#[0-9]+#",$_POST["pwd"])) {
        $_SESSION['message2'] = "Your Password Must Contain At Least 1 Number!";
    }

    else{

    /* verifica se l'username è esistente 
    
    wip 

    */


    /* registra l'utente */

        $sql = "INSERT INTO user1 (email, password, nickname, image) VALUES('".$_POST['email']."','".md5($_POST['pwd'])."','".$_POST['nome']."', 'https://www.nerdplanet.it/wp-content/uploads/2019/04/Bumblebee-and-Optimus-Prime-in-Transformers.jpg')";
        $ret = pg_query($dbconn, $sql);
        if($ret){
        
            header('Location: http://localhost/Progetto-LTW/login.php');
        }else{
        
            echo "Something Went Wrong";
        }
    }
}


?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/registration.css">
    </head>
    <body>
        <div class="container">
            <form  method="post" >
                <div class="container1">
                    <img src="filmshare-02.png" />
                    <p>Insert your nickname:</p>
                    <input type="text" name= "nome" size="15" placeholder="Insert your nickname" required >
                    <p>Insert your email:</p>
                    <input type="email" name= "email" size="25"  placeholder="Insert your email" required >
                    <div class="error">
                        <?php
                            if (isset($_SESSION['message']))
                                {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                }
                        ?>
                    </div>
                </div>
                <div class="container2">
                    <p>Insert your password:*</p>
                    <input type="password" name="pwd" size="25" placeholder="Insert your password" required>
                    <p>Insert again your password:</p>
                    <input type="password" name="pwd1" size="25" placeholder="Insert again your password" required>
                    <div class="error">
                        <?php
                            if (isset($_SESSION['message2']))
                                {
                                    echo $_SESSION['message2'];
                                    unset($_SESSION['message2']);
                                }
                        ?>
                    </div>
                    <input class="sub" type="submit" name="submit" value="sign in">
                    <nav class="main-nav">
                        <ul class="main-menu">
                            <li><a href="http://localhost/Progetto-LTW/login.php">I have already an account</a></li>

                        </ul>

                    </nav>  
                    <p class="msgpsw">*password must contain at least 8 characters and at least 1 number</p>
                </div>
            </form>
        </div>
    
    </body>
</html>


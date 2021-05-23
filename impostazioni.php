<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
    if (isset($_SESSION['id'])) {
        echo $_SESSION['id'];
        if(isset($_POST['submit2'])&&!empty($_POST['submit2'])){
            if (isset($_POST['email2'])&&!empty($_POST['email2'])){
                $query= "SELECT email FROM user1";
                $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
                $emails= array();
                while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                    foreach( $line as $col_value) {
                        array_push($emails,  $col_value);
                    }
                }
            
                if(in_array($_POST['email2'],$emails)) {
                    echo "email già presa";
                }else{
                    $sql = "UPDATE user1 SET email = '".$_POST['email2']."' WHERE id='".$_SESSION['id']."'" ;
                    $ret = pg_query($dbconn, $sql);
                    $_SESSION['email'] = $_POST['email2'];
                }
            } 

            if (isset($_POST['nome2'])&&!empty($_POST['nome2'])){
                $query= "SELECT nickname FROM user1";
                $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
                $emails= array();
                while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                    foreach( $line as $col_value) {
                        array_push($emails,  $col_value);
                    }
                }
            
                if(in_array($_POST['nome2'],$emails)) {
                    echo "nickname già preso";
                }else{
                    $sql = "UPDATE user1 SET nickname = '".$_POST['nome2']."' WHERE id='".$_SESSION['id']."'" ;
                    $ret = pg_query($dbconn, $sql);
                }
            } 


            if (isset($_POST['photo2'])&&!empty($_POST['photo2'])){
                $sql = "UPDATE user1 SET image = '".$_POST['photo2']."' WHERE id='".$_SESSION['id']."'" ;
                $ret = pg_query($dbconn, $sql);
                
            } 

            if (isset($_POST['textarea'])&&!empty($_POST['textarea'])){
                $sql = "UPDATE user1 SET bio = '".$_POST['textarea']."' WHERE id='".$_SESSION['id']."'" ;
                $ret = pg_query($dbconn, $sql);
                
            } 


        }
            


    } else {

        header('Location: login.php');
    }


?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/impostazioni.css">
    </head>

    <body>
        <div class="container">
            <!--Form action-->
            <form action="" method="post" name="registr">
                <nav class="main-nav">
                    <ul class="main-menu">
                        <?php 
                            $_SESSION['profile']= $_SESSION['id'];
                            echo'
                            <li><a href="profilout.php">go back to your profile</a></li>
                            '
                        ?>
                    </ul>

                </nav>    

                <div class="container2">
                    <div class="c1">
                        <!--Corpo impostazioni-->
                        <?php
                                $queryn= pg_query($dbconn, "SELECT image FROM user1 WHERE id= '".$_SESSION['id']."'");
                                $image= pg_fetch_row($queryn);
                                echo '<img src="' . $image[0] . '"/>';
                        ?>

                        <p>Change your nickname:</p>
                        <p1>
                            <?php
                                $queryn= pg_query($dbconn, "SELECT nickname FROM user1 WHERE id= '".$_SESSION['id']."'");
                                $datas= pg_fetch_row($queryn);
                                echo '<input type="text" name= "nome2" size="15" maxlength= "15" placeholder='. $datas[0] .' >';

                            ?>
                        </p1>
                        
                        <p>Change your email:</p>
                        <p1> 
                            <?php
                                $queryn= pg_query($dbconn, "SELECT email FROM user1 WHERE id= '".$_SESSION['id']."'");
                                $datas= pg_fetch_row($queryn);
                                echo '<input type="email" name= "email2" size="25"  placeholder=' . $datas[0] . ' >';

                            ?>
                        </p1>
                    
                    </div>

                    <div class="c2">
                        <!--Corpo impostazioni-->
                        
                        
                        
                        <p>Change your password:</p>
                        <input type="password" name="password2" size="25" placeholder="Insert your password">
                        <p>Change your bio:</p>
                        <textarea class="textarea" name="textarea" rows="4" cols="50" maxlength="500" placeholder="insert your biography"></textarea>

                        <p>Change your photo:</p>
                        
                        <input type="url" name= "photo2" size="25" placeholder="insert an url" >
                        
                        <input class="sub" type="submit" name="submit2" value="Apply changes">
                    </div>
                </div>


            </form>
        </div>

    </body>

</html>
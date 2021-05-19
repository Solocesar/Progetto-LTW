<!DOCTYPE html>
<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

    if (isset($_SESSION['id'])) {
        echo $_SESSION['id'];

        if (isset($_POST['nickUser'])&&!empty($_POST['nickUser'])){
            $_SESSION['profile']= $_POST['nickUser'];
            header('Location: profilout.php');
        }

        if (isset($_POST['likeB'])&&!empty($_POST['likeB'])){

            $query= "SELECT iduser FROM like1 WHERE idreview ='". $_POST['likeB']."'";
            $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
            $emails= array();
            while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                foreach( $line as $col_value) {
                    array_push($emails,  $col_value);
                }
            }

            if(in_array($_SESSION['id'],$emails)) {
                $sql= "DELETE FROM like1 WHERE idreview= '".$_POST['likeB']."' AND iduser= '".$_SESSION['id']."'";
                $ret = pg_query($dbconn, $sql);
            } else {
                $sql= "INSERT INTO like1 VALUES('".$_POST['likeB']."','".$_SESSION['id']."')";
                $ret = pg_query($dbconn, $sql);
            }

        } 

    }else {

        header('Location: login.php');
    }
    

    

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/profilout.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/home.css">

    </head>
    <body> 

        <!--Nav Bar per navigare-->
        <div class="container">
            <nav class="main-nav">
                <ul class="main-menu">
                    <li><img class="logo" src="filmshare-02.png" /></li>
                    <li><a href="index.html">Scrivi una recensione</a></li>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="impostazioni.php">Impostazioni profilo</a></li>
                    <li><a href="logout.php">Logout</a></li>

                </ul>
            </nav>

            <div class="c1">
                <?php
                    $queryn= pg_query($dbconn, "SELECT id2 FROM friendship WHERE id1= '".$_SESSION['id']."'");
                    while ($datas= pg_fetch_row($queryn)){
                        $friendID= $datas[0];
                        
                        $querynimg= pg_query($dbconn, "SELECT image FROM user1 WHERE id= $friendID");
                        $image= pg_fetch_row($querynimg);
                        
                    
                    
                        $querynnick= pg_query($dbconn, "SELECT nickname FROM user1 WHERE id= $friendID");
                        $datas= pg_fetch_row($querynnick);
                    
                        $queryreview= pg_query($dbconn, "SELECT * FROM review WHERE userid= $friendID ORDER BY timestamp1");
                        while ($datas1= pg_fetch_row($queryreview)){
                            $queryLike= pg_query($dbconn, "SELECT * FROM like1 WHERE idreview='".$datas1[1]."'");
                            $likes= pg_num_rows($queryLike);
                            echo '
                            <div class="review">
                                <div class="utente">
                                    <img src="' . $image[0] . '"/>
                                    <div class="utente1">
                                        <form action="" method="post" name="utentenickname">
                                            <button value= '. $datas1[5] .' class= "nomeUtente"  type="submit" name="nickUser"> '. $datas[0] .'</button>
                                        </form>
                                        <p class="p">about</p>
                                        <h1 class="nomeFilm"> '. $datas1[7] .'</h1>
                                    </div>
                                </div>
                                <div class="commento">
                                        <p class="p">'. $datas1[3] .'</p>
                                    </div>
                                <div class="film">
                                    <p class="voto">'. $datas1[0] .'/10</p>
                                </div>
                                <form action="" method="post" name="likePost">
                                    <div class="like">
                                        <p> '. $likes.'</p>
                                        <button class= "likeB" value='. $datas1[1] .'  type="submit" name="likeB"><img src="https://image.similarpng.com/very-thumbnail/2020/06/Icon-like-button-transparent-PNG.png" /></button>
                                        
                                    </div>
                                    
                                </form>

                                
                            </div>
                            
                            ';


                    



                        }
                        

        
                        
                    }

                ?>
            </div>
        </div>
    </body>
</html>
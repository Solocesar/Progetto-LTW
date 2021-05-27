<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

    if (isset($_SESSION['id'])) {

        if(!isset($_SESSION['profile'])){
            $_SESSION['profile']= $_SESSION['id'];}

        if(isset($_POST['nickUser'])){
            $_SESSION['profile']= $_POST['nickUser'];}

        if (isset($_POST['follow'])&&!empty($_POST['follow'])){

            if($_POST['follow']=="unfollow") {
                $sql= "DELETE FROM friendship WHERE id1= '".$_SESSION['id']."' AND id2= '".$_SESSION["profile"]."'";
                $ret = pg_query($dbconn, $sql);
            } else {
                $sql= "INSERT INTO friendship VALUES('".$_SESSION['id']."','".$_SESSION["profile"]."')";
                $ret = pg_query($dbconn, $sql);
            }
            
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

        

    } else {

        header('Location: login.php');
    }

?>


<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="js/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" type="text/css" href="css/profilout.css">
    </head>
    <script src="js/jquery-3.6.0.js"></script>
    <body> 
        <!--Nav Bar per navigare-->
            <nav id="navbar" class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #97caEF;">
                <div class="container-fluid">
                    <!-- logo -->
                    <a class="navbar-brand" href="#"> <img src="images/filmshare-02.png" alt="" width="40" height="24"></a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse" id="navbarCollapse" >
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Scrivi una recensione</a></li>
                            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="homeRedirect.php">Profilo</a></li>
                            <li class="nav-item"><a class="nav-link" href="impostazioni.php">Impostazioni</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--Header del profilo-->

            <div id="showcase" class="container">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-lg-4">
                            <div class="text-center">
                                <?php
                                    $queryn= pg_query($dbconn, "SELECT image FROM user1 WHERE id= '".$_SESSION["profile"]."'");
                                    $image= pg_fetch_row($queryn);
                                    echo '<img class="avatar" src="' . $image[0] . '" alt="Card image cap">';
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="vertical-center">
                                <?php
                                    $queryn= pg_query($dbconn, "SELECT nickname FROM user1 WHERE id= '".$_SESSION["profile"]."'");
                                    $datas= pg_fetch_row($queryn);
                                    echo '
                                    <h1 class="title">'. $datas[0] .'</h1>';
                                ?>
                                <?php
                                    $queryn= pg_query($dbconn, "SELECT bio FROM user1 WHERE id= '".$_SESSION["profile"]."'");
                                    $datas= pg_fetch_row($queryn);
                                    echo '
                                    <p class="text">'. $datas[0] .'</p>';

                                ?>
                                <div class="list-group">
                                    <?php
                                        $query= pg_query($dbconn, "SELECT * FROM friendship WHERE id1='".$_SESSION["profile"]."'");
                                        $likes= pg_num_rows($query);
                                        echo '
                                        <li class="list-group-item"><strong>'. $likes .'</strong> account seguiti</li>';
                                    ?>
                                    <?php
                                        $query= pg_query($dbconn, "SELECT * FROM friendship WHERE id2='".$_SESSION["profile"]."'");
                                        $likes= pg_num_rows($query);
                                        echo '
                                        <li class="list-group-item"><strong>'. $likes .'</strong> follower</li>';
                                    ?>
                                    <?php
                                        $query= pg_query($dbconn, "SELECT * FROM review WHERE userid='".$_SESSION["profile"]."'");
                                        $likes= pg_num_rows($query);
                                        echo '
                                        <li class="list-group-item"><strong>'. $likes .'</strong> reviews fatte </li>';
                                    ?>
                                    <div class="bottoni">
                                        <?php
                                            if($_SESSION['profile'] != $_SESSION['id']){
                                                $queryn= "SELECT id2 FROM friendship WHERE id1= '".$_SESSION['id']."'";
                                                $result= pg_query($queryn) or die ( "Query failed: ". pg_lasterror());
                                                $friends= array();
                                                while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                                                    foreach( $line as $col_value) {
                                                        array_push($friends,  $col_value);
                                                    }
                                                }
                                                if(in_array($_SESSION['profile'],$friends)) {
                                                    echo  '
                                                    <form action="" method="post" name="utentenickname">
                                                        <button value= "unfollow" class= "btn btn-danger"  type="submit" name="follow">Unfollow</button>
                                                    </form>';

                                                } else {
                                                    echo  '
                                                    <form action="" method="post" name="utentenickname">
                                                        <button value= "follow" class= "btn btn-success"  type="submit" name="follow">Follow</button>
                                                    </form>';
                                                }
                                            }
                                        ?>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr id="hr" style="width: 75%;margin: auto;">

            <!--Film recensiti-->
                <div class="container mt-4">
                    <div class="row  d-flex justify-content-center">
                        
                        <?php
                            $queryreview= pg_query($dbconn, "SELECT * FROM review WHERE userid= '".$_SESSION["profile"]."' ORDER BY timestamp1");
                            while ($datas1= pg_fetch_row($queryreview)){
                                $queryLike= pg_query($dbconn, "SELECT * FROM like1 WHERE idreview='".$datas1[1]."'");
                                $likes= pg_num_rows($queryLike);
                                echo '
                                    <div id="card" class="card recensione" style="width: 33rem;">
                                        <div class="card-body">
                                        <button value= '.  $datas1[2] .' class="btn btn-outline-dark bottonefilm"  name="filmPost" onclick="movieSelected('. $datas1[2] .',\''. $datas1[7] .'\')"><strong> '. $datas1[7] .'</strong></button>                                            <p class="card-text">'. $datas1[3] .'</p>

                                            ';?>

                                            <div class="stars">
                                                <span class="rating1"><?=str_repeat("&#9733;", $datas1[0])?><?=str_repeat("&#9734;", 5-$datas1[0])?></span>
                                                
                                            
                                            </div>
                                            <?php echo'
                                            <form action="" method="post" name="likePost">
                                                <div class="like">
                                                    <p> '. $likes.'</p>
                                                    <button class= "likeB" value='. $datas1[1] .'  type="submit" name="likeB"><i class="far fa-thumbs-up" aria-hidden="true"></i></button>
                                                    
                                                </div>
                                                
                                            </form>
                                        </div>
                                    </div>
                                
                                ';
                            }

                        ?>
                </div>
            </div>
            <div class="d-flex justify-content-center">
            <div class="card noamici mx-auto" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">Non hai ancora recensioni!</h5>
                    <p class="card-text">Inizia a scriverne di nuove</p>
                    <div class="d-flex justify-content-center"> <a href="index.php" class="btn btn-primary">Pagina film</a></div>
                
                </div>
            </div>
                <?php
                echo ' 
                    <button id="load" type="button" class="btn btn-primary">Mostra le recensioni</button>  
                    <script type="text/javascript">
                    if ($(".recensione").length>0){
                        $(function(){
                        $("#load").show();
                        $(".recensione").slice(0, 0).show(); // select the first ten
                        $("#load").click(function(e){ // click event for load more
                            e.preventDefault();
                            $(".recensione:hidden").slice(0, 5).show(); // select next 5 hidden divs and show them
                            if($(".recensione:hidden").length == 0){ // check if any hidden divs still exist
                                $("#load").hide();
                            }
                        });
                        });
                    }
                    else{ 
                        $(".noamici").show();
                    }
                    </script>';
                ?>
            </div>
       

  <script>
function movieSelected(movieId,movieTitle) {
  // la session storage si cancella appena si chiude la tab / pagina.
  // var movieId= movie.id;
  sessionStorage.setItem('title', movieTitle);
  console.log(movieTitle);
  $.ajax({
    type: 'POST',
    url: 'jsphp.php',
    data: {'movie': movieId,'title':movieTitle}
  });


  sessionStorage.setItem('movieId', movieId);
  window.location.href = 'film.php';
  

  return false;
}
      </script>
    </body>
</html>
<!DOCTYPE html>
<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

    if (isset($_SESSION['id'])) {

        if (isset($_POST['nickUser'])&&!empty($_POST['nickUser'])){
            $_SESSION['profile']= $_POST['nickUser'];
           
            header('Location: profilout.php');
        }
        if(isset($_POST['filmPost'])&&!empty($_POST['filmPost'])){
            
            $_SESSION['film'] =$_POST['film'];
            echo $_POST['filmPost'];
            // $_SESSION['title'] =$_POST['filmPost'];
            header('Location: film.php');
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" type="text/css" href="css/home.css">

    </head>
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
        
     
        <div class="container mt-4" >
        
            <div class="space ">
            <div class="card noamici mx-auto" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">Non hai ancora amici!</h5>
                    <p class="card-text">Inizia a seguire nuove persone</p>
                    <div class="d-flex justify-content-center"> <a href="index.php" class="btn btn-primary">Pagina film</a></div>
                </div>
            </div>
            </div>
            <div class="row justify-content-center align-self-center">
            
        
                <?php
                    $queryn= pg_query($dbconn, "SELECT id2 FROM friendship WHERE id1= '".$_SESSION['id']."'");
                    $reviews= array();
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
                            $dizionario= [
                                "image" => $image[0],
                                "nomeUtente"=> $datas[0],
                                "idUtente"=> $datas1[5],
                                "film"=> $datas1[7],
                                "commento"=> $datas1[3],
                                "voto"=> $datas1[0],
                                "like"=> $likes,
                                "idLike"=> $datas1[1],
                                "timestamp"=> $datas1[6],
                                "filmid"=> $datas1[2]
                            ];
                            array_push($reviews, $dizionario);
                        }
                    }
                    $price = array();
                    foreach ($reviews as $key => $row)
                    {
                        $price[$key] = $row['timestamp'];
                    }
                    array_multisort($price, SORT_ASC, $reviews);
                    foreach ($reviews as $key => $row){
                        echo '
                        <div class="card recensione" style="width: 45rem;">
                            <div class="card-body">
                                <div id="inte" class="row"> 
                                    <div class="col-md-auto">
                                        <img  class="avatar" src="' . $row['image'] . '"/>
                                    </div>
                                    <div class="col-6">
                                        <form action="" method="post" name="utentenickname">
                                            <button value= '.  $row['idUtente'] .' class= "nomeUtente btn btn-info"  type="submit" name="nickUser"><strong> '. $row['nomeUtente'] .'</strong></button>
                                        </form>
                                        
                                    </div>
                                    <div class="col">
                                        <p class="timestamp"> '.$row['timestamp'].'</p>
                                    </div>
                                </div>
                            </div>
                            <hr id="hr" style="width: 100%;margin: auto;">
                            <div class="card-body">
                                <button value= '.  $row['filmid'] .' class="btn btn-outline-dark bottonefilm"  name="filmPost" onclick="movieSelected('. $row['filmid'] .',\''. $row['film'] .'\')"><strong> '. $row['film'] .'</strong></button>
                                <p class="card-text">'.  $row['commento'] .'</p>
                                ';?>

                                <div class="stars">
                                    <span class="rating1"><?=str_repeat("&#9733;", $row['voto'])?><?=str_repeat("&#9734;", 5-$row['voto'])?></span>
                                </div>
                                <?php echo'
                                <div class="row">
                                    <div class="d-flex flex-row-reverse">
                                        <div class="col-md-auto">
                                            <form action="" method="post" name="likePost">
                                                <button class= "likeB" value='.  $row['idLike'] .'  type="submit" name="likeB"><i class="far fa-thumbs-up" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-md-auto">
                                            <p> '.$row['like'].'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                        
                        ';
                    }

                ?>
            
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <?php 
            
            echo  ' 
            

            <button id="load" type="button" class="btn btn-primary">Mostra le recensioni</button>  
            <script type="text/javascript">
            if ($(".recensione").length>0){
                $(function(){
                $("#load").show();
                $(".space").hide();
                $(".recensione").slice(0, 10).show(); // select the first ten
                $("#load").click(function(e){ // click event for load more
                    e.preventDefault();
                    $(".recensione:hidden").slice(0, 5).show(); // select next 5 hidden divs and show them
                    if($(".recensione:hidden").length == 0){ // check if any hidden divs still exist
                        $("#load").hide();
                    }
                });
                });}
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
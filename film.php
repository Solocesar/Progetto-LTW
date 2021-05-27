<?php
session_start();
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if(!isset($_SESSION['id'])){
  header('Location: login.php');
}
if(isset($_SESSION['id'],$_POST['rating'],$_POST['content'])){
  // se hanno inviato i dati della recensione inserirla nel database
  $toinsert = array(
      'likes'=>0,
      'userid'=>$_SESSION['id'],
      'rating'=>$_POST['rating'],
      'filmid'=>$_SESSION['film'], 
      'comment1'=>$_POST['content'],
      'nomeFilm' => $_SESSION['title'],
      'timestamp1'=>date("Y-m-d H:i",time()));
  pg_insert($dbconn,'review',$toinsert);
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

?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <title>Film Share</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/film.css">

  <!-- fav icon  da mettere-->
</head>


<body>
  <!--barra navigazione-->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #97caEF;">
    <div class="container-fluid">
      <!-- logo -->
      <a class="navbar-brand" href="#"> <img src="images/filmshare-02.png" alt="" width="40" height="24"></a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Scrivi una recensione</a></li>
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="homeRedirect.php">Profilo</a></li>
        <li class="nav-item"><a class="nav-link" href="impostazioni.php">Impostazioni</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
        </form>
      </div>
    </div>
  </nav>

  <div id="container" class="container">


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Scrivi una recensione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form   method="POST"  name="reviews">
        
    
        <label for="customRange2" class="form-label">Voto(1-5)</label>
        <input name="rating" type="range" class="form-range" min="0" max="5" id="customRange2">
        <textarea class="form-control" rows="3" name="content" placeholder="Scrivi la tua recensione qui..." required></textarea>
        
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Submit Review</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <div id="movie"></div>
    
    <div id="containerTrailer"></div>
    <div class="reviews "></div>
    <script>
      const movieId = sessionStorage.getItem('movieId');
      fetch("reviews.php?movieId=" + movieId).then(response => response.text()).then(data => {
        document.querySelector(".reviews").innerHTML = data;});

      </script>
  </div>


  <!-- script per fare la ricerca -->

  <script src="js/apiTransaction.js"></script>
  <script src="js/film.js"></script>
  <script>

    getMovie()
    getTrailer()
  </script>
  <!-- Footer  -->
  <footer >
    <p>© Film Share</p>
  </footer>
</body>

</html>
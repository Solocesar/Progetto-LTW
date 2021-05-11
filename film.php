<!DOCTYPE html>
<?php
  session_start();
  $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

  if(isset($_SESSION['film'])) {
    $film= $_SESSION['film'];
    echo $film;
  }

  if(isset($_POST['submit'])&&!empty($_POST['submit'])){
      $review = $_POST['review'];
      $rating = $_POST['rating'];
      $time= date("l jS \of F Y h:i:s A");
      echo $time;
      $filmID = $_POST['filmID'];
      $sql ="INSERT INTO review (timestamp1, rating, filmid, comment1, likes, userid) VALUES('$time', $rating, $filmID, '$review', 0, '".$_SESSION['id']."')";
      pg_query($dbconn,$sql); 
  }
      
?>


<head>
<meta charset="UTF-8">
  <title>Film Share</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">

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
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="https://www.google.com/">Profilo</a></li>
          <!-- <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li> -->
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" id="searchText" type="search" placeholder="Titolo Film" aria-label="Search"
            required />
          <button class="btn btn-outline-success" id="search" type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Contenitore per la ricerca che averra dinamicamente -->
  <div id="container " class="container">
    <div id="movie"></div>
    <div id="trailer"></div>
  </div>

  <!-- script per fare la ricerca -->
  <!-- <script src="js/apiTransaction.js"></script> -->
  <!-- <script src="js/ricerca.js"></script> -->
  <script src="js/apiTransaction.js"></script>
  <script src="js/film.js"></script>
  <script>

    getMovie()
    getTrailer()
  </script>

  <!--
  <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    Launch demo modal
  </button>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a small modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
-->
  <form action="" method="post" name="registr">
    <div class="recensione">
      <input type="number" name="rating" min="0" max="10"> /10
      <textarea class="textarea" name="review" rows="4" cols="50" maxlength="500" placeholder="insert your review"></textarea>
      <input class="sub" type="submit"  name="submit" value="share it">
      <input type="hidden"  id="filmID" name="filmID" value=''>
      <script type="text/javascript"> 
        window.onload = function(){
          var filmID = sessionStorage.getItem('movieId');
          document.getElementById("filmID").value=(filmID);
        }
      </script>
    </div>
  </form>

  <?php
      $filmID =  $_SESSION['film'];
      $queryn= pg_query($dbconn, "SELECT comment1 FROM review WHERE filmid= $filmID");
      $datas= pg_fetch_row($queryn);
      echo $datas;
      for($i = 0; $i < count($datas); ++$i) {
        echo '<h1 class="h1">'.  $datas[$i] .'</h1>';
      }

  ?>
 
  <!-- Footer  -->
  <footer>
    <p>© Film Share</p>
  </footer>
</body>

</html>
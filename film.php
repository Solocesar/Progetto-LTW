<?php
session_start();
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

if(isset($_SESSION['id'],$_POST['rating'],$_POST['content'])){
  // se hanno inviato i dati della recensione inserirla nel database
  $toinsert = array(
      'likes'=>0,
      'userid'=>$_SESSION['id'],
      'rating'=>$_POST['rating'],
      'filmid'=>$_SESSION['film'], 
      'comment1'=>$_POST['content'],
      'nomeFilm' => $_SESSION['title'],
      'timestamp1'=>date("Y-m-d",time()));
  pg_insert($dbconn,'review',$toinsert);
}

?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <title>Film Share</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"></script>
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
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="profilout.php">Profilo</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
        <!-- <form class="d-flex">
          <input class="form-control me-2" id="searchText" type="search" placeholder="Titolo Film" aria-label="Search"
            required />
          <button class="btn btn-outline-success" id="search" type="submit"><i class="fas fa-search"></i></button> -->
        </form>
      </div>
    </div>
  </nav>

  <div id="container " class="container">
    <!-- Button trigger modal -->

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Scrivi una Recensione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form   method="POST"  name="reviews">
        
    
        <label for="customRange2" class="form-label">Voto(1-5)</label>
        <input name="rating" type="range" class="form-range" min="0" max="5" id="customRange2">
        <textarea class="form-control" rows="3" name="content" placeholder="Write your review here..." required></textarea>
        
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" >Submit Review</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <div id="movie"></div>
    
    <div id="containerTrailer"></div>
    <div class="reviews"></div>
    <script>
      const movieId = sessionStorage.getItem('movieId');
      fetch("reviews.php?movieId=" + movieId).then(response => response.text()).then(data => {
        document.querySelector(".reviews").innerHTML = data;

        document.querySelector(".write_review").onsubmit = event => {
		    event.preventDefault();
        console.log('nonfunziona');
	    	fetch("reviews.php?movieId="+ movieId, {
		  	method: 'POST',
			  body: new FormData(document.querySelector(".reviews .write_review form"))
	    	}).then(response => response.text()).then(data => {
		  	document.querySelector(".write_review").innerHTML = data;
		});
	};
});

      </script>
  </div>


  <!-- script per fare la ricerca -->

  <script src="js/apiTransaction.js"></script>
  <script src="js/film.js"></script>
  <script type="text/javascript">
  
    var data = <?php echo true ;?>;
    $(document).ready(function () {
    // if (!isNaN(data)){
    if ((true)){
      $(".recensioneModal").hide();
      console.log('sono qui');
    }});
</script>
  <script>

    getMovie()
    getTrailer()
  </script>
  <!-- Footer  -->
  <footer class="footer mt-auto">
    <p>© Film Share</p>
  </footer>
</body>

</html>
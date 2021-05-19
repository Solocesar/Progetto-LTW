<?php
session_start();
?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <title>Film Share</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/film.css">

  <!-- fav icon  da mettere-->
</head>

<script src="js/jquery-3.6.0.js"></script>

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
          <!-- <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li> -->
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
    <div id="movie"></div>
    <div id="containerTrailer"></div>
    <div id= "write_review" class="write_review"  style="display: none;">
    <form class="formReview" >
        <input name="name" type="text" placeholder="Your Name" required>
        <input name="rating" type="number" min="1" max="10" placeholder="Rating (1-10)" required>
        <textarea name="content" placeholder="Write your review here..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
</div>
    <div class="reviews"></div>
    <script>
      const movieId = sessionStorage.getItem('movieId');
      fetch("reviews.php?movieId=" + movieId).then(response => response.text()).then(data => {
        document.querySelector(".reviews").innerHTML = data;
      });
      </script>
  </div>


  <!-- script per fare la ricerca -->

  <script src="js/apiTransaction.js"></script>
  <script src="js/film.js"></script>
  <script>
    // const id 
  </script>
  <script>

    getMovie()
    getTrailer()
  </script>
  <!-- Footer  -->
  <footer class="footer mt-auto">
    <p>Â© Film Share</p>
  </footer>
</body>

</html>
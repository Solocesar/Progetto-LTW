
<?php
session_start();?>
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

  <!-- fav icon  da mettere-->
</head>

<body>
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

          <!-- <li class="nav-item"><a class="nav-link" href="profilout.php">Profilo</a></li> -->
          <?php if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ echo ('       
           <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="homeRedirect.php">Profilo</a></li>
        <li class="nav-item"><a class="nav-link" href="impostazioni.php">Impostazioni</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li> ');}
                      else { echo ('<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>');}
          
          ?>
          
          <!-- <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li> -->
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" id="searchText" type="search" placeholder="Titolo Film" aria-label="Search" required />
          <button class="btn btn-outline-success" id="search" type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>
  </nav>
  

  <!-- Contenitore per la ricerca che averra dinamicamente -->
<div class="container">
  <div id=ContenitoreFilm class="slider"></div>
  <div id=popularMovies class="slider"></div>

</div>
  <!-- librerie -->


  <!-- script per fare la ricerca -->
  <script src="js/apiTransaction.js"></script>
  <script src="js/ricerca.js"></script>


  <!-- Footer  -->
  <footer>
    <p>© Film Share</p>
  </footer>
</body>

</html>
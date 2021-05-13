<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

    if (isset($_SESSION['id'])) {
        echo $_SESSION['id'];
        var_dump($_SESSION);


    } else {

        echo "Not logged in HTML and code here";
    }

?>


<html>
    <head>
    <script src="https://kit.fontawesome.com/6d65c527da.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
        <link rel="stylesheet" type="text/css" href="css/profilout.css">
        <script src="js/jquery-3.6.0.js"></script>
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

            <!--Header del profilo-->
            <header class="showcase">
                <?php
                    $queryn= pg_query($dbconn, "SELECT image FROM user1 WHERE email= '".$_SESSION['email']."'");
                    $image= pg_fetch_row($queryn);
                    echo '<img src="' . $image[0] . '"/>';
                ?>
                <?php
                    $queryn= pg_query($dbconn, "SELECT nickname FROM user1 WHERE email= '".$_SESSION['email']."'");
                    $datas= pg_fetch_row($queryn);
                    echo '<h1 class="h1">'. $datas[0] .'</h1>';

                ?>
                <?php
                    $queryn= pg_query($dbconn, "SELECT bio FROM user1 WHERE email= '".$_SESSION['email']."'");
                    $datas= pg_fetch_row($queryn);
                    echo '<p class="title">'. $datas[0] .'</p>';

                ?>
                
                
            </header>

            <!--Linea Separazione-->

            <hr class="linea-sep" color="black"></hr>

            <!--Film recensiti-->

            <main id="main"></main>
            
        </div>
           
        <script src="js/paginaFilm.js"></script>
    </body>
</html>
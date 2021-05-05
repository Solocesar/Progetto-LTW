<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

    if (isset($_SESSION['id'])) {
        echo $_SESSION['id'];


    } else {

        echo "Not logged in HTML and code here";
    }

?>


<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/profilout.css">
    </head>
    <body> 

        <!--Nav Bar per navigare-->
        <div class="container">
            <nav class="main-nav">
                <ul class="main-menu">
                    <li><a href="index.html">Scrivi una recensione</a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="http://localhost/Progetto-LTW/impostazioni.php">Impostazioni profilo</a></li>
                    <li><a href="logout.php">Logout</a></li>

                </ul>

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
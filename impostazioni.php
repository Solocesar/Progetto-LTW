<?php
    session_start();
    $dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
    if (isset($_SESSION['id'])) {
        if(isset($_POST['submit2'])&&!empty($_POST['submit2'])){
            if (isset($_POST['email2'])&&!empty($_POST['email2'])){
                $query= "SELECT email FROM user1";
                $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
                $emails= array();
                while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                    foreach( $line as $col_value) {
                        array_push($emails,  $col_value);
                    }
                }
            
                if(in_array($_POST['email2'],$emails)) {
                    echo "email già presa";
                }else{
                    $sql = "UPDATE user1 SET email = '".$_POST['email2']."' WHERE id='".$_SESSION['id']."'" ;
                    $ret = pg_query($dbconn, $sql);
                    $_SESSION['email'] = $_POST['email2'];
                }
            } 

            if (isset($_POST['nome2'])&&!empty($_POST['nome2'])){
                $query= "SELECT nickname FROM user1";
                $result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
                $emails= array();
                while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
                    foreach( $line as $col_value) {
                        array_push($emails,  $col_value);
                    }
                }
            
                if(in_array($_POST['nome2'],$emails)) {
                    echo "nickname già preso";
                }else{
                    $sql = "UPDATE user1 SET nickname = '".$_POST['nome2']."' WHERE id='".$_SESSION['id']."'" ;
                    $ret = pg_query($dbconn, $sql);
                }
            } 


            if (isset($_POST['photo2'])&&!empty($_POST['photo2'])){
                $sql = "UPDATE user1 SET image = '".$_POST['photo2']."' WHERE id='".$_SESSION['id']."'" ;
                $ret = pg_query($dbconn, $sql);
                
            } 

            if (isset($_POST['textarea'])&&!empty($_POST['textarea'])){
                $sql = "UPDATE user1 SET bio = '".$_POST['textarea']."' WHERE id='".$_SESSION['id']."'" ;
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

        <link rel="stylesheet" type="text/css" href="css/impostazioni.css">
    </head>
    <body>
        <!--Form action-->
        <form action="" method="post" name="registr">
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

            <div id="showcase" class="container">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-lg-4">
                            <div class="vertical-center">
                                <div class="list-group">
                                    <?php
                                        $queryn= pg_query($dbconn, "SELECT nickname FROM user1 WHERE id= '".$_SESSION['id']."'");
                                        $nickname= pg_fetch_row($queryn);
                                        echo '
                                        <li class="list-group-item"><h5>Nickname:</h5> <input type="text" name= "nome2" size="15" maxlength= "15" placeholder='. $nickname[0] .' ></li>';
                                    ?>
                                    <?php
                                        $queryn= pg_query($dbconn, "SELECT email FROM user1 WHERE id= '".$_SESSION['id']."'");
                                        $email= pg_fetch_row($queryn);
                                        echo '
                                        <li class="list-group-item"><h5>Email:</h5><input type="email" name= "email2" size="25"  placeholder=' . $email[0] . ' > </li>';
                                    ?>
                                    <li class="list-group-item"><h5>Password:</h5> <input type="password" name="password2" size="25" placeholder="inserisci una nuova password"> </li>
                                    <li class="list-group-item"><h5>Biografia:</h5> <textarea class="textarea" name="textarea" rows="4" cols="50" maxlength="500" placeholder="Inserisci una bio"></textarea> </li>
                                    <li class="list-group-item"><h5>Foto: </h5><input type="url" name= "photo2" size="25" placeholder="inserire l'url di un'immagine" > </li>
    
                                    
                                </div>
                                <div class="d-flex justify-content-center">

                                    <button id="bottone" class="btn btn-primary" type="submit" name="submit2" value="Apply changes"> Applica i cambiamenti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </body>

</html>
<?php

session_start();
//connesione database
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if (isset($_SESSION['film'])){


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
        exit('Your review has been submitted!');
    }
    $movieid =  $_SESSION['film'];
    $reviews = pg_query($dbconn,"SELECT * FROM review WHERE filmid =$movieid ORDER BY timestamp1 DESC");
    $reviews = pg_fetch_all($reviews);

}
else {
  exit('Please provide the movie ID.');

}


?>
<!-- TODO: Completare css per le recensioni sotto i film e risolvere molteplici recensioni da parte dello stesso utente  -->
<div class="row justify-content-center align-self-center">
<?php foreach ($reviews as $review): ?>

    <?php 
            $userid = $review['userid'];
            $queryn= pg_query($dbconn, "SELECT * FROM user1 WHERE id= $userid");
            $datas= pg_fetch_row($queryn);
            $queryLike= pg_query($dbconn, "SELECT * FROM like1 WHERE idreview='".$review['id']."'");
            $likes= pg_num_rows($queryLike);
    ?>

    <div class="card" style="width: 45rem;">
        <div class="card-body">
        <div id="inte" class="row"> 
            <div class="col-md-auto">
                    <img  class="avatar" src= <?php echo ($datas[5]); ?> >
            </div>
            <div class="col-6">
                <form action="profilout.php" method="post" name="utentenickname">
                    <button value=<?= $review['userid']?> class= "nomeUtente btn btn-info"  type="submit" name="nickUser"><strong><?php echo ($datas[2]); ?></strong></button>
                </form>
            </div>
            <div class="col">
                <p class="timestamp"><?=$review['timestamp1']?></p>
            </div>
        </div>  
    <hr id="hr" style="width: 100%;margin: auto;">
    <div class="card-body">
        <p class="card-text"><?php echo $review['comment1']?></p>
        <div class="stars">
            <span class="rating1"><?=str_repeat("&#9733;", $review['rating'])?><?=str_repeat("&#9734;", 10-$review['rating'])?></span>
        </div>
        <div class="row">
            <div class="d-flex flex-row-reverse">
                <div class="col-md-auto">
                    <form action="film.php" method="post" name="likePost">
                        <button class= "likeB" value=<?php echo $review['id']?>  type="submit" name="likeB"><i class="far fa-thumbs-up" aria-hidden="true"></i></button>
                    </form>
                </div>
                <div class="col-md-auto">
                    <p><?php echo $likes?></p>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- // prende nickname utente della recensione in questione -->


<?php endforeach ?>
</div>
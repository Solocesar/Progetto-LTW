<?php

session_start();

echo session_id();
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';


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
<div class="write_review" id="write_review" style="display: none;">

</div>

<!-- TODO: Completare css per le recensioni sotto i film e risolvere molteplici recensioni da parte dello stesso utente  -->
<?php foreach ($reviews as $review): ?>
<div class="review">
    <!-- <button  type="button" class="name btn btn-link"> -->
    <!-- // prende nickname utente della recensione in questione -->
    <form action="profilout.php" method="post" name="utentenickname">
    <?php 
            $userid = $review['userid'];
            $queryn= pg_query($dbconn, "SELECT nickname FROM user1 WHERE id= $userid");
            $datas= pg_fetch_row($queryn);
            ?>
       <button value=<?= $review['userid']?> class= "nomeUtente"  type="submit" name="nickUser">
        <?php echo ($datas[0]); ?>
        </button>
    </form>
    
    </button>
    <div>
        <span class="rating"><?=str_repeat('&#9733;', $review['rating'])?></span>
        <span class="date"><?=htmlspecialchars($review['timestamp1'], ENT_QUOTES)?></span>
        <span class="nomeFilm" data-id='2100'><?=htmlspecialchars($review['nomeFilm'], ENT_QUOTES)?></span>
        <button value=<?= $review['nomeFilm']?> class= "nomeUtente btn btn-primary"  type="submit" name="nickUser"><?=htmlspecialchars($review['nomeFilm'], ENT_QUOTES)?></button>
    </div>
    <p class="testo"><?=htmlspecialchars($review['comment1'], ENT_QUOTES)?></p>
</div>
<?php endforeach ?>

<?php

session_start();

// echo session_id();
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


//connesione database
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if (isset($_SESSION['film'])){
    // if()
    $movieid =  $_SESSION['film'];
    $reviews = pg_query($dbconn,"SELECT * FROM review WHERE filmid =$movieid ORDER BY timestamp1 DESC");
    $reviews = pg_fetch_all($reviews);
    // $reviews = $result->fetchAll();
}
else {
  exit('Please provide the movie ID.');

}
?>

<?php foreach ($reviews as $review): ?>
<div class="review">
    <h3 class="name"><?=htmlspecialchars($review['userid'], ENT_QUOTES)?></h3>
    <div>
        <span class="rating"><?=str_repeat('&#9733;', $review['rating'])?></span>
    </div>
    <p class="testo"><?=htmlspecialchars($review['comment1'], ENT_QUOTES)?></p>
</div>
<?php endforeach ?>
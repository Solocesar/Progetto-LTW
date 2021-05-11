<?php
//connesione database
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");
if (isset($_GET['movieId'])){

    //tutte le recensioni con movieID ordinate per data
    //statement
    // $stmt= pg_prepare($dbconn,'query1','SELECT * FROM reviews WHERE movieid = 460465 ORDER BY data DESC');
    // $stmt=pg_execute($dbconn,'query1');
    // $reviews =pg_fetch_all($stmt);
    // $var= $_GET['movieId'];
    $reviews = pg_query($dbconn,'SELECT * FROM reviews WHERE movieId = 460465 ORDER BY data DESC');
    // $result = pg_query($dbconn,'SELECT * FROM reviews WHERE movieId = $var ORDER BY submit_date DESC');
    $reviews = pg_fetch_all($reviews);
    // $reviews = $result->fetchAll();
}
else {
  exit('Please provide the movie ID.');

}
?>

<a href="#" class="write_review_btn">Write Review</a>
<div class="write_review">
    <form>
        <input name="name" type="text" placeholder="Your Name" required>
        <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your review here..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
</div>

<?php foreach ($reviews as $review): ?>
<div class="review">
    <h3 class="name"><?=htmlspecialchars($review['email'], ENT_QUOTES)?></h3>
    <div>
        <span class="rating"><?=str_repeat('&#9733;', $review['voto'])?></span>
    </div>
    <p class="testo"><?=htmlspecialchars($review['text'], ENT_QUOTES)?></p>
</div>
<?php endforeach ?>

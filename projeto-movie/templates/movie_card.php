<?php

if (empty($movie->image)) {
    $movie->image = "movie.png";
}

?>

<div class="movie-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>assets/movies/<?= $movie->image ?>')"></div>
    <div class="atributes">
        <p class="card-rating"><i class="fas fa-star"></i> <span class="rating">9</span></p>
        <h5 class="card-title"><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a></h5>
        <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="btn rate-btn">Rate</a>
        <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="btn card-btn"><i class="fas fa-eye"></i></a>
    </div>
</div>
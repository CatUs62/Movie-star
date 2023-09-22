<?php

require_once("templates/header.php");
require_once("dao/MovieDAO.php");

# DAO movies
$movieDao = new MovieDAO($conn, $BASE_URL);

$latestMovies = $movieDao->getLatestMovies();

$actionMovies = $movieDao->getMoviesByCategory("Ação");

$terrorMovies = $movieDao->getMoviesByCategory("Terror");

?>

<div id="main-container">
    <h2 class="section-title">New movies</h2>
    <p class="section-description">Look review</p>
    <div class="movies-container">
        <?php foreach ($latestMovies as $movie) : ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($latestMovies)  === 0) : ?>
            <p class="empty-list">No movie registered.</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Action</h2>
    <p class="section-description">Best actions movies</p>
    <div class="movies-container">
        <?php foreach ($actionMovies as $movie) : ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($actionMovies)  === 0) : ?>
            <p class="empty-list">No movie action registered.</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Terror</h2>
    <p class="section-description">Best terror movies</p>
    <div class="movies-container">
        <?php foreach ($terrorMovies as $movie) : ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($terrorMovies)  === 0) : ?>
            <p class="empty-list">No movie terror registered.</p>
        <?php endif; ?>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
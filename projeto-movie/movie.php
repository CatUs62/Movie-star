<?php

require_once("templates/header.php");
require_once("dao/MovieDAO.php");
require_once("models/Movie.php");
require_once("dao/ReviewDAO.php");

$id = filter_input(INPUT_GET, "id");

$movie;

$movieDao = new MovieDAO($conn, $BASE_URL);
$reviewDao = new ReviewDao($conn, $BASE_URL);

if (empty($id)) {
    $message->setMessage("The film was not found.", "error", "index.php");
} else {
    $movie = $movieDao->findById($id);

    if (!$movie) {
        $message->setMessage("The film was not found.", "error", "index.php");
    }
}

# Check image movie
if ($movie->image == "") {
    $movie->image = "movie.png";
}

# Check movie User
$userOwnsMovie = false;

if (!empty($userData)) {
    if ($userData->id === $movie->users_id) {
        $userOwnsMovie = true;
    }
}

$movieReviews = $reviewDao->getMoviesReview($movie->id);

$alreadyReviewed = false;

# Reviews movies
?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Time: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i>9</span>
            </p>
            <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="acceletometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p class="movie-description"><?= $movie->description ?></p>
        </div>
        <div>
            <!-- <div class="image-container" style="background-image: url('<?= $BASE_URL ?>assets/movies/<?= $movie->image ?>');"></div> -->
        </div>
        <div id="reviews-container">
            <h3 id="reviews-title">Reviews:</h3>
            <?php if (!empty($userData) && !$userOwnsMovie && !$alreadyReviewed) : ?>
                <div id="review-form-container">
                    <h4>Submit your review:</h4>
                    <p class="page-description">Fill in the form with a note and comment about the film.</p>
                    <form action="<?= $BASE_URL ?>review_process.php" method="POST">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
                        <div>
                            <label for="rating">Rating movie:</label>
                            <select name="rating" id="rating">
                                <option value="">Select</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div>
                            <label for="review">Your review:</label>
                            <textarea name="review" id="review" cols="50" rows="10" placeholder="Did you like the movie?"></textarea>
                        </div>
                        <input type="submit" value="Go" class="card-btn">
                    </form>
                </div>
            <?php endif; ?>
            <!-- COMMENT -->
            <?php foreach ($movieReviews as $review) : ?>
                <?php require("templates/user_review.php"); ?>
            <?php endforeach; ?>
            <?php if (count($movieReviews) == 0) : ?>
                <p class="empty-list">Not comments for movie.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
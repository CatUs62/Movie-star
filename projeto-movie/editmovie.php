<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

$movieDao = new MovieDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, "id");

if (empty($id)) {
    $message->setMessage("The film was not found.", "error", "index.php");
} else {
    $movie = $movieDao->findById($id);

    if (!$movie) {
        $message->setMessage("The film was not.", "error", "index.php");
    }
}

if ($movie->image == "") {
    $movie->image = "movie.png";
}

?>

<div id="main-container">
    <div class="row-edit-movie">
        <div class="row">
            <div>
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Alter data movie:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div>
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" placeholder="Enter movie title">
                    </div>
                    <div>
                        <label for="image">Photo:</label>
                        <input type="file" name="image" id="btn-image">
                    </div>
                    <div>
                        <label for="length">Time:</label>
                        <input type="text" name="length" id="length" placeholder="Duration">
                    </div>
                    <div class="select">
                        <label for="category">Category:</label>
                        <select name="category" id="category">
                            <option value="">Select</option>
                            <option value="Ação" <?= $movie->category === "Acão" ? "Selected" : "" ?>>Action</option>
                            <option value="Aventura" <?= $movie->category === "Aventura" ? "Selected" : "" ?>>Adventure</option>
                            <option value="Anime" <?= $movie->category === "Anime" ? "Selected" : "" ?>>Anime</option>
                            <option value="Drama" <?= $movie->category === "Drama" ? "Selected" : "" ?>>Drama</option>
                            <option value="Romance" <?= $movie->category === "Romance" ? "Selected" : "" ?>>Romance</option>
                            <option value="Terror" <?= $movie->category === "Terror" ? "Selected" : "" ?>>Terror</option>
                        </select>
                    </div>
                    <div class="trailer">
                        <label for="trailer">Trailer:</label>
                        <input type="text" name="trailer" id="trailer" placeholder="Trailer Movie" value="<?= $movie->trailer ?>">
                    </div>
                    <div>
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" cols="50" rows="10" placeholder="Description Movie"><?= $movie->description ?></textarea>
                    </div>
                    <input type="submit" value="Update movie" id="card-btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
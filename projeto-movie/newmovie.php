<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

?>

<div id="main-container">
    <div class="new-movie-container">
        <h1 class="page-title">Add Movie</h1>
        <p class="page-description">Add your review about the movie:</p>
        <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
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
                    <option value="Ação">Action</option>
                    <option value="Aventura">Adventure</option>
                    <option value="Anime">Anime</option>
                    <option value="Drama">Drama</option>
                    <option value="Romance">Romance</option>
                    <option value="Terror">Terror</option>
                </select>
            </div>
            <div class="trailer">
                <label for="trailer">Trailer:</label>
                <input type="text" name="trailer" id="trailer" placeholder="Trailer Movie">
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description" cols="50" rows="10" placeholder="Description Movie"></textarea>
            </div>
            <input type="submit" value="Add movie" id="card-btn">
        </form>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
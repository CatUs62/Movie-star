<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, "id");

if (empty($id)) {
    if (!empty($userData)) {
        $id = $userData->id;
    } else {
        $message->setMessage("User not register. 🚨", "error", "index.php");
    }
} else {
    $userData = $userDao->findById($id);

    if (!$userData) {
        $message->setMessage("User not register. 🚨", "error", "index.php");
    }
}

$fullName = $user->getFullName($userData);

if ($userData->image == "") {
    $userData->image = "profile.png";
}

$userMovies = $movieDao->getMoviesByUserId($id);

?>

<div id="main-container">
    <div>
        <div class="row profile-container">
            <div class="about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>assets/users/<?= $userData->image ?>');"></div>
                <h3 class="about-title">About:</h3>
                <?php if (!empty($userData->bio)) : ?>
                    <p class="profile-description"><?= $userData->bio ?></p>
                <?php else : ?>
                    <p class="profile-description">User dont Bio.</p>
                <?php endif; ?>
            </div>
            <div class="added-movies-container">
                <h3>Movies:</h3>
                <div class="movies-container">
                    <?php foreach ($userMovies as $movie) : ?>
                        <?php require("templates/movie_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if (count($userMovies) === 0) : ?>
                        <p class="empty-list">User dont movies.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");
require_once("dao/MovieDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

$userMovies = $movieDao->getMoviesByUserId($userData->id);

?>

<div id="main-container">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Add ou att informations movies.</p>
    <div id="add-movie-container">
        <a href="<?= $BASE_URL ?>newmovie.php" id="card-btn"><i class="fas fa-plus"></i>Add movie</a>
    </div>
    <div id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Rating</th>
                <th scope="col" class="actions-column">Actions</th>
            </thead>
            <tbody>
                <?php foreach ($userMovies as $movie) : ?>
                    <tr>
                        <td scope="row"><?= $movie->id ?></td>
                        <td><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="table-movie-title"><?= $movie->title ?></a></td>
                        <td><i class="fas fa-star"></i>9</td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>editmovie.php?id=<?= $movie->id ?>" class="edit-btn">
                                <i class="fas fa-edit"></i>Edit
                            </a>
                            <form action="<?= $BASE_URL ?>movie_process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $movie->id ?>">
                                <button type="submit" class="delete-btn"><i class="fas fa-times"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
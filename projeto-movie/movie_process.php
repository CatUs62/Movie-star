<?php

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/MovieDAO.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

$userData = $userDao->verifyToken();

if ($type === "create") {
    # Data inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST, "length");

    $movie = new Movie();

    # Validation min data
    if (!empty($title) && !empty($description) && !empty($category)) {
        $movie->title = $title;
        $movie->description = $description;
        $movie->trailer = $trailer;
        $movie->category = $category;
        $movie->length = $length;
        $movie->users_id = $userData->id;

        # Upload image
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            # Ckeck type image
            if (in_array($image["type"], $imageTypes)) {
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./assets/movies/" . $imageName, 100);

                $movie->image = $imageName;
            } else {
                $message->setMessage("invalid type.", "error", "back");
            }
        }

        $movieDao->create($movie);
    } else {
        $message->setMessage("You need to add at least: Title, description and category.", "error", "back");
    }
} else if ($type === "delete") {
    $id = filter_input(INPUT_POST, "id");

    $movie = $movieDao->findById($id);

    if ($movie) {
        if ($movie->users_id === $userData->id) {
            $movieDao->destroy($movie->id);
        } else {
            $message->setMessage("Invalid information.", "error", "index.php");
        }
    } else {
        $message->setMessage("Invalid information.", "error", "index.php");
    }
} else if ($type === "update") {
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST, "length");
    $id = filter_input(INPUT_POST, "id");

    $movieData = $movieDao->findById($id);

    if ($movieData) {
        if ($movieData->users_id === $userData->id) {

            if (!empty($title) && !empty($description) && !empty($category)) {
                # Edit movie
                $movieData->title = $title;
                $movieData->description = $description;
                $movieData->trailer = $trailer;
                $movieData->category = $category;
                $movieData->length = $length;

                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];

                    # Ckeck type image
                    if (in_array($image["type"], $imageTypes)) {
                        if (in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        $movie = new Movie();

                        $imageName = $movie->imageGenerateName();

                        imagejpeg($imageFile, "./assets/movies/" . $imageName, 100);

                        $movie->image = $imageName;
                    } else {
                        $message->setMessage("invalid type.", "error", "back");
                    }
                }

                $movieDao->update($movieData);
            } else {
                $message->setMessage("You need to add at least: Title, description and category.", "error", "back");
            }
        } else {
            $message->setMessage("Information invalid.", "error", "back");
        }
    } else {
        $message->setMessage("Information invalid.", "error", "back");
    }
} else {
    $message->setMessage("Information invalid.", "error", "back");
}

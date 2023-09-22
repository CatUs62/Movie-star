<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flashMessage = $message->getMessage();

if (!empty($flashMessage["msg"])) {
    $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONTE AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS-->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
    <!-- ICON FOR SITE-->
    <link rel="icon" href="./assets/logo.png">
    <title>Welcome</title>
</head>

<body>
    <header>
        <nav id="main-navbar">
            <a href="index.php"><img src="<?= $BASE_URL ?>assets/logo.png" alt="logo for site"></a>
            <h1 id="moviestar-title">Movie</h1>
            <button type="button" id="menu"><i class="fas fa-bars"></i></button>
            <form action="" id="search-form" method="GET">
                <input type="text" name="q" id="search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div id="nav-bar">
                <ul>
                    <?php if ($userData) : ?>
                        <li class="nav-item">
                            <a href="<?= $BASE_URL ?>newmovie.php"><i class="far fa-plus-square"></i>Add Movie</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $BASE_URL ?>dashboard.php">My Movie</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $BASE_URL ?>editprofile.php"><i class="far fa-user"></i><?= $userData->name ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $BASE_URL ?>logout.php">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="<?= $BASE_URL ?>auth.php">Login / Sign</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <?php if (!empty($flashMessage["msg"])) : ?>
        <div class="msg-container">
            <p class="msg <?= $flashMessage["type"] ?>"><?= $flashMessage["msg"] ?></p>
        </div>
    <?php endif; ?>
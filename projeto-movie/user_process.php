<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

if ($type === "update") {
    # Att user
    $userData = $userDao->verifyToken();

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    $user = new User();

    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    $userDao->update($userData);

    # Upload image
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        # Checking type image
        if (in_array($image["type"], $imageTypes)) {
            # Checking type JPG
            if (in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            } else {
                # Checking type PNG
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }
            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./assets/users/" . $imageName, 100);

            $userData->image = $imageName;
        } else {
            $message->setMessage("invalid type.", "error", "back");
        }

        $userDao->update($userData);
    }
} else if ($type === "changepassword") {
    # Att password
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    $userData = $userDao->verifyToken();
    $id = $userData->id;

    if ($password == $confirmpassword) {
        $user = new User();

        $finalPassword = $user->generatePassword($password);

        $user->password = $finalPassword;
        $user->id = $id;

        $userDao->changePassword($user);
    } else {
        $message->setMessage("Passwords are not the same. 🚨", "error", "back");
    }
} else {
    $message->setMessage("invalid information.", "error", "index.php");
}

<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

# Form type retrieva

$type = filter_input(INPUT_POST, "type");

# Checking type form

if ($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    # Checking minimum data

    if ($name && $lastname && $email && $password) {

        # Checking password
        if ($password === $confirmpassword) {

            # Checking email
            if ($userDao->findByEmail($email) === false) {
                $user = new User();

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {
                $message->setMessage("User already registered.", "error", "back");
            }
        } else {
            $message->setMessage("The passwords are not the same.", "error", "back");
        }
    } else {
        $message->setMessage("Please, fill in all fields.", "error", "back");
    }
} else if ($type === "login") {
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    # Checking auth user

    if ($userDao->authenticateUser($email, $password)) {
        $message->setMessage("Welcome 👏.", "success", "editprofile.php");
    } else {
        $message->setMessage("Invalid email/password!", "error", "back");
    }
} else {
    $message->setMessage("Invalid information.", "error", "back");
}

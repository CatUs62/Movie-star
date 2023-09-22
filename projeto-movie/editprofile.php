<?php

require_once("globals.php");
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
$fullName = $user->getFullName($userData);

if ($userData->image == "") {
    $userData->image = "profile.png";
}
?>


<div>
    <div class="edit-profile-page">
        <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div id="edit-container">
                <div>
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">Change your details below:</p>
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Ex: João" value="<?= $userData->name ?>">
                    </div>
                    <div>
                        <label for="lastname">Lastname:</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Ex: Araújo" value="<?= $userData->lastname ?>">
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" class="disabled" readonly id="email" name="email" placeholder="Ex: example@gmail.com" value="<?= $userData->email ?>">
                    </div>
                    <input type="submit" value="Alterar" id="card-btn">
                </div>
                <div class="edit-container-image">
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>assets/users/<?= $userData->image ?>');"></div>
                    <div>
                        <label for="image">Photo:</label>
                        <input type="file" name="image" id="btn-image">
                    </div>
                    <div>
                        <label for="bio">Bio:</label>
                        <textarea name="bio" id="bio" rows="10" cols="50" placeholder="Tell me a little about you"><?= $userData->bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>
        <div id="change-password-container">
            <div id="edit-container">
                <h2>Change password:</h2>
                <p class="page-description">Enter the new password and confirm:</p>
                <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                    <input type="hidden" name="type" value="changepassword">
                    <input type="hidden" name="id" value="<?= $userData->id ?>">
                    <div>
                        <label for="password">New password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password">
                    </div>
                    <div>
                        <label for="confirmpassword">Confirm new password:</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password">
                    </div>
                    <input type="submit" value="Alterar senha" id="card-btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
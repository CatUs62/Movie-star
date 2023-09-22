<?php

require_once("templates/header.php");
require_once("globals.php");

?>

<div id="main-container">
    <div>
        <div class="row" id="auth-row">
            <div class="login-container">
                <h2>Login</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="login">
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" placeholder="Ex: example@gmail.com" id="email" name="email">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <input type="submit" id="card-btn" value="Login">
                </form>
            </div>
            <div class="register-container">
                <h2>Sign</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="register">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div>
                        <label for="lastname">Last name:</label>
                        <input type="text" id="lastname" name="lastname">
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" placeholder="Ex: example@gmail.com" id="email" name="email">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div>
                        <label for="confirmpassword">Confirm password:</label>
                        <input type="password" id="confirmpassword" name="confirmpassword">
                    </div>
                    <input type="submit" value="Register" id="card-btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php");

?>
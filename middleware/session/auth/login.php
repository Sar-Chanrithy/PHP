<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<main>
    <form action="../controller/authController.php" method="post" >
        <h1>Login Form</h1>
        <p><?= $_SESSION['success'] ?? '' ?></p>
        <?php unset($_SESSION['success']); ?>
        <input type="email" name="email" placeholder="email" > <br>
        <input type="password" name="pwd" placeholder="password" > <br>

        <button type="submit" name="login"  >Login</button>
    </form>
    <a href="register.php">register</a>
</main>
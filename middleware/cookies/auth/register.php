<main>
    <form action="../controller/authController.php" method="post" >
        <h1>Login Form</h1>
        <p><?= $_COOKIE['success'] ?? '' ?></p>
        <input type="text" name="name" placeholder="username" required> <br>
        <input type="email" name="email" placeholder="email" > <br>
        <input type="password" name="pwd" placeholder="password" > <br>
        <select name="role">
            <option value="admin">admin</option>
            <option value="client">client</option>
        </select>

        <button type="submit" name="register"  >register</button>
    </form>
    <a href="login.php">Login</a>
</main>
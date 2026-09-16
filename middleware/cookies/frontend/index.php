<?php
    require_once "../middleware/authMiddleware.php";
    requireLogin();
    requireAdmin();
?>
<main>
    <h1>Cliend dasboard</h1>
    <a href="../auth/logout.php">Logout</a>
</main>
<?php
    require_once "../middleware/authMiddleware.php";
    requireLogin();
    requireClient();
?>
<main>
    <h1>Client dashboard</h1>
    <a href="../auth/logout.php">Logout</a>
</main>
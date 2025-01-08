<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userRole = $_SESSION['user_role'] ?? 'public'; ?>
<footer>
    <p>&copy; 2023 Your Company</p>
    <?php if ($userRole == 'admin') { ?>
        <p>Admin Dashboard | Settings | Logout</p>
    <?php } elseif ($userRole == 'member') { ?>
        <p>Member Profile | Settings | Logout</p>
    <?php } else { ?>
        <p>Home | About Us | Contact</p>    <?php } ?>
</footer>
</body>
</html>
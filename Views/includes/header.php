<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userRole = $_SESSION['user_role'] ?? 'public';
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Header</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body>
<?php if ($userRole == 'admin') { ?>
    <nav class="bg-gray-800 p-4">
        <ul class="flex list-none">
            <li class="mr-4">
                <a href="/admin/dashboard" class="text-gray-100 hover:text-white font-bold">Admin Dashboard</a>
            </li>
            <li class="mr-4">
                <a href="/admin/settings" class="text-gray-100 hover:text-white font-bold">Settings</a>
            </li>
            <li>
                <a href="/logout" class="text-gray-100 hover:text-white font-bold">Logout</a>
            </li>
        </ul>
    </nav>
<?php } elseif ($userRole == 'member') { ?>
    <nav class="bg-gray-800 p-4">
        <ul class="flex list-none">
            <li class="mr-4">
                <a href="/member/profile" class="text-gray-100 hover:text-white font-bold">Member Profile</a>
            </li>
            <li class="mr-4">
                <a href="/member/settings" class="text-gray-100 hover:text-white font-bold">Settings</a>
            </li>
            <li>
                <a href="/logout" class="text-gray-100 hover:text-white font-bold">Logout</a>
            </li>
        </ul>
    </nav>
<?php } else { ?>
    <nav class="bg-gray-800 p-4">
        <ul class="flex list-none">
            <li class="mr-4">
                <a href="/home" class="text-gray-100 hover:text-white font-bold">Home</a>
            </li>
            <li class="mr-4">
                <a href="/about" class="text-gray-100 hover:text-white font-bold">About Us</a>
            </li>
            <li>
                <a href="/contact" class="text-gray-100 hover:text-white font-bold">Contact</a>
            </li>
        </ul>
    </nav>
<?php } ?>
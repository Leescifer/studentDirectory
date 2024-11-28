<?php
require_once 'auth.php';
require_once 'admin.php';

if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$schedule_id = $_GET['id'] ?? null;
if (!$schedule_id) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    delete_class_schedule($schedule_id);
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Class Schedule</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-ful l">
        <!-- Header Section -->
        <h1 class="text-3xl font-semibold text-center text-neutral-600 mb-6">Delete Class Schedule</h1>
        
        <p class="text-gray-600 text-lg mb-6 text-center">
            Are you sure you want to delete this class schedule? This action cannot be undone.
        </p>

        <!-- Form Section -->
        <form method="post">
            <div class="flex justify-center space-x-4">
                <input type="submit" value="Confirm Delete" 
                       class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300 cursor-pointer">

                <a href="dashboard.php" 
                   class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-300">
                   Cancel and Return to Dashboard
                </a>
            </div>
        </form>
    </div>


    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>

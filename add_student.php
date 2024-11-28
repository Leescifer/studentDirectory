<?php
require_once 'auth.php';
require_once 'admin.php';

if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    add_student($username, $password, $first_name, $last_name, $email);
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>

<body class="bg-white font-sans flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-2xl border border-neutral-400 bg-white rounded-lg shadow-lg p-6 space-y-6 animate__animated animate__fadeIn animate__delay-1s">
        <h1 class="text-3xl font-semibold text-center text-black">Add Student</h1>

        <!-- Form -->
        <form method="post" class="space-y-4">
            <div class="flex flex-col">
                <label for="username" class="text-sm font-medium text-black-600">Username</label>
                <input type="text" id="username" name="username" required class="mt-2 p-3 border border-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700 transition duration-300" placeholder="Enter username">
            </div>

            <div class="flex flex-col">
                <label for="password" class="text-sm font-medium text-black-600">Password</label>
                <input type="password" id="password" name="password" required class="mt-2 p-3 border border-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700 transition duration-300" placeholder="Enter password">
            </div>

            <div class="flex flex-col">
                <label for="first_name" class="text-sm font-medium text-black-600">First Name</label>
                <input type="text" id="first_name" name="first_name" required class="mt-2 p-3 border border-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700 transition duration-300" placeholder="Enter first name">
            </div>

            <div class="flex flex-col">
                <label for="last_name" class="text-sm font-medium text-black-600">Last Name</label>
                <input type="text" id="last_name" name="last_name" required class="mt-2 p-3 border border-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700 transition duration-300" placeholder="Enter last name">
            </div>

            <div class="flex flex-col">
                <label for="email" class="text-sm font-medium text-black-600">Email</label>
                <input type="email" id="email" name="email" required class="mt-2 p-3 border border-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700 transition duration-300" placeholder="Enter email">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="mt-4 py-3 px-6 text-black bg-neutral-500 border rounded-lg focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">
                    Add Student
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-neutral-600">
            <a href="dashboard.php" class="hover:underline">Back to Dashboard</a>
        </p>
    </div>


    <!-- Loading Screen -->
    <div id="loading-screen" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
        <div class="animate-pulse flex space-x-4">
            <div class="rounded-full bg-slate-700 h-10 w-10"></div>
            <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-slate-700 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                        <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-700 rounded"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="./js/loadingScreen.js"></script>

    <style>
        #loading-screen {
            display: none;
        }
    </style>
</body>

</html>
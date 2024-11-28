<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simulate processing time for demonstration
    sleep(2);

    if (login($username, $password)) {
        // Redirect to a different page based on user role
        if (is_student()) {
            header('Location: edit_profile.php');
        } elseif (is_admin()) {
            header('Location: dashboard.php');
        }
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

    <div id="login-container" class="w-full max-w-md p-8 bg-white border border-neutral-300 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-semibold text-center text-black mb-6">Login</h1>

        <!-- Display error message if credentials are invalid -->
        <?php if (isset($error)): ?>
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-center rounded-lg">
                <p><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" onsubmit="showLoadingScreen()">
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700">
                    <ion-icon name="person-outline"></ion-icon>Username:</label>
                <input type="text" id="username" name="username" required
                    class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700"><ion-icon name="lock-closed-outline"></ion-icon>Password:</label>
                <input type="password" id="password" name="password" required
                    class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
            </div>

            <div class="flex items-center justify-between mb-6">
                <input type="submit" value="Login"
                    class="w-full px-6 py-3 bg-neutral-700 text-white rounded-lg hover:bg-white hover:text-black border cursor-pointer border-neutral-700">
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Don't have an account? <a href="register.php" class="text-neutral-900 hover:text-neutral-800">Register here</a>.</p>
        </div>
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

    <script src="./js/loadingScreen.js"></script>

    <style>
        #loading-screen {
            display: none;
        }
    </style>

</body>

</html>
<?php
require_once 'auth.php'; // Include your auth.php file that has the register_user function

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // we will let the user choose a role (admin/student)

    // Register the user (use your function)
    if (register_user($username, $password, $role)) {
        header('Location: login.php');  // Redirect to login page 
        exit;
    } else {
        $error = "Failed to register. Username may already be taken.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white border border-neutral-300 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-semibold text-center text-black mb-6">Register</h1>

        <?php if (isset($error)): ?>
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-center rounded-lg">
                <p><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700"><ion-icon name="person-outline"></ion-icon>Username:</label>
                <input type="text" id="username" name="username" required
                    class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700"><ion-icon name="lock-closed-outline"></ion-icon>Password:</label>
                <input type="password" id="password" name="password" required
                    class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
            </div>

            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700"><ion-icon name="square-outline"></ion-icon>Role:</label>
                <select id="role" name="role" required
                    class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex items-center justify-between mb-6">
                <input type="submit" value="Register"
                    class="w-full px-6 py-3 bg-neutral-700 text-white rounded-lg hover:bg-white hover:text-black border border-neutral-700  cursor-pointer">
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account? <a href="login.php" class="text-neutral-900 hover:text-neutral-800">Login here</a>.</p>
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


    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./js/loadingScreen.js"></script>

    <style>
        #loading-screen {
            display: none;
        }
    </style>
</body>

</html>
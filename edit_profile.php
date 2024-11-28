<?php
require_once 'auth.php';
require_once 'student.php';

// Logout functionality
if (isset($_GET['logout'])) {
    session_start();
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header('Location: login.php'); // Redirect to login page
    exit;
}

if (!is_logged_in() || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$profile = get_student_profile($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    update_student_profile($user_id, $first_name, $last_name, $email);

    // Set a session variable to show a success alert
    $_SESSION['update_success'] = true;

    // Redirect to the same page after the update
    header('Location: edit_profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>

<body class="bg-white">

    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-lg mx-auto border border-neutral-500">
            <h1 class="text-3xl font-semibold text-center text-black mb-6">Edit Profile</h1>

            <!-- Success Alert -->
            <?php if (isset($_SESSION['update_success']) && $_SESSION['update_success']): ?>
                <div id="success-alert" class="p-4 mb-4 text-sm text-black bg-neutral-200 rounded-lg" role="alert">
                    Profile updated successfully!
                </div>
                <?php unset($_SESSION['update_success']); ?> 
            <?php endif; ?>

            <!-- Profile Form -->
            <form method="post" class="space-y-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-black">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($profile['first_name']); ?>" required class="mt-1 block w-full px-4 py-2 border border-neutral-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-black">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($profile['last_name']); ?>" required class="mt-1 block w-full px-4 py-2 border border-neutral-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-black">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required class="mt-1 block w-full px-4 py-2 border border-neutral-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <input type="submit" value="Update Profile" class="px-6 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>
            </form>

            <!-- Logout Button -->
            <div class="text-center mt-6">
                <a href="?logout=true" class="text-neutral-700 hover:text-neutral-800 font-medium">Logout</a>
            </div>

        </div>
    </div>

    <script>
        // Success Alert Auto-hide functionality
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 5000);
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
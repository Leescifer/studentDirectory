<?php
require_once 'auth.php';
require_once 'admin.php';

if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$student_id = $_GET['id'] ?? null;
if (!$student_id) {
    header('Location: dashboard.php');
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=student_directory_system", "root", "");
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    admin_edit_student_profile($student_id, $first_name, $last_name, $email);
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile</title>
</head>
<body class="bg-white">

    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto border border-neutral-500">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Edit Student Profile</h1>

            <form method="post" class="space-y-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-700">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <input type="submit" value="Update Student Profile" class="px-6 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-neutral-700 cursor-pointer">
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="dashboard.php" class="text-neutral-600 hover:text-neutral-800">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>

</body>
</html>

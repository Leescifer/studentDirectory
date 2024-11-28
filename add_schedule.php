<?php
require_once 'auth.php';
require_once 'admin.php';

if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch subjects for the dropdown
$pdo = new PDO("mysql:host=localhost;dbname=student_directory_system", "root", "");
$stmt = $pdo->query("SELECT id, name FROM subjects");
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];
    $room = $_POST['room'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    add_class_schedule($subject_id, $room, $day_of_week, $start_time, $end_time);
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class Schedule</title>
</head>
<body class="bg-white">

    <div class="flex justify-center items-center min-h-full">
        <div class="w-full max-w-xl p-8 bg-white border border-neutral-500  rounded-xl shadow-2xl">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Add Class Schedule</h1>

            <form method="post" class="space-y-6">
                
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select id="subject_id" name="subject_id" required class="mt-1 block w-full px-4 py-3 border border-neutral-700 rounded-lg focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                    <input type="text" id="room" name="room" required class="mt-1 block w-full px-4 py-3 border border-neutral-700 rounded-lg focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                </div>

                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day of Week</label>
                    <select id="day_of_week" name="day_of_week" required class="mt-1 block w-full px-4 py-3 border border-neutral-700 rounded-lg focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="start_time" name="start_time" required class="mt-1 block w-full px-4 py-3 border border-neutral-700 rounded-lg focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="end_time" name="end_time" required class="mt-1 block w-full px-4 py-3 border border-neutral-700 rounded-lg focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                </div>

                <div class="flex justify-center mt-4">
                    <input type="submit" value="Add Class Schedule" class="px-6 py-3 bg-neutral-500 text-white font-semibold rounded-lg hover:bg-neutral-700 focus:ring-2 focus:ring-neutral-900 focus:outline-none">
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="dashboard.php" class="text-neutral-600 hover:text-neutral-900">Back to Dashboard</a>
            </div>
        </div>
    </div>


    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>

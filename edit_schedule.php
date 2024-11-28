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
$pdo = new PDO("mysql:host=localhost;dbname=student_directory_system", "root", "");


$stmt = $pdo->prepare("SELECT s.*, sub.id AS subject_id, sub.name AS subject_name FROM schedules s JOIN subjects sub ON s.subject_id = sub.id WHERE s.id = ?");
$stmt->execute([$schedule_id]);
$schedule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$schedule) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->query("SELECT id, name FROM subjects");
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];
    $room = $_POST['room'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    admin_edit_class_schedule($schedule_id, $subject_id, $room, $day_of_week, $start_time, $end_time);
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class Schedule</title>
</head>
<body class="bg-white">

    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto border border-neutral-500">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Edit Class Schedule</h1>

            <form method="post" class="space-y-6">
                <!-- Subject -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select id="subject_id" name="subject_id" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-500">
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>" <?php echo $subject['id'] == $schedule['subject_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($subject['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Room -->
                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                    <input type="text" id="room" name="room" value="<?php echo htmlspecialchars($schedule['room']); ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-500">
                </div>

                <!-- Day of Week -->
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day of Week</label>
                    <select id="day_of_week" name="day_of_week" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-500">
                        <?php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        foreach ($days as $day):
                        ?>
                            <option value="<?php echo $day; ?>" <?php echo $day == $schedule['day_of_week'] ? 'selected' : ''; ?>>
                                <?php echo $day; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="start_time" name="start_time" value="<?php echo $schedule['start_time']; ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-500">
                </div>

                <!-- End Time -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="end_time" name="end_time" value="<?php echo $schedule['end_time']; ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <input type="submit" value="Update Class Schedule" class="px-6 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-500 cursor-pointer">
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

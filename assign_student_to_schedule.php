<?php
require_once 'auth.php';
require_once 'admin.php';

if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=student_directory_system", "root", "");

// Fetch all students
$stmt = $pdo->query("SELECT id, first_name, last_name FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all schedules
$stmt = $pdo->query("SELECT s.id, s.room, s.day_of_week, s.start_time, s.end_time, sub.name AS subject_name 
                     FROM schedules s 
                     JOIN subjects sub ON s.subject_id = sub.id");
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $schedule_id = $_POST['schedule_id'];

    assign_student_to_schedule($student_id, $schedule_id);
    $success_message = "Student successfully assigned to the class schedule.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Student to Class Schedule</title>
</head>
<body class="bg-white">

    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-xl p-8 bg-white rounded-xl shadow-xl border border-neutral-500">

            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Assign Student to Class Schedule</h1>

            <?php if (isset($success_message)): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <form method="post" class="space-y-6">
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                    <select id="student_id" name="student_id" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                        <?php foreach ($students as $student): ?>
                            <option value="<?php echo $student['id']; ?>">
                                <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Select Class Schedule</label>
                    <select id="schedule_id" name="schedule_id" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                        <?php foreach ($schedules as $schedule): ?>
                            <option value="<?php echo $schedule['id']; ?>">
                                <?php echo htmlspecialchars($schedule['subject_name'] . ' - ' . $schedule['day_of_week'] . ' ' . $schedule['start_time'] . '-' . $schedule['end_time'] . ' (Room: ' . $schedule['room'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="px-6 py-3 bg-neutral-500 text-white font-semibold rounded-lg hover:bg-neutral-700">
                        Assign Student
                    </button>               
                </div>
                <p class="text-center text-sm text-neutral-900">
            <a href="dashboard.php" class="hover:underline">Back to Dashboard</a>
        </p>
            </form>

        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>

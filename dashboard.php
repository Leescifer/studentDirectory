<?php
require_once 'auth.php';
require_once 'student.php';
require_once 'admin.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'student') {
    $profile = get_student_profile($user_id);
    $schedule = get_student_schedule($profile['id']);
} elseif ($role === 'admin') {
    $students = view_all_students();
    $schedules = view_all_class_schedules();
} else {
    // Handle unexpected role
    header('Location: logout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body class="bg-white flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar bg-neutral-900 text-white w-64 fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 flex flex-col">
        <div class="p-5 space-y-6 flex-grow">
            <h2 class="text-2xl font-semibold">Clifford</h2>
            <ul class="text-lg">
                <li>
                    <a href="dashboard.php" class="hover:bg-neutral-700 p-2 rounded block flex items-center space-x-2">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="add_student.php" class="hover:bg-neutral-700 p-2 rounded block flex items-center space-x-2">
                    <ion-icon name="person-add-outline"></ion-icon>
                        <span>Add Student</span>
                    </a>
                </li>
                <li>
                    <a href="add_schedule.php" class="hover:bg-neutral-700 p-2 rounded block flex items-center space-x-2">
                    <ion-icon name="calendar-clear-outline"></ion-icon>
                        <span>Add Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="assign_student_to_schedule.php" class="hover:bg-neutral-700 p-2 rounded block flex items-center space-x-2">
                        <ion-icon name="create-outline"></ion-icon>
                        <span>Assign Student</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="p-5 border-t">
            <a href="logout.php" class="hover:bg-neutral-700 p-2 rounded block flex items-center space-x-2">
                <ion-icon name="log-out-outline"></ion-icon>
                <span>Logout</span>
            </a>
        </div>
    </div>


    <!-- Backdrop -->
    <div id="backdrop" class="backdrop fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-40"></div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-6 lg:ml-64">
        <!-- Sidebar Toggle Button -->
        <button id="sidebar-toggle" class="lg:hidden p-2 text-neutral-700 rounded-md focus:outline-none">
        <ion-icon name="grid-outline" class="text-neutral-900"></ion-icon>
        </button>

        <!-- Content -->
        <h1 class="text-4xl font-semibold text-center text-gray-800 mb-2"><ion-icon name="bookmark-outline"></ion-icon>Admin Dashboard</h1>
        <p class="text-center text-2xl text-gray-600 mb-4">Welcome, <?php echo htmlspecialchars($role); ?>!</p>

        <!-- Header Navigation -->
        <div class="p-2 mb-4 border-b border-neutral-900">
            <nav class="flex justify-center space-x-4 ">

                <li id="all-students-btn" class="px-4 py-2 text-black rounded-md hover:bg-neutral-500 relative list-none cursor-pointer">
                <ion-icon name="school-outline"></ion-icon>
                    All Students
                </li>

                <div class="h-10 w-px bg-gray-300"></div>

                <li id="all-schedules-btn" class="px-4 py-2 text-black rounded-md hover:bg-neutral-500 relative list-none cursor-pointer">
                <ion-icon name="calendar-number-outline"></ion-icon>
                    All Class Schedules
                </li>
            </nav>
        </div>


        <!-- Students Table -->
        <div id="all-students" class="bg-white p-6 rounded-lg shadow-md mb-8 hidden text-center border border-neutral-700">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">All Students</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-200">ID</th>
                            <th class="px-4 py-2 bg-gray-200">Username</th>
                            <th class="px-4 py-2 bg-gray-200">Name</th>
                            <th class="px-4 py-2 bg-gray-200">Email</th>
                            <th class="px-4 py-2 bg-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($student['id']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($student['username']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($student['email']); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="text-blue-600 hover:text-blue-800"><ion-icon name="pencil-outline"></ion-icon></a> |
                                    <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="text-red-600 hover:text-red-800"><ion-icon name="trash-bin-outline"></ion-icon></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Schedules Table -->
        <div id="all-schedules" class="bg-white p-6 rounded-lg shadow-md hidden text-center border border-neutral-700">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">All Class Schedules</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-200">ID</th>
                            <th class="px-4 py-2 bg-gray-200">Subject</th>
                            <th class="px-4 py-2 bg-gray-200">Room</th>
                            <th class="px-4 py-2 bg-gray-200">Day</th>
                            <th class="px-4 py-2 bg-gray-200">Time</th>
                            <th class="px-4 py-2 bg-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($schedule['id']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($schedule['subject_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($schedule['room']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($schedule['day_of_week']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($schedule['start_time'] . ' - ' . $schedule['end_time']); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="edit_schedule.php?id=<?php echo $schedule['id']; ?>" class="text-blue-600 hover:text-blue-800"><ion-icon name="pencil-outline"></ion-icon></a> |
                                    <a href="delete_schedule.php?id=<?php echo $schedule['id']; ?>" class="text-red-600 hover:text-red-800"><ion-icon name="trash-bin-outline"></ion-icon></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="./js/dashboard.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


        <style>
            #sidebar {
                transition: transform 0.3s ease-in-out;
            }
        </style>
    </div>
</body>
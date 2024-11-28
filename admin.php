<?php
require_once 'config.php';
require_once 'auth.php';

function assign_student_to_schedule($student_id, $schedule_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL assign_student_to_schedule(?, ?)");
    $stmt->execute([$student_id, $schedule_id]);
}

function add_student($username, $password, $first_name, $last_name, $email) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("CALL add_student(?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashed_password, $first_name, $last_name, $email]);
}

function add_class_schedule($subject_id, $room, $day_of_week, $start_time, $end_time) {
    global $pdo;
    $stmt = $pdo->prepare("CALL add_class_schedule(?, ?, ?, ?, ?)");
    $stmt->execute([$subject_id, $room, $day_of_week, $start_time, $end_time]);
}

function admin_edit_student_profile($student_id, $first_name, $last_name, $email) {
    global $pdo;
    $stmt = $pdo->prepare("CALL admin_edit_student_profile(?, ?, ?, ?)");
    $stmt->execute([$student_id, $first_name, $last_name, $email]);
}

function admin_edit_class_schedule($schedule_id, $subject_id, $room, $day_of_week, $start_time, $end_time) {
    global $pdo;
    $stmt = $pdo->prepare("CALL admin_edit_class_schedule(?, ?, ?, ?, ?, ?)");
    $stmt->execute([$schedule_id, $subject_id, $room, $day_of_week, $start_time, $end_time]);
}

function view_all_students() {
    global $pdo;
    $stmt = $pdo->prepare("CALL view_all_students()");
    $stmt->execute();
    return $stmt->fetchAll();
}

function view_all_class_schedules() {
    global $pdo;
    $stmt = $pdo->prepare("CALL view_all_class_schedules()");
    $stmt->execute();
    return $stmt->fetchAll();
}

function delete_student($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL delete_student(?)");
    $stmt->execute([$student_id]);
}

function delete_class_schedule($schedule_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL delete_class_schedule(?)");
    $stmt->execute([$schedule_id]);
}
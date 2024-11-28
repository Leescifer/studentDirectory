<?php
require_once 'config.php';
require_once 'auth.php';

function get_student_profile($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL get_student_profile(?)");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function update_student_profile($user_id, $first_name, $last_name, $email) {
    global $pdo;
    $stmt = $pdo->prepare("CALL update_student_profile(?, ?, ?, ?)");
    $stmt->execute([$user_id, $first_name, $last_name, $email]);
}

function get_student_schedule($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL get_student_schedule(?)");
    $stmt->execute([$student_id]);
    return $stmt->fetchAll();
}

?>

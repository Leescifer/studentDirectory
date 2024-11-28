<?php
session_start();
require_once 'config.php'; // Including DB connection from config.php

// Function to register a user
function register_user($username, $password, $role) {
    global $pdo; // Reusing the PDO instance from config.php
    
    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        // Username already exists
        return false;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $hashed_password, $role]);
}

// Function to log a user in
function login($username, $password) {
    global $pdo; // Reusing the PDO instance from config.php
    
    // Query the database for the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // You can store the username as well
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

// Function to log the user out
function logout() {
    session_unset();
    session_destroy();
}

// Check if the user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check if the logged-in user is an admin
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Check if the logged-in user is a student
function is_student() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'student';
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "exam_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// LOOKUPS
$levels = $conn->query('SELECT * FROM level');
$courses = $conn->query('SELECT * FROM course');
$examTypes = $conn->query('SELECT * FROM exam_type');
$assignmentStatuses = $conn->query('SELECT * FROM assignment_status');

?>
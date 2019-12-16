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
echo "Connected successfully";

// $userSql = "INSERT INTO `user`(`user_id`, `first_name`, `last_name`, `email`, `password`, `level_id`) VALUES ('171103018','Mustapha','Ibrahim','mikabu38@gmail.com','blueT00th',3)";

// if ($conn->query($userSql) === TRUE) {
//     echo "Success1\n";
// } else {
//     echo "Failure1\n";
// }


$sql = "INSERT INTO exam (instructor_id, course_code, title, type_id, no_of_questions) VALUES ('171103018', 'CSC309', 'Finger Exercise', 3, 10)";

if ($conn->query($sql) === TRUE) {
    echo "Success1\n";
} else {
    echo "Failure1\n";
}

$examID = $conn->insert_id;
echo $examID;

$multiSql = "INSERT INTO theory_question (exam_id, question_no, question, mark) VALUES ($examID, 1, 'What is System Analysis?', 25),($examID, 2, 'Mention 5 applications of system analysis?', 25),($examID, 3, 'Describe system development life cycle', 50)";

if ($conn->query($multiSql) === TRUE) {
    echo "Success2\n";
} else {
    echo "Failure2\n";
}

?>
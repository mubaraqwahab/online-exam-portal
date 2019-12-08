<?php
include "../connect.php";
include "login.html";

if(isset($_POST["submit"])){
    $UserID = $_POST["user-id"];
    $FullName = $_POST["full-name"];
    $Email = $_POST["email"];
    $Password = $_POST["password"];
    $Level = $_POST["level"];
    //$ProfilePicture

    $sql = "INSERT INTO user_detail(UserID, FullName, Email, Password, Level) VALUES ('$UserID', '$FullName', '$Email', '$Password', '$Level')";

if ($conn->query($sql)===TRUE) {
    echo "New record created successfully..";
}
else {
    echo "Error creating the record: "  . $conn->error;
}
}

?>
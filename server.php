<?php
require_once 'sendEmail.php';

if(isset($_POST['contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $msg = "I'm ".$name." emailing from ".$email. " \n".$_POST['msg'];
    $adminEmail = "mogsharry@gmail.com";

    if($name != "" || $email != "" || $subject != "" || $msg != "") {
        sendEmail($adminEmail, $name, $subject, $msg);
        $obj = array("message" => "Email sent");
        echo json_encode($obj); 
    }
}

if(isset($_POST['getPosts'])) {
    $conn = new mysqli("localhost", "root", "", "honestat_api");
    if($conn->connect_error) {
        die("Something went wrong!\n".$conn->connect_error);
    }

    $sql = "SELECT * FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        $obj = array("message" => "No records found");
        echo json_encode($obj);
    }
}

?>
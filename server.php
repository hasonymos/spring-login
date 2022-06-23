<?php
require_once 'sendEmail.php';


// $readFile = readfile("serverconfig.json");
// $serverObj = json_decode($readFile, true);
$file = fopen("server.json", "r") or die("unable to open the file");
$fileContent = fread($file, filesize("server.json"));
fclose($file);
$serverDetails = json_decode($fileContent);
// var_dump($serverDetails);

$conn = new mysqli($serverDetails->server, $serverDetails->user, 
    $serverDetails->password, $serverDetails->database);

if($conn->connect_error) {
    die("Something went wrong!\n".$conn->connect_error);
}
date_default_timezone_set("Africa/Nairobi");

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

if(isset($_POST['post'])) {
    $sql = "INSERT INTO posts
    (title, image, body, postTime)
    VALUES
    (?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $theTitle, $theImage, $theBody, $thePostTime);
    $theTitle = $_POST['title'];
    $theImage = $_POST['image'];
    $theBody = $_POST['body'];
    $thePostTime = date("Y-m-d h:i:s");
    $stmt->execute();
    $result = $stmt->insert_id;
    if($result > 0) {
        $obj = array("message" => "Post successful");
        echo json_encode($obj);
    } else {
        $obj = array("message" => "Something went wrong!");
        echo json_encode($obj);
    }
}

?>
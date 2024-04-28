<?php
session_start();
if(!isset($_SESSION["sessionId"]) || $_SESSION["sessionId"] !== session_id()){
    setcookie("error_message", "Пользователь не авторизован!");
    header("Location: /IDS/authorization/package.php");
    exit();
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'server';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_SESSION['username'];
    $comm = $_POST['comment'];
    $image=$_FILES["image"];
    $image_data = file_get_contents($_FILES["image"]["tmp_name"]);

    $query = "INSERT INTO images (username, image, comment) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $user, $image_data, $comm);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Данные успешно добавлены";
    } else {
        echo "Ошибка добавления данных";
    }
    header("Location:../../menuPackage.php");
}




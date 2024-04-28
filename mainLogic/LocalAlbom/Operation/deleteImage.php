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
    $id = $_POST['id'];


    $query = "DELETE FROM images WHERE username =? AND id =? AND comment =?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $user, $id, $comm);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location:../localAlbom.php");
exit();


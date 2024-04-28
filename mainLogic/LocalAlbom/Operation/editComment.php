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
    $id = $_POST['id'];
    $new_comment = $_POST['commentNew'];

    $query = "UPDATE images SET comment =? WHERE id =?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_comment, $id);
    $stmt->execute();
    $stmt->close();

    header("Location:../localAlbom.php");
    exit();
}

$conn->close();
?>
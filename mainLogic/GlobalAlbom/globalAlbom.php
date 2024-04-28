<!DOCTYPE html>
<html lang="ru">

<head><title>Общий альбом</title></title></head>
<a href="../menuPackage.php">Меню</a>

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

$query = "SELECT id, image, comment, username FROM images";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image_data = $row['image'];
        $comment = $row['comment'];
        $id = $row['id'];
        $username = $row['username'];


        echo "<div style='border: 1px solid black; padding: 1px;'>";
        echo "<img src='data:image/jpeg;base64,". base64_encode($image_data). "' />";
        echo "<p>Автор: $username</p>";
        echo "<p>Комментарий:$comment</p>";
        echo "<br>";
        echo "</div>";

    }
} else {
    echo "No images found";
}

$stmt->close();
$conn->close();

?>


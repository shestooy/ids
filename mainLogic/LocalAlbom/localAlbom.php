<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Ваш альбом</title></head>
<body>
<br>
<a href="../menuPackage.php">Меню</a>
</body>
</html>


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

$username = $_SESSION['username'];

$query = "SELECT id, image, comment FROM images WHERE username =?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image_data = $row['image'];
        $comment = $row['comment'];
        $id = $row['id'];

        // отобразить картинку с комментарием и кнопками
        echo "<div style='border: 1px solid black; padding: 1px;'>";
        echo "<img src='data:image/jpeg;base64,". base64_encode($image_data). "' />";
        echo "<form action='Operation/deleteImage.php' method='post' style='float: right;'>";
        echo "<input type='hidden' name='id' value='".$id."'>";
        echo "<input type='hidden' name='comment' value='".$comment."'>";
        echo "<button type='submit'>Удалить запись</button>";
        echo "</form>";


        echo "<br>";
        echo "<form action='Operation/editComment.php' method='post' style='float: right;'>";
        echo "<label>";
        echo "<textarea name='commentNew' placeholder='Введите комментарий'></textarea>";
        echo "<input type='hidden' name='id' value='".$id."'>";
        echo "</label>";
        echo "<br>";
        echo "<button type='submit'>Изменить комментарий</button>";
        echo "</form>";

        echo "<p>Комментарий:</p>";
        echo "<p>$comment</p><br>";
        echo "</div>";
    }
} else {
    echo "No images found";
}

$stmt->close();
$conn->close();

?>


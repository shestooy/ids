<?php
session_start();
if(!isset($_SESSION["sessionId"]) || $_SESSION["sessionId"] !== session_id()){
    setcookie("error_message", "Пользователь не авторизован!");
    header("location: package.php");
    exit();
}


$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'server';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    if (ctype_space($username) || ctype_space($password)) {
        setcookie("error_message", "Можно использовать только символы и цифры!");
        $conn->close();
        header("Location: package.php");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0)
    {
        setcookie("error_message", "Пользователь не найден, нажмите кнопку регистрации!");
        $stmt->close();
        $conn->close();
        header("Location: package.php");
    }


    $row = $res->fetch_assoc();
    if (!password_verify($password, $row['password'])) {
        setcookie("error_message", "Неверный пароль!");
        $stmt->close();
        $conn->close();
        header("Location: package.php");
    }

    $_SESSION["username"] = $username;

    $stmt->close();
}

$conn->close();
header("Location: /IDS/mainLogic/menuPackage.php");

?>
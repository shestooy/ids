<?php

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
        header("Location: register.php");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0)
    {
        setcookie("error_message", "Логин уже существует!");
        $stmt->close();
        $conn->close();
        header("Location: register.php");
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    $stmt->bind_param("ss", $username, $hashed_password);


    if ($stmt->execute()) {
        header("Location: package.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();

if (isset($_COOKIE["error_message"])) {
    echo $_COOKIE["error_message"];
    setcookie("error_message", "", time() - 3600);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Регистрация</title>
</head>
<body>
<h2>Регистрация</h2>
<form action="register.php" method="post">
    <label for="username">Логин:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Пароль:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Регистрация"><br><br>
</form>
<a href="package.php">Вернуться на главную страницу</a>
</body>
</html>
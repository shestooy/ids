<?php
session_start();
$_SESSION["sessionId"] = session_id();
if (isset($_COOKIE["error_message"])) {
    echo $_COOKIE["error_message"];
    setcookie("error_message", "", time() - 3600);
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Главная страница</title>
</head>
<meta charset="UTF-8">
<h2>Вход</h2>
<form action="login.php" method="post">
    <label for="username">Логин</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Пароль:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Отправить"><br><br>
</form>

Для новых моих пользователей:
<a href="register.php">Регистрация</a><title></title>

</html>


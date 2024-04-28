<?php
session_start();
if(!isset($_SESSION["sessionId"]) || $_SESSION["sessionId"] !== session_id()){
    setcookie("error_message", "Пользователь не авторизован!");
    header("Location: /IDS/authorization/package.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        parse_str($_SERVER['HTTP_COOKIE'], $cookies);
        foreach ($cookies as $name => $value) {
            setcookie($name, '', time() - 1000);
        }
    }
    unset($_SESSION["sessionId"]);
    header("Location: ../authorization/package.php");
    session_destroy();
    exit();
}

?>


<!DOCTYPE html>
<html lang="ru">

<head><title>Меню</title></title></head>

<form action="LocalAlbom/Operation/addImage.php" method="post">
    <button type="submit">
        Добавить картинку в мой альбом!
    </button>
</form>
<br>

<form action="LocalAlbom/localAlbom.php" method="post">
    <button type="submit">
        Открыть мой альбом!
    </button>
</form>
<br>

<form action="GlobalAlbom/globalAlbom.php" method="post">
    <button type="submit">
        Открыть общий альбом!
    </button>
</form>
<br>

<form action="menuPackage.php" method="post">
    <button type="submit">
        Выйти из системы!
    </button>
</form>

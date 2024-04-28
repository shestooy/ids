<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Загрузка картинки</title>
</head>

<meta charset="UTF-8">
<h1>Выберите файл и введите комментарий</h1>
<form action="addImageProccess.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*"><br>
    <label>
        <textarea name="comment" placeholder="Введите комментарий"></textarea>
    </label>

    <input type="submit" value="Отправить">
</form>
<br>
<a href="../../menuPackage.php">Меню</a>
</html>



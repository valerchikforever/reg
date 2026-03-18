<?
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тех. задание</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <? require_once 'patterns/header.php'; ?>

    <main>
        <?if (!isset($_SESSION['email'])){?>
            <center>
                <h1>Перед началом работы авторизируйтесь!</h1>
            </center>
        <?}
        else{?>
            <center>
                <h1>Вы авторизваны, пользуйтесь на здоровье!</h1>
            </center>
        <?}?>
    </main>

    <? require_once 'patterns/footer.php'; ?>
</body>
</html>
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

    <section>
        <form id='form' action="/login" method="post">
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="mail@mail.ru" required>
        </div>

        <div class="form-group">
        <label for="password">Пароль:</label>
        <input id='password1' type="password" name="password" placeholder="Пароль" required>
        </div>

        <div class="form-group">
        <input id='button' type="submit" value="Войти">
        </div>
        </form>
        <p>Нет аккаунта? <a href="registration.php">Зарегистрируйтесь.</a></p>
    </section>

    <? require_once 'patterns/footer.php'; ?>

</body>
</html>
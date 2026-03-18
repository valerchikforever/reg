<?php
session_start();

if (isset($_SESSION['email'])){
    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тех. задание</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <? require_once 'patterns/header.php'; ?>

    <section>
        <form id='demo-form' action="/src/login" method="post">
        <div class="form-group">
        <label for="email">Email или номер телефона:</label>
        <input type="text" name="email_phone" placeholder="Почта или телефон" required>
        </div>

        <div class="form-group">
        <label for="password">Пароль:</label>
        <input id='password1' type="password" name="password" placeholder="Пароль" required>
        </div>

        <div class="g-recaptcha" data-sitekey="6Ldr7I4sAAAAAG-TmV7U2cJsD9SrGEmDByW03L7Q"></div>
            <br/>
            <input type="submit" value="Войти">
        </div>
        </form>
        <p>Нет аккаунта? <a href="registration.php">Зарегистрируйтесь.</a></p>
    </section>

    <? require_once 'patterns/footer.php'; ?>

    <script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
    </script>

</body>
</html>
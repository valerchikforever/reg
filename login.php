<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тех. задание</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc_PIwsAAAAAIqmkoDIPQfN8bk2LgZUhQA_ytT3"></script>
</head>
<body>
    <? require_once 'patterns/header.php'; ?>

    <section>
        <form id='demo-form' action="/src/login" method="post">
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email_phone" placeholder="Введите почту или телефон" required>
        </div>

        <div class="form-group">
        <label for="password">Пароль:</label>
        <input id='password1' type="password" name="password" placeholder="Пароль" required>
        </div>

        <div class="form-group">
        <input id='button' type="submit" value="Войти" class="g-recaptcha" 
        data-sitekey="6Lc_PIwsAAAAAIqmkoDIPQfN8bk2LgZUhQA_ytT3"
        data-callback='onSubmit' 
        data-action='submit'>
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
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
        <form id='demo-form' action="/src/register" method="post">
        <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" name="name" placeholder="Иванов Иван Иванович" required>
        </div>

        <div class="form-group">
        <label for="password">Пароль:</label>
        <input id='password1' type="password" name="password1" placeholder="Пароль" required>
        </div>

        <div class="form-group">
        <label for="password">Подтвердите пароль:</label>
        <input id='password2' type="password" name="password2" placeholder="Подтвердите пароль" required>
        </div>

        <div class="form-group">
        <label for="phone">Телефон:</label>
        <input type="text" name="phone" placeholder="89993332211" required>
        </div>

        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="mail@mail.ru" required>
        </div>

        <div class="form-group">
        <input id='button' type="submit" value="Зарегистрироваться" class="g-recaptcha" 
        data-sitekey="6Lc_PIwsAAAAAIqmkoDIPQfN8bk2LgZUhQA_ytT3"
        data-callback='onSubmit' 
        data-action='submit'>
        <!-- <input id='button' type="submit" value="Зарегистрироваться"> -->
        </div>
        </form>
        <p>Уже есть аккаунт? <a href="login.php">Войдите.</a></p>
    </section>

    <? require_once 'patterns/footer.php'; ?>

    <script>
        const form = document.querySelector('#demo-form');
        const password1 = document.querySelector('#password1');
        const password2 = document.querySelector('#password2');
        const errorMessage = document.createElement('div');

        errorMessage.style.color = 'red';
        errorMessage.style.marginTop = '5px';
        errorMessage.style.fontSize = '0.9em';

        password2.parentNode.insertBefore(errorMessage, password2.nextSibling);

        form.addEventListener('submit', function(event) {
        errorMessage.textContent = '';

        if (password1.value !== password2.value) {
            event.preventDefault();
            errorMessage.textContent = 'Пароли не совпадают!';
            password2.focus();
        }
        });
    </script>

    <script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
 </script>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['email'])){
    header('Location: index.php');
}
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
        <p><? echo $_SESSION["name"] ?></p>
        <p><? echo $_SESSION["id"] ?></p>

        <button onclick="form_vision()">Изменить данные</button>

            <section id="form_section">
                <form id='form' action="/update" method="post">
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
                <input id='password2' type="password" name="password2" placeholder="Пароль" required>
                </div>

                <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="text" name="phone" placeholder="Иванов Иван Иванович" required>
                </div>

                <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="mail@mail.ru" required>
                </div>

                <div class="form-group">
                <input id='button' type="submit" value="Обновить">
                </div>
                </form>
            </section>
    </main>

    <? require_once 'patterns/footer.php'; ?>

    <script>
        const form = document.querySelector("#form_section");
        form.style.visibility = "hidden";

        function form_vision(){
            form.style.visibility = "visible";
        }
    </script>
</body>
</html>
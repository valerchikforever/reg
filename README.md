# Система регистрации и авторизации (Тестовое задание)

Веб-приложение на PHP, реализующее полный цикл управления учетной записью пользователя: от регистрации до редактирования профиля.

## Функционал

- **Регистрация:** Валидация данных на стороне сервера и клиента, проверка на уникальность (Email, Телефон, Логин).
- **Авторизация:** Вход в систему по Email или номеру телефона.
- **Личный кабинет:** Отображение текущих данных пользователя.
- **Редактирование данных:** Модальное окно для обновления информации профиля (с проверкой пароля).
- **Безопасность:** 
  - Хеширование паролей (`password_hash`).
  - Подготовленные выражения PDO для защиты от SQL-инъекций.
  - Проверка капчи **Google reCAPTCHA v2**.
  - Защита роутов (проверка сессий).

## Технологии

- **Backend:** PHP 8.x
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript (для reCaptcha, проверки форм на стороне клиента и немного оформления)
- **Библиотеки:**
  - `vlucas/phpdotenv` (управление конфигурацией)
  - Composer (автозагрузка PSR-4)
  - Google reCAPTCHA API

## Структура проекта

```text
├── connection/          # Подключение к БД и конфигурация .env
├── patterns/            # Шаблоны (header.php, footer.php)
├── src/                 # Серверная логика
│   ├── Controllers/     # Классы (Login, Registration, Update)
│   └── index.php        # Единая точка входа для API (роутинг)
├── styles/              # CSS стили
├── vendor/              # Зависимости Composer
├── index.php            # Главная страница
├── login.php            # Страница входа
├── registration.php     # Страница регистрации
├── profile.php          # Профиль пользователя
├── logout.php           # Выход из системы
└── composer.json        # Описание зависимостей
```

## Настройка базы данных
Создайте базу данных и выполните SQL-запрос для создания таблицы:
code
SQL
```text
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `phone` VARCHAR(20) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Конфигурация (.env)
В папке connection/ создайте файл .env и заполните его своими данными:
code
Env
```text
DATABASE_HOST=localhost
DATABASE_NAME=your_db_name
DATABASE_USER=your_db_user
DATABASE_PASS=your_db_password
CAPTCHA_SECRET_KEY=your_google_recaptcha_secret_key
```

## Настройка сервера (Важно)
Проект использует роутинг через параметр q. Чтобы ссылки типа /src/register работали, создайте файл .htaccess в папке src/ со следующим содержимым:
code
Apache
```text
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?q=$1 [L,QSA]
```

## Безопасность
Все данные из форм обрабатываются через PDO с использованием именованных плейсхолдеров.
Доступ к profile.php и методам update закрыт для неавторизованных пользователей (редирект на index.php).
Пароли никогда не хранятся в открытом виде.

## Контакты
Автор: Абкадыров Ильнар
Email: abkadyrov.ilnar@mail.ru
Телефон: 8 (927) 939-25-06

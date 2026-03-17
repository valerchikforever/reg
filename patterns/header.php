<header>
    <p>Хедер</p>
    <nav>
        <? if (isset($_SESSION['email'])){ ?>
            <a href="../profile.php"><button>Кнопка</button></a>
        <?}?>
        <a href="../registration.php"><button>Зарегистрироваться</button></a>
        <a href="../login.php"><button>Войти</button></a>
    </nav>
</header>
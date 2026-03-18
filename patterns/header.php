<header>
    <a href="../index.php"><p>Тестовое задание</p></a>
    <nav>
        <? if (isset($_SESSION['email'])){ ?>
            <a href="../profile.php"><button>Профиль</button></a>
            <a href="../logout.php"><button>Выйти</button></a>
        <?}?>
        <? if (!isset($_SESSION['email'])){ ?>
            <a href="../registration.php"><button>Зарегистрироваться</button></a>
            <a href="../login.php"><button>Войти</button></a>
        <?}?>
        
    </nav>
</header>
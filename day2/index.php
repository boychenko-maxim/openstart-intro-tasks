<?php
    include('displayErrors.php');

    session_start();

    $userName = '';
    if (isset($_SESSION['userName'])) {
        $userName = htmlspecialchars($_SESSION['userName']);
    }

    $userPassword = '';
    if (isset($_SESSION['userPassword'])) {
        $userPassword = htmlspecialchars($_SESSION['userPassword']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>2 день</title>
    <link href="css/index.css" rel="stylesheet">
</head>
<body>
    <?php if (!isset($_SESSION['userLoggedIn']) || !$_SESSION['userLoggedIn']): ?>
        <form class="loginForm" method="POST" action="login.php">
            Логин: <input type="text" name="userName" value="<?=$userName?>">
            Пароль: <input type="password" name="userPassword" value="<?=$userPassword?>">
            <input type="submit" value="Войти">
            <?php if (isset($_SESSION['showLoginFailed']) && $_SESSION['showLoginFailed']): ?>
                Неверный логин или пароль!
            <?php
                $_SESSION['showLoginFailed'] = false;
                $_SESSION['userName'] = '';
                $_SESSION['userPassword'] = '';
                endif;
            ?>
        </form>
        <form method="POST" action="registration.php">
            <input type="submit" value="Регистрация">
        </form>
    <?php else: ?>
        <p>
            Пользователь: <?=htmlspecialchars($_SESSION['userName'])?>
        </p>
        <form method="POST" action="logout.php">
            <input type="submit" value="Выход">
        </form>
    <?php endif; ?>
</body>
</html>
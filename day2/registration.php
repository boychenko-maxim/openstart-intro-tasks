<?php
    include('helper.php');
    include('pdoHelper.php');
    include('displayErrors.php');

    $newLogin = '';

    if (isset($_POST['newLogin'])) {
        $pdo = getMysqlPDO('databaseSettings.php');
        if (!usersDatabaseContain($pdo, $_POST['newLogin'])) {
            $statement = $pdo->prepare("INSERT INTO Users(name, passwordHash)
                                       VALUES
                                          (:userName, :userPasswordHash)"
            );
            $statement->execute(array(':userName' => $_POST['newLogin'],
                ':userPasswordHash' => md5($_POST['newPassword']))
            );
            session_start();
            $_SESSION['userName'] = $_POST['newLogin'];
            $_SESSION['userLoggedIn'] = true;
            header("Location: " . getAbsoluteUrl('index.php'));
            exit;
        } else {
            $userExists = true;
            $newLogin = htmlspecialchars($_POST['newLogin']);
        }
    }

    function usersDatabaseContain($pdo, string $name)
    {
        $statement = $pdo->prepare("SELECT * FROM Users WHERE name=:userName");
        $statement->execute(array(':userName' => $name));
        return $statement->fetchObject() !== false;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>2 день</title>
    <link href="css/registration.css" rel="stylesheet">
</head>
    <body>
        <script src="js/validation.js"></script>
        <p>Введите данные для регистрации: </p>
        <form onsubmit="return validateRegistrationForm()" name="registrationForm" class="registrationForm"
              method="post"
              action="registration.php">
            Логин: <input type="text" name="newLogin" value="<?=$newLogin?>">
            Пароль: <input type="password" name="newPassword">
            Повторите пароль: <input type="password" name="repeatPassword">
            <input type="submit" value="Зарегестрироваться">
            <div id="formValidationError"></div>
            <?php if (isset($userExists) && $userExists):?>
                <p>Пользователь с таким именем уже существует!</p>
            <?php endif;?>
        </form>
    </body>
</html>
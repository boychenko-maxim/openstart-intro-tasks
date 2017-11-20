<?php

include('helper.php');
include('pdoHelper.php');
include('displayErrors.php');

session_start();

$pdo = getMysqlPDO('databaseSettings.php');

$user = $pdo->prepare("SELECT * FROM Users WHERE name=:userName AND passwordHash=:userPasswordHash");
$user->execute(array(':userName' => $_POST['userName'],
    'userPasswordHash' => md5($_POST['userPassword']))
);

if ($user->fetchObject() !== false) {
    $_SESSION['userLoggedIn'] = true;
    $_SESSION['showLoginFailed'] = false;
} else {
    $_SESSION['userLoggedIn'] = false;
    $_SESSION['showLoginFailed'] = true;
}

$_SESSION['userName'] = $_POST['userName'];
$_SESSION['userPassword'] = $_POST['userPassword'];

header("Location: " . getAbsoluteUrl('index.php'));
exit;



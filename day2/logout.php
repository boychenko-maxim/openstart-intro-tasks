<?php

include('helper.php');

session_start();

$_SESSION['userLoggedIn'] = false;
$_SESSION['userName'] = '';
$_SESSION['userPassword'] = '';

header("Location: " . getAbsoluteUrl('index.php'));
exit;
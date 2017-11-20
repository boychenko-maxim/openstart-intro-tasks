<?php
    $phone = '';
    if (isset($_POST['phone'])) {
        $phone = $_POST['phone'];
    }
?>

<form action="test1.php" method="post">
    Телефон: <input type="text" name="phone" value="<?=$phone?>"/>
    <input type="submit" value="Проверить корректность телефона"/>
</form>

<?php
if (isset($_POST['phone'])) {
    if (preg_match('/^\s*((\+\s*?7)|8)\s*-?\s*[0-9]{3}\s*-?\s*[0-9]{3}\s*-?\s*[0-9]{2}\s*-?\s*[0-9]{2}\s*$/', $_POST['phone'])) {
        echo "Телефон '{$_POST['phone']}' корректен";
    } else {
        echo "Телефон '{$_POST['phone']}' некорректен";
    }
}
?>


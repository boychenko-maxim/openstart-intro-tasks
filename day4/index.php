<?php

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = "nintendo128";
$mrh_pass1 = "vu1oerOdVBA8XA6OE1Y8";

// описание заказа
// order description
$inv_desc = "Марио";

// язык
// language
$culture = "ru";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>day 4</title>
    <style>
        form {
            width: 200px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.5.0/js/md5.min.js"></script>
</head>
<body>
<form id="payForm" onsubmit="return validateFormAndCalulateSignature()" action='https://merchant.roboxchange.com/Index.aspx' method=POST>
    <input id="login" type=hidden name='MrchLogin' value=<?=$mrh_login?>>
    Сумма: <input id="sum" name='OutSum'>
    Номер заказа: <input id="id" name='InvId'>
    Способ оплаты:
    <select name=IncCurrLabel>
        <optgroup label="Электронным кошельком">
            <option value="Qiwi40QiwiRM">
                QiwiWallet
            </option>
        </optgroup>
        <optgroup label="Через интернет-банк">
            <option value="AlfaBankQiwiR">
                Альфа-Клик
            </option>
        </optgroup>
        <optgroup label="Банковской картой">
            <option value="QCardR">
                Банковская карта
            </option>
            <option value="ApplePayQiwiR">
                Apple Pay
            </option>
            <option value="SamsungPayQiwiR">
                Samsung Pay
            </option>
        </optgroup>
        <optgroup label="В терминале">
            <option value="Qiwi40QiwiRM">
                QIWI Кошелек
            </option>
        </optgroup>
        <optgroup label="Другие способы">
            <option value="RapidaQiwiEurosetR">
                Евросеть
            </option>
            <option value="RapidaQiwiSvyaznoyR">
                Связной
            </option>
        </optgroup>
    </select>
    <input type=hidden name='Desc' value=<?=$inv_desc?>>
    <input id="signature" type=hidden name='SignatureValue'>
    <input type=hidden name='Culture' value=<?=$culture?>>
    <input type=hidden name='isTest' value='1'>
    <input type=submit value='Оплатить'>
    <script>
        function validateFormAndCalulateSignature() {
            var form = document.getElementById('payForm');
            var error = document.getElementById('formValidationError');

            var sum = form['sum'].value.trim();
            if (sum.length == 0) {
                error.innerText = "Введите сумму!";
                return false;
            } else if (parseFloat(sum) <= 0) {
                error.innerText = "Введите корректную сумму!";
                return false;
            }

            var id = form['id'].value.trim();
            if (id.length == 0) {
                error.innerText = "Введите номер заказа!";
                return false;
            } else if (parseFloat(id) <= 0) {
                error.innerText = "Введите корректный номер заказа!";
                return false;
            }

            calculateSignature();
            return true;
        }

        function calculateSignature() {
            var login = document.getElementById('login');
            var sum = document.getElementById('sum');
            sum.setAttribute('value', parseFloat(sum.value).toFixed(2));
            var id = document.getElementById('id');
            var signature = document.getElementById('signature');
            var signatureValue = md5(login.value + ":" +  sum.value + ":" + id.value + ":vu1oerOdVBA8XA6OE1Y8");
            signature.setAttribute('value', signatureValue);
        }
    </script>
</form>
<div id="formValidationError"/>
</body>
</html>
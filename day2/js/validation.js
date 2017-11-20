function validateRegistrationForm() {
    var form = document['registrationForm'];
    var error = document.getElementById('formValidationError');
    if (form['newLogin'].value.trim().length == 0) {
        error.innerText = "Логин должен содержать минимум один символ!";
        return false;
    }
    if (form['newPassword'].value.trim() != form['repeatPassword'].value.trim()) {
        error.innerText = "Пароли не совпадают!";
        return false;
    } else if (form['newPassword'].value.trim().length == 0) {
        error.innerText = 'Пароль должен содержать минимум 1 символ!';
        return false;
    }
    return true;
}
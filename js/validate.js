function showError(container, errorMessage) {
    container.className = 'error';
    var msgElem = document.createElement('span');
    msgElem.className = "error-message";
    msgElem.innerHTML = errorMessage;
    container.appendChild(msgElem);
}

function resetError(container) {
    container.className = '';
    if (container.lastChild.className == "error-message") {
        container.removeChild(container.lastChild);
    }
}

function getMessageName(language) {
    if (language == 'en') return ' Please enter a name ';
    else if (language == 'ru') return ' Пожалуйста, введите имя ';
}

function getMessagePassword(language) {
    if (language == 'en') return ' Please enter a password ';
    else if (language == 'ru') return ' Пожалуйста, введите пароль ';
}

function validate(form) {
    var elems = form.elements;
    var select = form.parentNode.id;
    var language = form.parentNode.className.split(' ')[2];
    var errormessage;
    var result = true;

    if (select == 'login') {
        resetError(elems.username.parentNode);
        if (!elems.username.value) {
            errormessage = getMessageName(language);
            showError(elems.username.parentNode, errormessage);
            result = false;
        }

        resetError(elems.password.parentNode);
        if (!elems.password.value) {
            errormessage = getMessagePassword(language);
            showError(elems.password.parentNode, errormessage);
            result = false;
        }
    } else if (select == 'register') {
        resetError(elems.usernamesignup.parentNode);
        if (!elems.usernamesignup.value) {
            errormessage = getMessageName(language);
            showError(elems.usernamesignup.parentNode, errormessage);
            result = false;
        }

        resetError(elems.emailsignup.parentNode);
        if (!elems.emailsignup.value) {
            if (language == 'en') errormessage = ' Please enter an email ';
            else if (language == 'ru') errormessage = ' Пожалуйста, введите адрес почты ';
            showError(elems.emailsignup.parentNode, errormessage);
            result = false;
        } else {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var validatemail = re.test(elems.emailsignup.value);
            if (!validatemail) {
                if (language == 'en') errormessage = ' Please enter the correct email ';
                else if (language == 'ru') errormessage = ' Пожалуйста, введите правильный адрес почты ';
                showError(elems.emailsignup.parentNode, errormessage);
                result = false;
            }
        }

        resetError(elems.passwordsignup_confirm.parentNode);
        if (!elems.passwordsignup_confirm.value) {
            errormessage = getMessagePassword(language);
            showError(elems.passwordsignup_confirm.parentNode, errormessage);
            result = false;
        }

        resetError(elems.passwordsignup.parentNode);
        if (!elems.passwordsignup.value) {
            errormessage = getMessagePassword(language);
            showError(elems.passwordsignup.parentNode, errormessage);
            result = false;
        } else if(elems.passwordsignup.value.length < 6){
            if (language == 'en') errormessage = ' Password must be at least 6 characters long ';
            else if (language == 'ru') errormessage = ' Пароль должен быть не менее 6 символов ';
            showError(elems.passwordsignup.parentNode, errormessage);
            result = false;
        } else if (elems.passwordsignup.value != elems.passwordsignup_confirm.value) {
            if (language == 'en') errormessage = ' Passwords don\'t match ';
            else if (language == 'ru') errormessage = ' Пароли не совпадают ';
            showError(elems.passwordsignup.parentNode, errormessage);
            result = false;
        }
    }

    return result;
}
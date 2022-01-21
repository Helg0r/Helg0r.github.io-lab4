var openLoginForm_button = document.getElementById('openLoginForm');
var loginForm = document.getElementById("loginForm");
var signupForm = document.getElementById("signupForm")
var formContainer = document.getElementById("form_container");
var closeForm_button1 = document.getElementById("closeForm_button1");
var closeForm_button2 = document.getElementById("closeForm_button2");
var toggleToSignupForm = document.getElementById("toggle_toSignupForm");
var toggleToLoginForm = document.getElementById("toggle_toLoginForm");
var signupPasswordInput = document.getElementById("signupForm_password");
var signupPasswordRepeatInput = document.getElementById("signupForm_passwordRepeat");


openLoginForm_button.onclick = function () {
    formContainer.classList.add("active");
    loginForm.classList.add("active");
}

closeForm_button1.onclick = function () {
    formContainer.classList.remove("active");
    loginForm.classList.remove("active");
    signupForm.classList.remove("active");
}

closeForm_button2.onclick = function () {
    formContainer.classList.remove("active");
    loginForm.classList.remove("active");
    signupForm.classList.remove("active");
}

toggleToSignupForm.onclick = function () {
    loginForm.classList.remove("active");
    signupForm.classList.add("active");
}

toggleToLoginForm.onclick = function () {
    signupForm.classList.remove("active");
    loginForm.classList.add("active");
}



async function registrationDataSend(e) {
    e.preventDefault();

    let regFormNameInput = document.getElementById('signupForm_name');
    let regFormEmailInput = document.getElementById('signupForm_email');
    let regFormPhoneInput = document.getElementById('signupForm_phone');
    let regFormPasswordInput = document.getElementById('signupForm_password');
    let regFormPasswordRepeatInput = document.getElementById('signupForm_passwordRepeat');

    if (regFormNameInput.classList.contains("invalid")) {
        regFormNameInput.classList.remove("invalid");
    }
    if (regFormEmailInput.classList.contains("invalid")) {
        regFormEmailInput.classList.remove("invalid");
    }
    if (regFormPhoneInput.classList.contains("invalid")) {
        regFormPhoneInput.classList.remove("invalid");
    }
    if (regFormPasswordInput.classList.contains("invalid")) {
        regFormPhoneInput.classList.remove("invalid");
    }
    if (regFormPasswordRepeatInput.classList.contains("invalid")) {
        regFormPasswordRepeatInput.classList.remove("invalid");
    }

    let regFormError = document.getElementById('signupForm-error');
    let registerFormData = new FormData(signupForm);

    fetch('register.php', {
        method: 'POST',
        body: registerFormData
    }
    )
        .then(response => response.json())
        .then((result) => {
            console.log(result);
            if (result.errors) {
                //вывод ошибок валидации на форму
                regFormError.textContent = "";
                result.errors.forEach(function callback(currentValue) {
                    if (currentValue == "name") {
                        regFormNameInput.classList.add("invalid");
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Некорректное имя";
                        }
                        else {
                            regFormError.textContent += "\nНекорректное имя";
                        }
                    }
                    if (currentValue == "email") {
                        regFormEmailInput.classList.add("invalid");
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Некорректный email";
                        }
                        else {
                            regFormError.textContent += "\nНекорректный email";
                        }
                    }
                    if (currentValue == "phone") {
                        regFormPhoneInput.classList.add("invalid");
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Некорректный номер телефона";
                        }
                        else {
                            regFormError.textContent += "\nНекорректный номер телефона";
                        }
                    }
                    if (currentValue == "password") {
                        regFormPasswordInput.classList.add("invalid");
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Некорректный пароль";
                        }
                        else {
                            regFormError.textContent += "\nНекорректный пароль";
                        }
                    }
                    if (currentValue == "passwordRepeat") {
                        regFormPasswordRepeatInput.classList.add("invalid");
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Пароли не совпадают";
                        }
                        else {
                            regFormError.textContent += "\nПароли не совпадают";
                        }
                    }
                    if (currentValue == "checkbox") {
                        if (regFormError.textContent == "") {
                            regFormError.textContent += "Необходимо принять соглашение на обработку персональных данных";
                        }
                        else {
                            regFormError.textContent += "\nНеобходимо принять соглашение на обработку персональных данных";
                        }
                    }
                })
            } else if (!result.email_check) {
                regFormError.textContent = "";
                regFormError.textContent += "Пользователь с таким email уже существует";
                regFormEmailInput.classList.add("invalid");
                console.log("Пользователь с таким email уже существует");
            }
            else {
                //успешная регистрация, обновляем страницу
                window.location.reload()
            }
        })
        .catch(error => console.log(error));
}



async function authorizationDataSend(e) {
    e.preventDefault();

    let loginFormEmailInput = document.getElementById('loginForm_email');
    let loginFormPasswordInput = document.getElementById('loginForm_password');

    if (loginFormEmailInput.classList.contains("invalid")) {
        loginFormEmailInput.classList.remove("invalid");
    }
    if (loginFormPasswordInput.classList.contains("invalid")) {
        loginFormPasswordInput.classList.remove("invalid");
    }

    let loginFormError = document.getElementById('loginForm-error');

    let loginFormData = new FormData(loginForm);

    fetch('login.php', {
        method: 'POST',
        body: loginFormData
    }
    )
        .then(response => response.json())
        .then((result) => {
            console.log(result);
            if (result.errors) {
                //вывод ошибок валидации на форму
                loginFormError.textContent = "";
                result.errors.forEach(function callback(currentValue) {
                    if (currentValue == "email") {
                        loginFormEmailInput.classList.add("invalid");
                        if (loginFormError.textContent == "") {
                            loginFormError.textContent += "Пользователь с таким email не найден";
                        }
                        else {
                            loginFormError.textContent += "\nПользователь с таким email не найден";
                        }
                    }
                    if (currentValue == "password") {
                        loginFormPasswordInput.classList.add("invalid");
                        if (loginFormError.textContent == "") {
                            loginFormError.textContent += "Некорректный пароль";
                        }
                        else {
                            loginFormError.textContent += "\nНекорректный пароль";
                        }
                    }
                })
            } else {
                //успешная авторизация, обновляем страницу
                window.location.reload()
            }
        })
        .catch(error => console.log(error));
}

loginForm.addEventListener("submit", authorizationDataSend);
signupForm.addEventListener("submit", registrationDataSend);
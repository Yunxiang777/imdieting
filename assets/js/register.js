/* register View JS */
$(document).ready(function () {
    var inputvalidator = new InputValidator();
    var sweatalert = new SweatAlert();
    var csrfHash = $("#csrfHash");

    // 註冊按鈕觸發
    $('.register-view').on('click', '#register-register', function () {
        var email = $("#register-email").val();
        var password = $("#register-password").val();
        // 驗證mail
        if (!inputvalidator.isValidEmail(email)) {
            inputvalidator.displayError('register-email', '', 'Invalid email format');
            return;
        }

        // 驗證密碼
        if (password === '' || password.length < 6) {
            inputvalidator.displayError('register-password', '', 'The password must be longer than 5 characters.');
            return;
        }

        $.ajax({
            url: API_URLS.SIGN_UP,
            type: 'post',
            data: {
                'email': email,
                'password': password,
                [csrfName]: csrfHash.text()
            },
            dataType: 'json',
            success: function (res) {
                csrfHash.text(res.csrfToken);
                sweatalert.showNotification("Success !", "Welcome! You have successfully Sign Up.", true, 1000);
                setTimeout(function () {
                    console.log('123');
                    window.location = BASE_URL + 'login';
                }, 1000);
            },
            error: function (error) {
                csrfHash.text(error.responseJSON.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.responseJSON.code), false, 1500);
            }
        });
    });

    /**
     * 取得用戶端錯誤訊息
     * 
     * @param {string} errorCode - 錯誤碼
     * @return {string} - 錯誤訊息內容
     */
    function getErrorMessage(errorCode) {
        let errorMessage = '';
        switch (String(errorCode)) {
            case '1002':
            case '1003':
                errorMessage = 'invalid format';
                break;
            case '1001':
                errorMessage = 'Invalid email format';
                break;
            case '1006':
                errorMessage = 'Email already exists';
                break;
            default:
                errorMessage = 'error';
                break;
        }
        return errorMessage;
    }
    inputvalidator.resetError("#register-email, #register-password");
});
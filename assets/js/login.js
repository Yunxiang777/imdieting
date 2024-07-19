/* login View JS */
$(document).ready(function () {
    var inputvalidator = new InputValidator();
    var sweatalert = new SweatAlert();
    //登入按鈕觸發
    $('.login-view').on('click', '#login-login', function () {
        var email = $("#login-email").val();
        var password = $("#login-password").val();
        var csrfHash = $("#csrfHash");
        // 驗證mail
        if (!inputvalidator.isValidEmail(email)) {
            inputvalidator.displayError('login-email', '', 'Invalid email format');
            return;
        }

        // 驗證密碼
        if (password === '') {
            inputvalidator.displayError('login-password', 'password');
            return;
        }

        $.ajax({
            url: API_URLS.LOGIN,
            type: 'post',
            data: {
                'email': email,
                'password': password,
                'checkMeOut': $("#login-checkMeOut").prop('checked'),
                [csrfName]: csrfHash.text()
            },
            dataType: 'json',
            success: function (res) {
                csrfHash.text(res.csrfToken);
                sweatalert.showNotification("Login !", "Welcome back! You have successfully logged in.", true, 1000);
                setTimeout(function () {
                    window.location = BASE_URL;
                }, 1000);
            },
            error: function (error) {
                csrfHash.text(error.responseJSON.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.responseJSON.code), false, 1500);
            }
        });
    })

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
            case '1004':
                errorMessage = 'Login failed. Please check your credentials.';
                break;
            default:
                errorMessage = 'error';
                break;
        }
        return errorMessage;
    }
    inputvalidator.resetError('#login-email, #login-password');
});
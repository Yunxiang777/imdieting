/**
 * 處理使用者輸入型態判斷與回覆
 * 
 */
class InputValidator {

    /**
     * 顯示錯誤訊息
     * 
     * @param {string} fieldId - 選擇器，指定要顯示錯誤的元素
     * @param {string} errorText - 錯誤針對的主角內容
     * @param {string} errorMessage - 自訂義錯誤內容
     */
    displayError(fieldId, errorText = '', errorMessage = '') {
        errorMessage = errorMessage ? errorMessage : "Please enter a valid value for " + errorText + ".";
        $("#" + fieldId).attr("placeholder", errorMessage);
        $("#" + fieldId).val("");
        $("#" + fieldId).addClass("is-invalid");
    }

    /**
     * 驗證字串純英文格式
     * 
     * @param {any} text - 使用者輸入
     * @return {boolean} 是否符合格式
     */
    validateText(text) {
        if (text.trim() === "") {
            return false;
        }
        var pattern = /^[a-zA-Z]+$/;

        return pattern.test(text);
    }

    /**
     * 設定點擊focus後，重置input內容的錯誤訊息
     * 
     * @param {string} fieldId - 選擇器，指定要重置錯誤的元素(一次多個元素用逗點分開)，ex:'#id1, #id2'
     */
    resetError(fieldId) {
        $(fieldId).focus(function () {
            $(this).attr("placeholder", "");
            $(this).removeClass("is-invalid");
        });
    }

    /**
     * 驗證正整數格式
     * 
     * @param {any} num - 使用者輸入的數字
     * @return {boolean} 是否符合格式
     */
    validateInt(num) {
        if (num.trim() === "") {
            return false;
        }
        var pattern = /^[1-9]\d*$/;

        return pattern.test(num);
    }

    /**
     * 驗證三位數以下正整數
     * 
     * @param {any} num - 使用者輸入的數字
     * @return {boolean} 是否符合格式
     */
    validatePositiveInteger(num) {
        if (num.trim() === "") {
            return false;
        }
        var pattern = /^\d{1,3}$/;
        return pattern.test(num) && parseInt(num) > 0;
    }

    /**
     * 驗證三位數以下，小數點最多兩位的數字
     * 
     * @param {any} num - 使用者輸入的數字
     * @return {boolean} 是否符合格式
     */
    validateNumberWithDecimals(num) {
        if (num.trim() === "") {
            return false;
        }
        var pattern = /^\d{1,3}(\.\d{1,2})?$/;
        return pattern.test(num) && parseFloat(num) > 0;
    }

    /**
     * 驗證電話格式
     * 
     * @param {any} num - 使用者輸入的電話號碼
     * @return {boolean} 是否符合格式
     */
    validatePhoneNumber(num) {
        if (num.trim() === "") {
            return false;
        }
        var pattern = /^09\d{8}$/;
        return pattern.test(num);
    }

    /**
     * 驗證自然數格式
     * 
     * @param {any} num - 使用者輸入的數字
     * @return {boolean} 是否符合格式
     */
    validateNatural(num) {
        if (num.trim() === "") {
            return false;
        }
        var pattern = /^(0|[1-9]\d*|\d+)$/;
        return pattern.test(num);
    }


    /**
     * 驗證大於零的'正整數或浮點數'
     * 
     * @param {any} num - 使用者輸入的數字
     * @return {boolean} 是否符合格式
     */
    validateFloat(num) {
        if (num.trim() === "") {
            return false;
        }
        var positiveFloatRegex = /^[1-9]\d*(\.\d+)?$/;

        return positiveFloatRegex.test(num);

    }

    /**
     * 郵件格式驗證
     * 
     * @param {string} email - 要驗證的郵件地址
     * @return {boolean} - 郵件格式驗證
     */
    isValidEmail(email) {
        if (email.trim() === "" || email.length > 255) {
            return false;
        }
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        return emailRegex.test(email);
    }
}
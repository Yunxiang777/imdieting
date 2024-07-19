/**
 * SweatAlert 自定義樣板
 * 
 */
class SweatAlert {

    /**
     * 純文字Alert，可以自定義Button的style
     * 
     * @param {string} title - 標題
     * @param {string} content - 內容，模板字符串
     * @param {string} className - Button的Class
     * @param {string} confirmButtonText - Button的內容，模板字符串
     */
    useCustomSwalAlertButton(title, content, className, confirmButtonText) {
        Swal.fire({
            title: title,
            html: content,
            showClass: {
                popup: `
                animate__animated
                animate__fadeInUp
                animate__faster
            `
            },
            hideClass: {
                popup: `
                animate__animated
                animate__fadeOutDown
                animate__faster
            `
            },
            customClass: {
                confirmButton: className,
            },
            buttonsStyling: false,
            confirmButtonText: confirmButtonText,
        });
    }

    /**
     * 純文字Alert，使用者操作的成功或失敗
     * 
     * @param {string} title - 標題
     * @param {string} content - 內容，模板字符串
     * @param {boolean} status - 執行狀態
     * @param {boolean} showConfirmButton - OK按鈕
     * @param {int} timer - 持續時間
     * @param {boolean} reload - 網頁重整
     * @param {string} redirectUrl - 網頁轉址
     */
    showNotification(title = '', content = '', status = true, timer = 1000, showConfirmButton = false, reload = false, redirectUrl = '') {
        var config = {
            title: title,
            text: content,
            icon: status ? 'success' : 'error',
            showConfirmButton: showConfirmButton,
            timer: timer
        }
        if (reload) {
            config.didClose = () => {
                location.reload();
            };
        } else if (redirectUrl) {
            config.didClose = () => {
                location.href = redirectUrl;
            };
        }
        Swal.fire(config);
    }

    /**
     * 過場動畫
     * 
     * @param {string} title - 標題
     */
    showLoading(title) {
        Swal.fire({
            title: title,
            html: "Please wait...",
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }
}
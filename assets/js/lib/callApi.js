/**
 * callApi並處理回應的自訂類
 * 
 * @requires SweatAlert sweatalert
 */
class CallApi {

    constructor() {
        this.sweatalert = new SweatAlert();
        this.form = new FormData();
        this.csrfHash = $('#csrfHash');
    }

    /**
     * callApi結果
     * 
     * @param {string} url - 請求url
     * @param {object} objectField - 附帶檔案
     * @param {boolean} showLoading - 過場
     * @param {string} successTile - 成功標題
     * @param {string} successContent - 成功內容
     * @param {string} failedTitle - 失敗標題
     * @param {string} failedContent - 失敗內容
     * @param {boolean} reload - 網頁重整
     * @param {string} redirectUrl - 網頁轉址
     */
    checkApiResult(url, objectField, showLoading = '', successTile, successContent, failedTitle, failedContent, reload = false, redirectUrl = '') {
        var config = {};

        if (showLoading) {
            var load = this.sweatalert.showLoading(showLoading);
            config.onUploadProgress = load;
        }

        this.form.append('data', JSON.stringify(objectField));
        this.form.append(csrfName, this.csrfHash.text());

        axios.post(url, this.form, config)
            .then((res) => {
                this.csrfHash.text(res.data.csrfToken);
                this.sweatalert.showNotification(successTile, successContent, true, 1000, false, reload, redirectUrl);
            })
            .catch((error) => {
                this.csrfHash.text(error.response.data.csrfToken);
                this.sweatalert.showNotification('Error', 'Error submitting the form.', false, 1000, false);
            });
    }

}

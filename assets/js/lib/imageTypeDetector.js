/**
 * 處理圖片類型與格式判斷
 * 
 */
class ImageTypeDetector {

    /**
     * 是否為預設圖片
     * 
     * @param {string} imgSrc - 圖片src內容
     * @return {boolean} 是否為預設圖片
     */
    isDefault(imgSrc) {
        return imgSrc.endsWith("default.png");
    }

    /**
     * 是否為Base64
     * 
     * @param {string} imgSrc - 圖片src內容
     * @return {boolean} 是否為Base64
     */
    isBase64(imgSrc) {
        return imgSrc.startsWith("data:image/png;base64,")
    }

    /**
     * 是否為imgur圖片
     * 
     * @param {string} imgSrc - 圖片src內容
     * @return {boolean} 是否為imgur圖片
     */
    isImgur(imgSrc) {
        return imgSrc.startsWith("https://i.imgur.com/")
    }

    /**
     * 判斷圖片類型與格式
     * 
     * @param {string} imgSrc - 圖片src內容
     * @return {object} 圖片對象
     */
    setImage(imgSrc) {
        var img = { 'src': imgSrc };
        if (this.isDefault(imgSrc)) {
            img.src = '';
            img.type = 'default';
        } else if (this.isBase64(imgSrc)) {
            img.src = imgSrc.replace("data:image/png;base64,", "");
            img.type = 'base64';
        } else if (this.isImgur(imgSrc)) {
            img.type = 'imgur';
        }
        return img;
    }
}
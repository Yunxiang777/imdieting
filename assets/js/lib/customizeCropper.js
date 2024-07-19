/**
 * Cropper 自定義樣板
 * 
 */
class CustomizeCropper {

    /**
     * CustomizeCropper 建構子
     * 
     * @param {string} containClass - 主容器的class
     * @param {string} trigger - 觸發事件按鈕
     * @param {string} containView - 使用模板的容器檔名
     * @param {string} resultImage - 裁剪結果放置區塊
     */
    constructor(containClass, trigger, containView, resultImage) {
        this.cropper = null;
        this.containClass = containClass;
        this.trigger = trigger;
        this.modelInput = '#' + containView + '-inputImage';
        this.cropModal = '#' + containView + '-cropModal';
        this.confirmCropButton = '#' + containView + '-confirmCrop';
        this.cancelCropButton = '#' + containView + '-cancelCrop';
        this.closeCropButton = '#' + containView + '-closeButton';
        this.modelImage = '#' + containView + '-cropperImage';
        this.resultImage = resultImage;
        this.rectangleWidth = '';
        this.rectangleHeight = '';
    }

    /**
     * 選擇矩形裁剪方法
     * 
     * @param {number} rectangleWidth - 裁剪寬度
     * @param {number} rectangleHeight - 裁剪高度
     */
    useRectangle(rectangleWidth, rectangleHeight) {
        this.rectangleWidth = rectangleWidth;
        this.rectangleHeight = rectangleHeight;
        $(this.containClass)
            .on('click', this.trigger, () => this.#openCropModal())
            .on('change', this.modelInput, (event) => this.#handleImageChange(event))
            .on('click', this.confirmCropButton, () => this.#confirmCrop())
            .on('click', this.cancelCropButton, () => this.#cancelCrop())
            .on('click', this.closeCropButton, () => this.#cancelCrop());
    }

    /**
     * 打開model視窗
     * 
     * Private method.
     */
    #openCropModal() {
        $(this.modelInput).val('');
        $(this.cropModal)
            .modal('show')
            .on('hidden.bs.modal', () => { this.#destroyCropper() });
    }

    /**
     * 讀取檔案，被依照需求置入裁剪框
     * Private method.
     * 
     * @param {Event} event - Change event object.
     */
    #handleImageChange(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = (e) => {
                $(this.modelImage).attr('src', e.target.result);
                this.cropper = new Cropper($(this.modelImage)[0], {
                    aspectRatio: this.rectangleWidth / this.rectangleHeight,
                    viewMode: 2,
                });
            };

            reader.readAsDataURL(file);
        }
    }

    /**
     * 確認裁剪
     * Private method.
     */
    #confirmCrop() {
        var croppedCanvas = this.cropper.getCroppedCanvas({
            width: this.rectangleWidth,
            height: this.rectangleHeight,
        });
        $(this.resultImage).attr('src', croppedCanvas.toDataURL());
        this.#destroyCropper();
        $(this.cropModal).modal('hide');
    }

    /**
     * 取消裁剪
     * Private method.
     */
    #cancelCrop() {
        $(this.modelImage).attr('src', '');
        this.#destroyCropper();
        $(this.cropModal).modal('hide');
    }

    /**
     * 重置
     * Private method.
     */
    #destroyCropper() {
        if (this.cropper) {
            this.cropper.destroy();
        }
    }
}

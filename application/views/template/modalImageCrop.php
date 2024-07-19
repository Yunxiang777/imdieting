<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/modalImageCrop.css?v=' . time()) ?>">
<!-- Modal for image cropping -->
<div class="modal fade modalImageCrop-view" id="<?= $view ?>-cropModal" tabindex="-1" role="dialog" aria-labelledby="<?= $view ?>-cropModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $view ?>-cropModalLabel">Crop Image</h5>
                <button type="button" class="modalImageCrop-close" data-dismiss="modal" aria-label="Close" id="<?= $view ?>-closeButton">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control" id="<?= $view ?>-inputImage" accept="image/*">
                <div class="mt-3">
                    <img id="<?= $view ?>-cropperImage" class="img-fluid">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="<?= $view ?>-cancelCrop">Cancel</button>
                <button type="button" class="btn btn-primary" id="<?= $view ?>-confirmCrop">Confirm</button>
            </div>
        </div>
    </div>
</div>
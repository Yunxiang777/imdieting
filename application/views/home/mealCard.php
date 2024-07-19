<div class="container mealCard-view">
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-lg-8 order-last order-lg-first">
                <img src="<?= base_url() . 'assets/img/lunch.png' ?>" class="img-fluid rounded-start mealCard-img" alt="mealCard" id="mealCard-img">
            </div>
            <div class="col-lg-4 order-first order-lg-last">
                <div class="mealCard-card">
                    <div class="mealCard-card-top">
                        <h1 class="card-title">Record Food</h1>
                        <p>Allows users to effortlessly track and log their dietary intake.
                            Managing your weight, or monitoring specific
                            nutritional goals.
                            <small class="mealCard-smallText-one">Click to open
                                the camera.</small>
                        </p>
                        <p class="card-text mealCard-smallText-two"><small class="text-body-secondary ">Click to open
                                the camera.</small></p>
                    </div>
                    <div class="mealCard-card-bottom">
                        <img src="<?= base_url('assets/img/camera.png') ?>" alt="camera" class="mealCard-img-camera" id="mealCard-img-camera">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for image cropping -->
    <?php $this->load->view('template/modalImageCrop', ['view' => 'mealCard']); ?>
</div>
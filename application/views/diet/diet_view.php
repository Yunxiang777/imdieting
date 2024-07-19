<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/diet_view.css?v=' . time()) ?>">
<div class="container diet-view" id="diet-view">
    <div class="row">
        <?php $this->load->view('diet/leftContent') ?>
        <?php $this->load->view('diet/rightContent')
        ?>
    </div>
</div>
<script src="<?= base_url('assets/js/diet.js?v=' . time()) ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/home_view.css?v=' . time()) ?>">
<?php $this->load->view('home/bmr') ?>
<?php $this->load->view('home/calorieLookup') ?>
<?php $this->load->view('home/mealCard') ?>
<script src="<?= base_url('assets/js/home.js?v=' . time()) ?>"></script>
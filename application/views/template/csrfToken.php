<script>
    var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
</script>
<div style="display: none;" id="csrfHash"><?= $this->security->get_csrf_hash(); ?></div>
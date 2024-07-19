<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 前端共享 元件 -->
    <?php $this->load->view('template/commonUrl_view'); ?>
    <!-- Anti Csrf Token -->
    <?php $this->load->view('template/csrfToken'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- font-awesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Cropper.js CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css" integrity="sha384-1arqhTHsGLPVJdhZo8SAycbI+y5k+G7khi5bTZ4BxHJIpCfvWoeSDgXEXXRxB/9G" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- bootstrap5.3 CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery-3.6.4 JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <!-- bootstrap.bundle5.3 JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- SweetAlert2 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css" integrity="sha384-nDCjuNO5QiaYio93B6lMFlThudP0eJJF+xeIuJt8sHv9tsEgRdj8dBuA85giOZco" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- animate CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha384-Gu3KVV2H9d+yA4QDpVB7VcOyhJlAVrcXd0thEjr4KznfaFPLe0xQJyonVxONa4ZC" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" integrity="sha384-Oapd3DvPeXtjgp4dZhVuEpPpwgE9OOzAeNAp0y3TrgcF3TxLkDhk5/4JMvN5453i" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <!-- navbar 元件 -->
    <?php $this->load->view('template/navbar_view'); ?>

    <!-- 主要內容 -->
    <?= $content ?>

    <!--  footer 元件 -->
    <?php $this->load->view('template/footer_view'); ?>

    <!-- imdieting JS library 元件 -->
    <?php $this->load->view('template/imdietingJsLibrary'); ?>

    <!-- sweetalert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js" integrity="sha384-FhPi0p8Se3dPr+DRNCN0n6Piepz0tdabOW42kti/UFg4yMMrKQyehXkdMlrwSH3P" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Cropper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js" integrity="sha384-P65gU1u4/dZpqRQ0AVqW+DHPwXmNAR84Qk31dC95hjk0WatF1GsVF1zRm/0uB+o0" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
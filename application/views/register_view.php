<div class="container register-view" style="margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
            <form>
                <div class="mb-3">
                    <label for="register-email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="register-email" aria-describedby="register-emailHelp">
                </div>
                <div class="mb-3">
                    <label for="register-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="register-password">
                </div>
                <button type="button" class="btn btn-outline-success" id="register-register">Register</button>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/register.js?v=' . time()) ?>"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-view">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url() ?>">Imdieting</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'home' ? 'active' : '' ?>" aria-current="page" href="<?= base_url('home') ?>">Home</a>
                </li>
                <?php if ($this->session->userdata('loggedIn')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page === 'diet' ? 'active' : '' ?>" aria-current="page" href="<?= base_url('diet') ?>">Diet</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $this->session->userdata('memberImg') ?>" alt="User Avatar" class="rounded-circle" width="20" height="20" onerror="this.onerror=null; this.src='<?= base_url('assets/img/default.png') ?>';" id="navbar-avatarImg">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?= $page === 'profile' ? 'active' : '' ?>" href="<?= base_url('profile') ?>">Profile Settings</a></li>
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
            </ul>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link <?= $page === 'article' ? 'active' : '' ?>" aria-current="page" href="<?= base_url('article') ?>">Article</a>
        </li>
        </ul>
        <?php if (!$this->session->userdata('loggedIn')) : ?>
            <button class="btn btn-outline-success" type="button" id="navbar-login" onclick="window.location.href='<?= base_url('login') ?>'">LogIn</button>
        <?php endif; ?>
        </div>
    </div>
</nav>
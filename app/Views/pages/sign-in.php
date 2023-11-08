<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<main class="main-content  mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-0">
              <div class="card-header pb-0 text-left bg-transparent">
                <div class="text-center">
                  <img src="public/assets/img/logo.png" alt="" class="img-fluid" width="50%">
                  <h3 class="font-weight-bolder text-info text-gradient">Selamat Datang</h3>
                  <p class="mb-0">Silakan masukkan username dan password untuk masuk ke sistem</p>
                </div>
              </div>
              <div class="card-body">
                <?php if (session()->getFlashdata('msg')) : ?>
                  <div class="alert alert-danger fade show text-light alert-error" role="alert">
                    <?= session()->getFlashdata('msg'); ?>
                  </div>
                <?php endif; ?>
                <form action="<?= base_url()?>/login/auth" method="post" role="form">
                  <label>Username</label>
                  <div class="mb-3">
                    <input type="username" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="email-addon">
                  </div>
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="remember" value="remember" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?= $this->endSection() ?>
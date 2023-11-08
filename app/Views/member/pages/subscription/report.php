<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<main class="main-content  mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-10 d-flex flex-column mx-auto">
            <div class="card card-plain mt-0">
              <div class="card-header pb-0 text-left bg-transparent">
                <div class="text-center">
                  <img src="<?= base_url()?>/public/assets/img/logo.png" alt="" class="img-fluid" width="50%">
                </div>
              </div>
              <div class="card-body">
                <center>
                  <h2>Certificate to</h2>
                  <h3 style="color: #56688d;"><?= $nama_member?></h3>
                  <h5 style="color: #56688d;"><i>For outstanding achievements and results in participating in and completing <?= $nama_program?> Program</i></h5>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?= $this->endSection() ?>
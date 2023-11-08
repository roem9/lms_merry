<?= $this->extend('member/layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('<?= base_url()?>/public/assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
    <span class="mask bg-gradient-primary opacity-6"></span>
  </div>
  <div class="card card-body mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
      <!-- <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="../../../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div> -->
      <div class="col-auto my-auto">
        <div class="h-100">
          <h6 class="mb-1">
            <?= $profile['nama_member'] ?>
          </h6>
          <p class="mb-2 text-sm">
            <span class="me-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
              </svg>
            </span>
            <?= $profile['no_wa'] ?>
          </p>
          <p class="mb-2 text-sm">
            <span class="me-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-fill" viewBox="0 0 16 16">
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z" />
              </svg>
            </span>
            <?= $profile['t4_lahir'] . ", " . date("d M Y", strtotime($profile['tgl_lahir'])) ?>
          </p>
          <p class="mb-2 text-sm">
            <span class="me-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
              </svg>
            </span>
            <?= $profile['alamat'] ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('member/layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <h5>List Pertemuan</h5>
      <p>Menu ini berisikan list pertemuan yang ada dalam program <?= $title ?></p>
    </div>
  </div>
  <div class="row mt-lg-4 mt-2">
    <div class="card">
      <div class="card-body">
        <?php foreach ($pertemuanProgram as $pertemuan) : ?>
          <div class="timeline timeline-one-side" data-timeline-axis-style="dotted" id="listMateriPertemuan">
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <?php if ($pertemuan['statusPertemuan'] == 'belum tersedia') : ?>
                  <i class="ni ni-fat-remove text-danger text-gradient"></i>
                <?php elseif ($pertemuan['statusPertemuan'] == 'selesai' || $pertemuan['statusPertemuan'] == 'belum selesai') : ?>
                  <i class="ni ni-check-bold text-success text-gradient"></i>
                <?php endif; ?>

              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-2">
                  <?= $pertemuan['nama_pertemuan'] ?>
                </h6>
                <p class="text-sm mt-3 mb-2">
                  <?= $pertemuan['deskripsi'] ?>
                </p>
                <div class="mt-1">
                  <?php if ($pertemuan['statusPertemuan'] == 'belum tersedia') : ?>
                    <a href='javascript:void(0)'><span class="badge badge-sm bg-gradient-secondary me-1">mulai</span></a>
                  <?php elseif ($pertemuan['statusPertemuan'] == 'selesai' || $pertemuan['statusPertemuan'] == 'belum selesai') : ?>
                    <a href="<?= $pertemuan['linkMateri'] ?>"><span class="badge badge-sm bg-gradient-info me-1">mulai</span></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if ($kelas['sertifikat'] == 1) : ?>
          <div class="timeline timeline-one-side" data-timeline-axis-style="dotted" id="listMateriPertemuan">
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="ni ni-paper-diploma text-warning text-gradient"></i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-2">
                  Sertifikat
                </h6>
                <p class="text-sm mt-3 mb-2">
                  Selamat, Anda telah berhasil menyelesaikan program ini!. Silakan download sertifikat Anda di menu subscription
                </p>
                <div class="mt-1">
                  <a href="<?= base_url()?>/mySubscription">
                    <span class="badge badge-sm bg-gradient-warning me-1">Download</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<?= $this->endSection() ?>
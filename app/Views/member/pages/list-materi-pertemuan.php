<?= $this->extend('member/layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <h5>List Materi</h5>
      <p><?= $deskripsi ?></p>
    </div>
  </div>
  <div class="row mt-lg-4 mt-2">
    <div class="card">
      <div class="card-body">
        <?php foreach ($materi as $materi) : ?>
          <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="ni <?= $materi['icon'] ?> text-gradient"></i>
              </span>
              <div class="timeline-content">
                <?= $materi['data'] ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if(!empty($navigasi['status'])) :?>
          <?php if($navigasi['status'] == 'lengkap') :?>
            <div class="d-flex justify-content-between">
              <a href="<?= base_url()?>/<?= $navigasi['before']?>"><span class="badge badge-sm bg-gradient-success me-1"><i class="ni ni-bold-left"></i></span></a>
              <a href="<?= base_url()?>/<?= $navigasi['next']?>"><span class="badge badge-sm bg-gradient-success me-1"><i class="ni ni-bold-right"></i></span></a>
            </div>
          <?php elseif($navigasi['status'] == 'before') :?>
            <div class="d-flex justify-content-start">
              <a href="<?= base_url()?>/<?= $navigasi['before']?>"><span class="badge badge-sm bg-gradient-success me-1"><i class="ni ni-bold-left"></i></span></a>
            </div>
          <?php elseif($navigasi['status'] == 'next') :?>
            <div class="d-flex justify-content-end">
              <a href="<?= base_url()?>/<?= $navigasi['next']?>"><span class="badge badge-sm bg-gradient-success me-1"><i class="ni ni-bold-right"></i></span></a>
            </div>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<?= $this->endSection() ?>
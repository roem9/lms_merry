<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="row mt-4">
    <div class="col-12">
      <div class="card ">
        <div class="card-header pb-0 p-3">
          <div class="d-flex justify-content-between">
            <h6 class="mb-2">Laporan Bulanan</h6>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center ">
            <tbody>
              <?php
              if ($laporan) :
                foreach ($laporan as $laporan) : ?>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">Periode:</p>
                          <h6 class="text-sm mb-0"><?= $laporan['periode'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Subscription:</p>
                        <h6 class="text-sm mb-0"><?= $laporan['subscription'] ?></h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Peserta:</p>
                        <h6 class="text-sm mb-0"><?= $laporan['student'] ?></h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Kelas:</p>
                        <h6 class="text-sm mb-0"><?= $laporan['class'] ?></h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <a target="_blank" href="<?= base_url() ?>/exportLaporan/<?= $laporan['month'] ?>/<?= $laporan['year'] ?>" class='btn btn-sm bg-gradient-success'>
                          kelas
                        </a>
                        <a target="_blank" href="<?= base_url() ?>/exportLaporanSubscription/<?= $laporan['month'] ?>/<?= $laporan['year'] ?>" class='btn btn-sm bg-gradient-success'>
                          Subscription
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td>
                    <div class="alert alert-warning text-light" role="alert">
                      Laporan Bulanan Kosong
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
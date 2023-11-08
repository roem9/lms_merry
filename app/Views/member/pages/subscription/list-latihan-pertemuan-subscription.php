<?= $this->extend('member/layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="row row-cards FieldContainer" data-masonry='{"percentPosition": true }'>
      <div class="shadow card mb-3 soal">
        <div class="card-body">
          <?= session()->getFlashdata('pesan'); ?>
        </div>
      </div>
    </div>
  <?php else : ?>
    <?php if (!isset($ulang) || (isset($ulang) && $ulang)) : ?>
      <div class="row">
        <div class="col-md-8 me-auto text-left">
          <p><?= $deskripsi ?></p>
        </div>
        <!-- <div class="col d-flex justify-content-end mb-3">
          <div>
            <div class="ms-auto my-auto">
              <button type="button" class="btn bg-gradient-success btn-sm mb-0 btnSimpan">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                  <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                </svg>
                Simpan
              </button>
            </div>
          </div>
        </div> -->
      </div>
      <div class="col-12">
        <form action="<?= base_url()?>/addLatihanSubscription" method="post" id="formLatihan">
          <input type="hidden" name="fk_id_pertemuan" value="<?= $fk_id_pertemuan ?>">
          <input type="hidden" name="fk_id_subscription_member" value="<?= $fk_id_subscription_member ?>">
          <?php foreach ($latihan as $i => $latihan) : ?>
            <div class="card mb-3">
              <div class="card-body">
                <?= $latihan['data'] ?>
              </div>
            </div>
          <?php endforeach; ?>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn bg-gradient-success btn-sm mb-0 btnSimpan">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
              </svg>
              Simpan
            </button>
          </div>
        </form>
      </div>
    <?php else : ?>
      <?= $pesan ?>
    <?php endif; ?>
  <?php endif; ?>
</section>
<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  $('input[type="radio"]').on('click', function() {
    if ($(this).is(':checked')) {
      var value = $(this).val();
      var jawaban = $(this).data("jawaban");
      $(`[name='${jawaban}' ]`).val(value);
      $(`[name='${jawaban}' ]`).parent().css("border", "none");
    }
  });

  $(".btnSimpan").on("click", function() {
    let isFilled = cekForm();
    if (isFilled) {
      Swal.fire({
        title: `Apa Anda yakin akan menyimpan pekerjaan Anda?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!'
      }).then((result) => {
        if (result.isConfirmed) {
          $("#formLatihan").submit();
        }
      })
    } else {
      Swal.fire({
        title: `Apa Anda yakin akan menyimpan pekerjaan Anda?`,
        text: "Anda belum menyelesaikan pekerjaan Anda!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!'
      }).then((result) => {
        if (result.isConfirmed) {
          $("#formLatihan").submit();
        }
      })
    }
  })

  function cekForm() {
    isFilled = true;

    $("[name^='jawaban']").each(function() {
      var val = $(this).val();
      if (val == 'null' || val == "") {
        isFilled = false;
        $(this).parent().css("border", "2px solid red");
      } else {
        $(this).parent().css("border", "none");
      }
    });

    return isFilled;
  }
</script>
<?= $this->endSection() ?>
<?= $this->extend('member/layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <h5>List Subscription</h5>
      <p>Menu ini berisikan list program langganan Anda</p>
    </div>
  </div>
  <div class="row mt-lg-4 mt-2" id="listOfKelas">

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Call function showData on loaded content
    showData();
  });

  function alertSertifikat() {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Anda harus menyelesaikan kelas terlebih dahulu untuk mengklaim sertifikat'
    })
  }

  function showData() {
    $.ajax({
      url: '<?= base_url()?>/memberArea/getAllSubscription',
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)

        const listOfKelas = $("#listOfKelas");
        let obj = {};
        let html = ``;

        for (var i = 0; i < data.length; i++) {
          obj = data[i];

          let sertifikat = '';
          if (obj.sertifikat == 1) {
            sertifikat = `
              <a href='<?= base_url()?>/sertifikatsubscription/${obj.certificateId}' target="_blank">
                <span class="badge bg-gradient-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                  </svg>
                </span>
              </a>
            `
          } else {
            sertifikat = `
              <a href='javascript:void(0)' onclick='alertSertifikat()'>
                <span class="badge bg-gradient-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                  </svg>
                </span>
              </a>
            `
          }

          let btnMulai = "";
          let noteLangganan = "";

          if(obj.isActive == true){
            btnMulai = `
              <a href='<?= base_url()?>/subscription/${obj.classId}'>
                <span class="badge bg-gradient-success">Masuk</span>
              </a>
              <p class="text-secondary text-sm font-weight-bold mb-0">Mulai</p>
            `
          } else {
            noteLangganan = "<br><span class='text-danger'>(langganan Anda telah berakhir)</span>"
          }

          html += `
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="d-flex">
                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-2">
                      <img src="<?= base_url()?>/public/assets/img-program/${obj.image}" alt="gambar ${obj.nama_program}" onerror="this.onerror=null; this.src='<?= base_url()?>/public/assets/img/curved-images/white-curved.jpg'">
                    </div>
                    <div class="ms-3 my-auto">
                      <h6>${obj.nama_program}</h6>
                    </div>
                  </div>
                  <p class="text-sm mt-3"> ${obj.deskripsi} </p>
                  <p class="text-xxs"> ${obj.tgl_mulai} s.d ${obj.tgl_berakhir} ${noteLangganan}</p>
                  <hr class="horizontal dark">
                  <div class="row">
                    <div class="col">
                      ${sertifikat}
                      <p class="text-secondary text-sm font-weight-bold mb-0">Sertifikat</p>
                    </div>
                    <div class="col">
                      <div class="progress-wrapper mt-0">
                        <div class="progress-info">
                          <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">${obj.progress}%</span>
                          </div>
                        </div>
                        <div class="progress">
                          <div class="progress-bar bg-info" role="progressbar" aria-valuenow="${obj.progress}" aria-valuemin="0" aria-valuemax="100" style="width: ${obj.progress}%;"></div>
                        </div>
                      </div>
                      <p class="text-secondary text-sm font-weight-bold mb-0">Progress</p>
                    </div>
                    <div class="col text-end">
                      ${btnMulai}
                    </div>
                  </div>
                </div>
              </div>
            </div>`
        }

        listOfKelas.html(html);
      }

    });
  }
</script>
<?= $this->endSection() ?>
<?= $this->extend('pengajar/layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <h5>List Kelas</h5>
      <p><?= $description?></p>
    </div>
    <div class="col-12">
      <form action="<?= base_url()?>/pengajarArea/changePeriode" method="POST" class="mb-3" id="form">
        <div class="row g-2">
            <div class="col-md-3 col-sm-12">
                <select name="bulan" class="form form-control form-control-sm" required>
                    <option value="">Semua Bulan</option>
                    <option value="01" <?php if($pengajar['bulan'] == "01") echo "selected";?>>Januari</option>
                    <option value="02" <?php if($pengajar['bulan'] == "02") echo "selected";?>>Februari</option>
                    <option value="03" <?php if($pengajar['bulan'] == "03") echo "selected";?>>Maret</option>
                    <option value="04" <?php if($pengajar['bulan'] == "04") echo "selected";?>>April</option>
                    <option value="05" <?php if($pengajar['bulan'] == "05") echo "selected";?>>Mei</option>
                    <option value="06" <?php if($pengajar['bulan'] == "06") echo "selected";?>>Juni</option>
                    <option value="07" <?php if($pengajar['bulan'] == "07") echo "selected";?>>Juli</option>
                    <option value="08" <?php if($pengajar['bulan'] == "08") echo "selected";?>>Agustus</option>
                    <option value="09" <?php if($pengajar['bulan'] == "09") echo "selected";?>>September</option>
                    <option value="10" <?php if($pengajar['bulan'] == "10") echo "selected";?>>Oktober</option>
                    <option value="11" <?php if($pengajar['bulan'] == "11") echo "selected";?>>November</option>
                    <option value="12" <?php if($pengajar['bulan'] == "12") echo "selected";?>>Desember</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-12">
                <!-- <div class="form-floating mb-3"> -->
                    <select name="tahun" class="form form-control form-control-sm" required>
                        <option value="">Semua Tahun</option>
                        <option value="2022" <?php if($pengajar['tahun'] == 2022) echo "selected";?>>2022</option>
                        <?php
                            $tahun_now = date("Y");
                            for ($i=2023; $i < $tahun_now + 1; $i++) :?>
                                <option value="<?= $i?>" <?php if($pengajar['tahun'] == $i) echo "selected";?>><?= $i?></option>
                        <?php endfor;?>
                    </select>
                <!-- </div> -->
            </div>
            <div class="col-auto">
                <a href="javascript:{}" onclick="document.getElementById('form').submit(); return false;" class="btn btn-icon btn-success btn-sm" aria-label="Button">
                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><circle cx="12" cy="14" r="2" /><polyline points="14 4 14 8 8 8 8 4" /></svg> -->
                    GO!
                </a>
            </div>
        </div>
      </form>
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
      url: '<?= base_url()?>/pengajarArea/getAllKelas',
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)

        // console.log(data)
        const listOfKelas = $("#listOfKelas");
        let obj = {};
        let html = ``;

        for (var i = 0; i < data.length; i++) {
          obj = data[i];

          let sertifikat = '';
          if (obj.sertifikat == 1) {
            sertifikat = `
              <a href='<?= base_url()?>/sertifikat/${obj.certificateId}' target="_blank">
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
          html += `
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="d-flex">
                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-2">
                      <img src="<?= base_url()?>/public/assets/img-program/${obj.image}" alt="gambar ${obj.nama_program}" onerror="this.onerror=null; this.src='<?= base_url()?>/public/assets/img/curved-images/white-curved.jpg'">
                    </div>
                    <div class="ms-3 my-auto">
                      <h6>${obj.nama_kelas}</h6>
                      <div class="avatar-group">
                        ${obj.nama_program}
                      </div>
                    </div>
                  </div>
                  <p class="text-sm mt-3"> ${obj.deskripsi} </p>
                  <p class="text-sm"> 
                    Tgl Mulai : ${obj.tgl_mulai} <br>
                    Peserta : ${obj.peserta} 
                  </p>
                  <hr class="horizontal dark">
                  <div class="row">
                    <div class="col text-end">
                      <a href='<?= base_url()?>/class/${obj.classId}'>
                        <span class="badge bg-gradient-success">Masuk</span>
                      </a>
                      
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
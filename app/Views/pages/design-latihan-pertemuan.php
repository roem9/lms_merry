<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <!-- <h5>List Program</h5> -->
      <p><?= $deskripsi ?></p>
    </div>
    <div class="col d-flex justify-content-end mb-3">
      <div>
        <div class="ms-auto my-auto d-none d-md-none d-lg-block">
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalLatihanPertemuan" data-bs-toggle="modal" data-bs-target="#modalLatihanPertemuan">+&nbsp; Item Baru</a>
        </div>
        <div class="ms-auto my-auto d-block d-md-block d-lg-none">
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalLatihanPertemuan" data-bs-toggle="modal" data-bs-target="#modalLatihanPertemuan">+&nbsp;</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12" id="listLatihanPertemuan">
  </div>
  <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalLatihanPertemuan w-100" data-bs-toggle="modal" data-bs-target="#modalLatihanPertemuan">+&nbsp; Item Baru</a>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Modal Add Data Program-->
<div class="modal fade" id="modalLatihanPertemuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLatihanPertemuanLabel">Tambah Materi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLatihanPertemuan">
          <!-- KALAU SUKSES -->
          <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
            <div class="sukses"></div>
          </div>
          <!-- KALAU ERROR -->
          <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
            <div class="error"></div>
          </div>
          <input type="hidden" name="fk_id_pertemuan" id="fk_id_pertemuan" value="<?= $id_pertemuan ?>">
          <input type="hidden" name="id_latihan" id="id_latihan">
          <div class="col-12 mb-3">
            <label for="item">Item</label>
            <select name="item" id="item" class="multisteps-form__input form-control">
              <option value="">Pilih Item</option>
              <option value="petunjuk">Petunjuk / Teks</option>
              <option value="soal-pg">Soal Pilihan Ganda</option>
              <option value="soal-esai">Soal Esai</option>
              <option value="audio">Audio</option>
              <option value="image">Image</option>
              <option value="video">Video</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Nama File</label>
            <input name="nama_file" id="nama_file" class="multisteps-form__input form-control" type="text" placeholder="nama file" disabled>
          </div>
          <div class="formItem" id="form-petunjuk" style="display:none">
            <div class="form-group">
              <label for="text">Text</label>
              <textarea name="text" class="form-control" id="text" rows="3"></textarea>
            </div>
          </div>
          <div class="formItem" id="form-soal-pg" style="display:none">
            <div class="form-group">
              <label for="soal-pg">Soal PG</label>
              <textarea name="soal-pg" class="form-control" id="soal-pg" rows="3"></textarea>
            </div>
            <div id="pg" class="mt-3">
              <?php for ($i = 1; $i < 5; $i++) : ?>
                <div class="form-group mb-2" id="pg-<?= $i ?>">
                  <label for="pg<?= $i ?>">Pilihan <?= $i ?></label>
                  <textarea name="pg" class="form-control pg" id="pg<?= $i ?>"></textarea>
                </div>
              <?php endfor; ?>
            </div>
            <div class="d-flex justify-content-center">
              <a href="javascript:void(0)" onclick="ubahPgOption('remove')">
                <span class="badge bg-gradient-danger me-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z" />
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" onclick="ubahPgOption('add')">
                <span class="badge bg-gradient-success">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                  </svg>
                </span>
              </a>
            </div>
            <div class="col-12 mb-3">
              <label for="jawaban-pg">Jawaban</label>
              <select name="jawaban-pg" id="jawaban-pg" class="multisteps-form__input form-control">
              </select>
            </div>
          </div>
          <div class="formItem" id="form-soal-esai" style="display:none">
            <div class="form-group">
              <label for="soal-esai">Soal Esai</label>
              <textarea name="soal-esai" class="form-control" id="soal-esai" rows="3"></textarea>
            </div>
            <div class="form-group mb-2">
              <label for="jawaban-esai">Jawaban Esai</label>
              <textarea name="jawaban-esai" class="form-control pg" id="jawaban-esai" rows="3"></textarea>
            </div>
          </div>
          <div class="formItem" id="form-image" style="display:none">
            <div class="mb-3">
              <label for="file_image" class="form-label">File Image</label>
              <input name="file_image" class="form-control" type="file" id="file_image">
            </div>
          </div>
          <div class="formItem" id="form-video" style="display:none">
            <div class="form-group">
              <label for="video">Link Youtube Video</label>
              <textarea name="video" class="form-control" id="video" rows="3"></textarea>
            </div>
          </div>
          <div class="formItem" id="form-audio" style="display:none">
            <div class="mb-3">
              <label for="file_audio" class="form-label">File Audio</label>
              <input name="file_audio" class="form-control" type="file" id="file_audio">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-info" id="btnSimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Call function showData on loaded content
    showData(<?= $id_pertemuan ?>);

    // kumpulan component
    const btnSimpan = $("#btnSimpan");
    const btnModalLatihanPertemuan = $(".btnModalLatihanPertemuan");

    // kumpulan even listener
    btnSimpan.on("click", simpanLatihanPertemuan);
    btnModalLatihanPertemuan.on("click", showModalLatihanPertemuan);

    // form validation item materi
    $("#formLatihanPertemuan #item").on('change', function() {
      let data = $(this).val();
      $("#formLatihanPertemuan #nama_file").val("")

      if (data == 'petunjuk') {
        $(".formItem").hide();
        $("#form-petunjuk").show()
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);
      } else if (data == 'soal-pg') {
        $(".formItem").hide();
        $("#form-soal-pg").show()
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);
      } else if (data == 'soal-esai') {
        $(".formItem").hide();
        $("#form-soal-esai").show()
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);
      } else if (data == 'audio') {
        $(".formItem").hide();
        $("#form-audio").show()
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', false);
      } else if (data == 'image') {
        $(".formItem").hide();
        $("#form-image").show();
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', false);
      } else if (data == 'video') {
        $(".formItem").hide();
        $("#form-video").show()
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);
      } else {
        $(".formItem").hide();
        $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);
      }
    })

    CKEDITOR.replace('text');
    CKEDITOR.replace('soal-pg');
    CKEDITOR.replace('soal-esai');

    $("#moveSelected").on('change', function() {
      let url = $(this).val()
      window.location.href = "<?= base_url()?>/program/" + url
    })
  });

  let pgCount = 4;

  $(`#formLatihanPertemuan`).on('keyup', '.pg', function() {
    $("#jawaban-pg").val('')
  })

  function ubahPgOption(action) {
    if (action == 'add') {
      pgCount++
      $("#pg").append(`
        <div class="form-group mb-2" id="pg-${pgCount}">
          <label for="pg${pgCount}">Pilihan ${pgCount}</label>
          <textarea name="pg" class="form-control pg" id="pg${pgCount}"></textarea>
        </div>`)

      $("#jawaban-pg").append(`<option value="pg${pgCount}">Pilihan ${pgCount}</option>`);
      $("#jawaban-pg").val('')
    } else {
      if (pgCount > 2) {
        $(`#pg-${pgCount}`).remove();
        $(`#jawaban-pg option[value='pg${pgCount}']`).remove();
        $("#jawaban-pg").val('')
        pgCount--
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Pilihan minimal 2!'
        })
      }
    }

  }
  // kumpulan function

  function showModalLatihanPertemuan() {
    $('#modalLatihanPertemuanLabel').html('Tambah Item');

    bersihkanFormLatihanPertemuan()
    CKEDITOR.instances['text'].setData('');
    CKEDITOR.instances['soal-pg'].setData('');
    CKEDITOR.instances['soal-esai'].setData('');

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  function bersihkanFormLatihanPertemuan() {
    $("#formLatihanPertemuan #id_latihan").val("")
    $("#formLatihanPertemuan #item").val("")
    $("#formLatihanPertemuan #nama_file").val("")
    $("#formLatihanPertemuan #jawaban-esai").val("")
    $("#formLatihanPertemuan #file_image").val("")
    $("#formLatihanPertemuan #video").val("")
    $("#formLatihanPertemuan #file_audio").val("")

    $(`#formLatihanPertemuan #item`).prop('disabled', false);
    $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);

    $(".formItem").hide()

    pgCount = 4;
    let pilihan = '';
    let jawaban = '<option value="">Pilih Jawaban</option>';

    for (let i = 0; i < pgCount; i++) {
      pilihan += `<div class="form-group mb-2" id="pg-${i+1}">
                    <label for="pg${i+1}">Pilihan ${i+1}</label>
                    <textarea name="pg" class="form-control pg" id="pg${i+1}"></textarea>
                  </div>`
      jawaban += `<option value="pg${i+1}">Pilihan ${i+1}</option>`;

    }

    $("#pg").html(pilihan);
    $("#jawaban-pg").html(jawaban);
    $("#jawaban-pg").val('')
  }

  // show data from database
  function showData(id_pertemuan) {
    $.ajax({
      url: `<?= base_url()?>/program/getAllLatihanPertemuan/${id_pertemuan}`,
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)

        const listLatihanPertemuan = $("#listLatihanPertemuan");
        let obj = {};
        let html = ``;
        let icon = '';
        let content = '';

        let latihan = '';
        let urutan = '';
        let action = '';

        if (data.length > 0) {
          let nomor = 0;
          for (var i = 0; i < data.length; i++) {
            obj = data[i];

            // urutan 
            if (i == 0) {
              if (data.length == 1) {
                urutan = `<span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                          </span>
                          <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                          <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                          </span>`
              } else {
                urutan = `<span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                          </span>
                          <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                          <span onclick="ubahUrutanLatihan(${obj.id_latihan}, ${obj.urutan}, 'turun', ${data[i+1].id_latihan})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                            </svg>
                          </span>`
              }
            } else if (i == data.length - 1) {
              urutan = `<span onclick="ubahUrutanLatihan(${obj.id_latihan}, ${obj.urutan}, 'naik', ${data[i-1].id_latihan})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                          </svg>
                        </span>
                        <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                          </svg>
                        </span>`
            } else {
              urutan = `<span onclick="ubahUrutanLatihan(${obj.id_latihan}, ${obj.urutan}, 'naik', ${data[i-1].id_latihan})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                          </svg>
                        </span>
                        <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                        <span onclick="ubahUrutanLatihan(${obj.id_latihan}, ${obj.urutan}, 'turun', ${data[i+1].id_latihan})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                          </svg>
                        </span>`
            }

            // action button 
            if (obj.item == 'petunjuk' || obj.item == 'soal-pg' || obj.item == 'soal-esai' || obj.item == 'video') {
              action = `
                <a href='javascript:void(0)' onclick='hapusLatihanPertemuan(${obj.id_latihan}, "${obj.item}")'><span class="badge badge-sm bg-gradient-danger me-1">hapus</span></a>
                <a href='javascript:void(0)' onclick='editLatihanPertemuan(${obj.id_latihan}, "${obj.item}")'><span class="badge badge-sm bg-gradient-success">edit</span></a>
              `
            } else {
              action = `
                <a href='javascript:void(0)' onclick='hapusLatihanPertemuan(${obj.id_latihan}, "${obj.item}")'><span class="badge badge-sm bg-gradient-danger me-1">hapus</span></a>
              `
            }

            if (obj.item == 'video') {
              icon = 'ni-tv-2'
              content = ` <h6 class="text-dark text-sm font-weight-bold mb-2">Video ${urutan}</h6>
                          <div class="ratio ratio-16x9">
                            <iframe class="object-fit-contain border rounded" src="${obj.data}" allowfullscreen></iframe>
                          </div>`
            } else if (obj.item == 'petunjuk' || obj.item == 'soal-pg' || obj.item == 'soal-esai') {
              icon = 'ni-caps-small'

              let title = '';
              if (obj.item == 'petunjuk') {
                title = 'Petunjuk'
                content = `<h6 class="text-dark text-sm font-weight-bold mb-2">${title} ${urutan}</h6>${obj.data}`
              } else if (obj.item == 'soal-pg') {
                title = 'Soal PG'
                nomor++;

                const soal = JSON.parse(obj.data)
                let soalWithNumber = soal.soal.replace(/<p>/, function(match) {
                  return `${match}<b>${nomor}.</b> `;
                });

                content = `<h6 class="text-dark text-sm font-weight-bold mb-2">${title} ${urutan}</h6>`;
                content += soalWithNumber;
                soal.pilihan.forEach((pilihan, i) => {
                  let checked = (pilihan == soal.jawaban) ? 'checked' : ''

                  content += `<div class="form-check">
                                <input class="form-check-input" type="radio" name="pg${nomor}" id="pg-${nomor}-${i}" disabled ${checked}>
                                <label class="form-check-label" for="pg-${nomor}-${i}">
                                  ${pilihan}
                                </label>
                              </div>`
                })

              } else if (obj.item == 'soal-esai') {
                title = 'Soal Esai'
                nomor++;

                const soal = JSON.parse(obj.data)
                let soalWithNumber = soal.soal.replace(/<p>/, function(match) {
                  return `${match}<b>${nomor}.</b> `;
                });

                content = `<h6 class="text-dark text-sm font-weight-bold mb-2">${title} ${urutan}</h6>`;
                content += soalWithNumber;
                content += `<p><b>Jawaban :</b></p><p>${soal.jawaban}</p>`
              }

            } else if (obj.item == 'audio') {
              icon = 'ni-note-03'
              content = ` <h6 class="text-dark text-sm font-weight-bold mb-2">Audio ${urutan}</h6>
                          <audio controls>
                            <source src="<?= base_url()?>/public/assets/latihan-pertemuan/audio/${obj.data}" type="audio/mpeg">
                          </audio>`
            } else if (obj.item == 'image') {
              icon = 'ni-image'
              content = `
                          <h6 class="text-dark text-sm font-weight-bold mb-2">Image ${urutan}</h6>
                          <div class="ratio ratio-1x1">
                            <img src="<?= base_url()?>/public/assets/latihan-pertemuan/img/${obj.data}" alt="gambar Kosa Kata Dasar 1" onerror="this.onerror=null; this.src='../assets/img/curved-images/white-curved.jpg'">
                          </div>`
            }

            html += `
              <div class="card mb-3">
                <div class="card-body">
                  <div class="timeline timeline-one-side p-0" data-timeline-axis-style="dotted">
                    <div class="timeline-block mb-3">
                      <span class="timeline-step">
                        <i class="ni ${icon} text-success text-gradient"></i>
                      </span>
                      <div class="timeline-content">
                        ${content}
                        <div class="mt-1">
                          ${action}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `
          }
        } else {
          html += `
          <div class="card mb-3">
            <div class="card-body">
              <div class="timeline timeline-one-side p-0" data-timeline-axis-style="dotted">
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="ni ni-fat-remove text-danger text-gradient"></i>
                  </span>
                  <div class="timeline-content">
                    <div class="alert alert-warning text-light" role="alert">
                      Item Latihan Kosong
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>`;
        }

        listLatihanPertemuan.html(html);
      }

    });
  }

  function simpanLatihanPertemuan(e) {
    e.preventDefault();

    let fk_id_pertemuan = $(`#formLatihanPertemuan #fk_id_pertemuan`).val();
    let id_latihan = $(`#formLatihanPertemuan #id_latihan`).val();
    let item = $(`#formLatihanPertemuan #item`).val();

    var fd = new FormData();
    fd.append('fk_id_pertemuan', fk_id_pertemuan);
    fd.append('id_latihan', id_latihan);
    fd.append('item', item);

    if (item == 'petunjuk') {
      let text = CKEDITOR.instances['text'].getData();
      fd.append('data', text);
    } else if (item == 'soal-pg') {
      let filled = true;
      let data = '';
      let soalPg = CKEDITOR.instances['soal-pg'].getData();
      let options = []
      let option = ''

      if (soalPg == '') {
        filled = false
      }

      $("[name='pg']").each(function() {
        option = $(this).val().replace(/\"/g, "&quot;");

        if (option == '') {
          filled = false
        }

        options.push(`"${option}"`);
      });

      if (filled) {
        let jawabanSelected = $("#jawaban-pg").val();
        if (jawabanSelected == '') {
          filled = false
        } else {
          let jawaban = $(`#${jawabanSelected}`).val().replace(/\"/g, "&quot;");
          data = `{"soal":"${soalPg}", "pilihan":[${options.join(',')}], "jawaban":"${jawaban}"}`
        }
      }

      fd.append('data', data);
    } else if (item == 'soal-esai') {
      let filled = true;
      let data = '';
      let soalEsai = CKEDITOR.instances['soal-esai'].getData();

      if (soalEsai == '') {
        filled = false
      }

      if (filled) {
        let jawabanEsai = $("#jawaban-esai").val().replace(/\"/g, "&quot;");;
        if (jawabanEsai != '') {
          data = `{"soal":"${soalEsai}", "jawaban":"${jawabanEsai}"}`
        }
      }

      fd.append('data', data);
    } else if (item == 'audio') {
      let audio = $(`#formLatihanPertemuan #file_audio`)[0].files;
      fd.append('audio', audio[0]);
      let nama_file = $(`#formLatihanPertemuan #nama_file`).val()
      fd.append('nama_file', nama_file);
    } else if (item == 'image') {
      let image = $(`#formLatihanPertemuan #file_image`)[0].files;
      fd.append('image', image[0]);
      let nama_file = $(`#formLatihanPertemuan #nama_file`).val()
      fd.append('nama_file', nama_file);
    } else if (item == 'video') {
      let video = $(`#formLatihanPertemuan #video`).val();
      fd.append('data', video);
    }

    $.ajax({
      url: "<?= base_url()?>/program/simpanLatihanPertemuan",
      type: "POST",
      contentType: false,
      processData: false,
      cache: false,
      data: fd,
      success: function(hasil) {
        var $obj = $.parseJSON(hasil);
        if ($obj.sukses == false) {
          $('.alert-sukses').hide();
          $('.alert-error').show();
          $('.error').html($obj.error);

          $('html, .modal-body').animate({
            scrollTop: 0
          }, 'slow');
        } else {
          $('.alert-error').hide();
          $('.alert-sukses').show();
          $('.sukses').html($obj.sukses);

          if ($obj.edit == false) {
            bersihkanFormLatihanPertemuan()
            CKEDITOR.instances['text'].setData('');
          }

          $('html, .modal-body').animate({
            scrollTop: 0
          }, 'slow');
          showData(fk_id_pertemuan);
        }
      }
    });
  }

  function editLatihanPertemuan(id_latihan) {
    $.ajax({
      url: "<?= base_url()?>/program/getLatihanPertemuan/" + id_latihan,
      type: "get",
      success: function(hasil) {
        var obj = $.parseJSON(hasil);
        if (obj.id_latihan != '') {
          bersihkanFormLatihanPertemuan();

          $('#modalLatihanPertemuan').modal('show');
          $('#modalLatihanPertemuanLabel').html('Edit Item');
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formLatihanPertemuan #id_latihan`).val(obj.id_latihan);
          $(`#formLatihanPertemuan #fk_id_pertemuan`).val(obj.fk_id_pertemuan);
          $(`#formLatihanPertemuan #item`).val(obj.item);
          $(`#formLatihanPertemuan #item`).prop('disabled', true);
          $(`#formLatihanPertemuan #nama_file`).prop('disabled', true);

          if (obj.item == 'petunjuk') {
            $("#form-petunjuk").show()
            CKEDITOR.instances['text'].setData(obj.data);
          } else if (obj.item == 'soal-pg') {
            $("#form-soal-pg").show()
            let soal = $.parseJSON(obj.data);
            CKEDITOR.instances['soal-pg'].setData(soal.soal);

            pgCount = soal.pilihan.length;
            let pilihans = '';
            let jawaban = '<option value="">Pilih Jawaban</option>';

            for (let i = 0; i < soal.pilihan.length; i++) {
              let selected = (soal.jawaban == soal.pilihan[i]) ? 'selected' : "";
              pilihans += `<div class="form-group mb-2" id="pg-${i+1}">
                            <label for="pg${i+1}">Pilihan ${i+1}</label>
                            <textarea name="pg" class="form-control pg" id="pg${i+1}">${soal.pilihan[i]}</textarea>
                          </div>`
              jawaban += `<option value="pg${i+1}" ${selected}>Pilihan ${i+1}</option>`;
            }

            $("#pg").html(pilihans);
            $("#jawaban-pg").html(jawaban);

          } else if (obj.item == 'soal-esai') {
            $("#form-soal-esai").show()
            let soal = $.parseJSON(obj.data);
            CKEDITOR.instances['soal-esai'].setData(soal.soal);
            $("#formLatihanPertemuan #jawaban-esai").val(soal.jawaban)
          } else if (obj.item == 'video') {
            $("#form-video").show()
            $("#formLatihanPertemuan #video").val(obj.data)
          }
        }
      }

    });
  }

  function hapusLatihanPertemuan(id_latihan, tipe) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus item ${tipe}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/program/hapusLatihanPertemuan/" + id_latihan,
          type: "get",
          success: function(hasil) {
            if (result.isConfirmed) {
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })

              Toast.fire({
                icon: 'success',
                title: `Berhasil menghapus item ${tipe}`
              })

              showData(<?= $id_pertemuan ?>);
            }
          }
        });
      }
    })
  }

  function ubahUrutanLatihan(id_latihan, urutan, arah, id_latihan_other) {
    $.ajax({
      url: "<?= base_url()?>/program/ubahUrutanLatihan",
      type: "POST",
      data: {
        id_latihan: id_latihan,
        id_latihan_other: id_latihan_other,
        urutan: urutan,
        arah: arah
      },
      success: function(hasil) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: `Berhasil mengubah urutan`
        })
        showData(<?= $id_pertemuan ?>);
      }
    });
  }
</script>
<?= $this->endSection() ?>
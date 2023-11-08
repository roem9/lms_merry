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
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalMateriPertemuan" data-bs-toggle="modal" data-bs-target="#modalMateriPertemuan">+&nbsp; Materi Baru</a>
        </div>
        <div class="ms-auto my-auto d-block d-md-block d-lg-none">
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalMateriPertemuan" data-bs-toggle="modal" data-bs-target="#modalMateriPertemuan">+&nbsp;</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>List Materi</h6>
      </div>
      <div class="card-body">
        <div class="timeline timeline-one-side" data-timeline-axis-style="dotted" id="listMateriPertemuan">
        </div>
        <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalMateriPertemuan w-100" data-bs-toggle="modal" data-bs-target="#modalMateriPertemuan">+&nbsp; Materi Baru</a>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Modal Add Data Program-->
<div class="modal fade" id="modalMateriPertemuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMateriPertemuanLabel">Tambah Materi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formMateriPertemuan">
          <!-- KALAU SUKSES -->
          <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
            <div class="sukses"></div>
          </div>
          <!-- KALAU ERROR -->
          <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
            <div class="error"></div>
          </div>
          <input type="hidden" name="fk_id_pertemuan" id="fk_id_pertemuan" value="<?= $id_pertemuan ?>">
          <input type="hidden" name="id_materi" id="id_materi">
          <div class="col-12 mb-3">
            <label for="item">Tipe Materi</label>
            <select name="item" id="item" class="multisteps-form__input form-control">
              <option value="">Pilih Tipe Materi</option>
              <option value="audio">Audio</option>
              <option value="file">File</option>
              <option value="image">Image</option>
              <option value="text">Text</option>
              <option value="video">Video</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Nama File</label>
            <input name="nama_file" id="nama_file" class="multisteps-form__input form-control" type="text" placeholder="nama file" disabled>
          </div>
          <div class="formItem" id="form-audio" style="display:none">
            <div class="col-12 mb-3">
              <label for="file_audio" class="form-label">File Audio</label>
              <input name="file_audio" class="form-control" type="file" id="file_audio">
            </div>
          </div>
          <div class="formItem" id="form-file" style="display:none">
            <div class="col-12 mb-3">
              <label for="file_file" class="form-label">File</label>
              <input name="file_file" class="form-control" type="file" id="file_file">
            </div>
          </div>
          <div class="formItem" id="form-image" style="display:none">
            <div class="mb-3">
              <label for="file_image" class="form-label">File Image</label>
              <input name="file_image" class="form-control" type="file" id="file_image">
            </div>
          </div>
          <div class="formItem" id="form-text" style="display:none">
            <div class="form-group">
              <label for="text">Text</label>
              <textarea name="text" class="form-control" id="text" rows="3"></textarea>
            </div>
          </div>
          <div class="formItem" id="form-video" style="display:none">
            <div class="form-group">
              <label for="video">Link Youtube Video</label>
              <textarea name="video" class="form-control" id="video" rows="3"></textarea>
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
    const btnModalMateriPertemuan = $(".btnModalMateriPertemuan");

    // kumpulan even listener
    btnSimpan.on("click", simpanMateriPertemuan);
    btnModalMateriPertemuan.on("click", showModalMateriPertemuan);

    // form validation item materi
    $("#formMateriPertemuan #item").on('change', function() {
      let data = $(this).val();
      $("#formMateriPertemuan #nama_file").val("")

      if (data == 'audio') {
        $(".formItem").hide()
        $("#form-audio").show()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', false);
      } else if (data == 'file') {
        $(".formItem").hide()
        $("#form-file").show()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', false);
      } else if (data == 'image') {
        $(".formItem").hide()
        $("#form-image").show()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', false);
      } else if (data == 'video') {
        $(".formItem").hide()
        $("#form-video").show()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', true);
      } else if (data == 'text') {
        $(".formItem").hide()
        $("#form-text").show()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', true);
      } else {
        $(".formItem").hide()
        $(`#formMateriPertemuan #nama_file`).prop('disabled', true);
      }
    })

    CKEDITOR.replace('text');

    $("#moveSelected").on('change', function() {
      let url = $(this).val()
      window.location.href = "<?= base_url()?>/program/" + url
    })
  });

  // kumpulan function
  function showModalMateriPertemuan() {
    $('#modalMateriPertemuanLabel').html('Tambah Materi');

    bersihkanFormMateriPertemuan()
    CKEDITOR.instances['text'].setData('');

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  function bersihkanFormMateriPertemuan() {
    $("#formMateriPertemuan #id_materi").val("")
    $("#formMateriPertemuan #item").val("")
    $("#formMateriPertemuan #nama_file").val("")
    $("#formMateriPertemuan #file_audio").val("")
    $("#formMateriPertemuan #file_file").val("")
    $("#formMateriPertemuan #file_image").val("")

    $("#formMateriPertemuan #video").val("")
    $(`#formMateriPertemuan #item`).prop('disabled', false);
    $(`#formMateriPertemuan #nama_file`).prop('disabled', true);

    $("#form-audio").hide()
    $("#form-file").hide()
    $("#form-image").hide()
    $("#form-video").hide()
    $("#form-text").hide()
  }

  // show data from database
  function showData(id_pertemuan) {
    $.ajax({
      url: `<?= base_url()?>/program/getAllMateriPertemuan/${id_pertemuan}`,
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)

        const listMateriPertemuan = $("#listMateriPertemuan");
        let obj = {};
        let html = ``;
        let icon = '';
        let content = '';

        let latihan = '';
        let urutan = '';
        let action = '';

        if (data.length > 0) {
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
                          <span onclick="ubahUrutanMateri(${obj.id_materi}, ${obj.urutan}, 'turun', ${data[i+1].id_materi})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                            </svg>
                          </span>`
              }
            } else if (i == data.length - 1) {
              urutan = `<span onclick="ubahUrutanMateri(${obj.id_materi}, ${obj.urutan}, 'naik', ${data[i-1].id_materi})">
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
              urutan = `<span onclick="ubahUrutanMateri(${obj.id_materi}, ${obj.urutan}, 'naik', ${data[i-1].id_materi})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                          </svg>
                        </span>
                        <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                        <span onclick="ubahUrutanMateri(${obj.id_materi}, ${obj.urutan}, 'turun', ${data[i+1].id_materi})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                          </svg>
                        </span>`
            }

            // action button 
            if (obj.item == 'text' || obj.item == 'video') {
              action = `
                <a href='javascript:void(0)' onclick='hapusMateriPertemuan(${obj.id_materi}, "${obj.item}")'><span class="badge badge-sm bg-gradient-danger me-1">hapus</span></a>
                <a href='javascript:void(0)' onclick='editMateriPertemuan(${obj.id_materi}, "${obj.item}")'><span class="badge badge-sm bg-gradient-success">edit</span></a>
              `
            } else {
              action = `
                <a href='javascript:void(0)' onclick='hapusMateriPertemuan(${obj.id_materi}, "${obj.item}")'><span class="badge badge-sm bg-gradient-danger me-1">hapus</span></a>
              `
            }

            if (obj.item == 'video') {
              icon = 'ni-tv-2'
              content = ` <h6 class="text-dark text-sm font-weight-bold mb-2">Video ${urutan}</h6>
                          <div class="ratio ratio-16x9">
                            <iframe class="object-fit-contain border rounded" src="${obj.data}" allowfullscreen></iframe>
                          </div>`
            } else if (obj.item == 'file') {
              icon = 'ni-single-copy-04'
              content = `<h6 class="text-dark text-sm font-weight-bold mb-2">File ${urutan}</h6>
                        <a href='<?= base_url()?>/public/assets/materi-pertemuan/file/${obj.data}' target="_blank" download="${obj.data}">
                          <span class="badge badge-sm bg-gradient-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                              <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z" />
                              <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                            </svg>
                            ${obj.data}
                          </span>
                        </a>
              
              `
            } else if (obj.item == 'text') {
              icon = 'ni-caps-small'
              content = ` <h6 class="text-dark text-sm font-weight-bold mb-2">Text ${urutan}</h6>${obj.data}`
            } else if (obj.item == 'audio') {
              icon = 'ni-note-03'
              content = ` <h6 class="text-dark text-sm font-weight-bold mb-2">Audio ${urutan}</h6>
                          <audio controls title='${obj.data}'>
                            <source src="<?= base_url()?>/public/assets/materi-pertemuan/audio/${obj.data}" type="audio/mpeg">
                          </audio>`
            } else if (obj.item == 'image') {
              icon = 'ni-image'
              content = `
                          <h6 class="text-dark text-sm font-weight-bold mb-2">Image ${urutan}</h6>
                          <div class="ratio ratio-1x1">
                            <img src="<?= base_url()?>/public/assets/materi-pertemuan/img/${obj.data}" alt="gambar Kosa Kata Dasar 1" onerror="this.onerror=null; this.src='../assets/img/curved-images/white-curved.jpg'">
                          </div>`
            }

            html += `
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
            `
          }
        } else {
          html += `
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="ni ni-fat-remove text-danger text-gradient"></i>
              </span>
              <div class="timeline-content">
                <div class="alert alert-warning text-light" role="alert">
                  Materi Kosong
                </div>
              </div>
            </div>`;
        }

        listMateriPertemuan.html(html);
      }

    });
  }

  function simpanMateriPertemuan(e) {
    e.preventDefault();

    let fk_id_pertemuan = $(`#formMateriPertemuan #fk_id_pertemuan`).val();
    let id_materi = $(`#formMateriPertemuan #id_materi`).val();
    let item = $(`#formMateriPertemuan #item`).val();

    var fd = new FormData();
    fd.append('fk_id_pertemuan', fk_id_pertemuan);
    fd.append('id_materi', id_materi);
    fd.append('item', item);

    if (item == 'audio') {
      let audio = $(`#formMateriPertemuan #file_audio`)[0].files;
      fd.append('audio', audio[0]);
      let nama_file = $(`#formMateriPertemuan #nama_file`).val();
      fd.append('nama_file', nama_file);
    } else if (item == 'file') {
      let file = $(`#formMateriPertemuan #file_file`)[0].files;
      fd.append('file', file[0]);
      let nama_file = $(`#formMateriPertemuan #nama_file`).val();
      fd.append('nama_file', nama_file);
    } else if (item == 'image') {
      let image = $(`#formMateriPertemuan #file_image`)[0].files;
      fd.append('image', image[0]);
      let nama_file = $(`#formMateriPertemuan #nama_file`).val();
      fd.append('nama_file', nama_file);
    } else if (item == 'text') {
      let text = CKEDITOR.instances['text'].getData();
      fd.append('text', text);
    } else if (item == 'video') {
      let video = $(`#formMateriPertemuan #video`).val();
      fd.append('video', video);
    }

    $.ajax({
      url: "<?= base_url()?>/program/simpanMateriPertemuan",
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
        } else {
          $('.alert-error').hide();
          $('.alert-sukses').show();
          $('.sukses').html($obj.sukses);

          if ($obj.edit == false) {
            bersihkanFormMateriPertemuan()
            CKEDITOR.instances['text'].setData('');
          }

          showData(fk_id_pertemuan);
        }
      }
    });
  }

  function editMateriPertemuan(id_materi) {
    $.ajax({
      url: "<?= base_url()?>/program/getMateriPertemuan/" + id_materi,
      type: "get",
      success: function(hasil) {
        var obj = $.parseJSON(hasil);
        if (obj.id_materi != '') {
          bersihkanFormMateriPertemuan();

          $('#modalMateriPertemuan').modal('show');
          $('#modalMateriPertemuanLabel').html('Edit Materi');
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formMateriPertemuan #id_materi`).val(obj.id_materi);
          $(`#formMateriPertemuan #fk_id_pertemuan`).val(obj.fk_id_pertemuan);
          $(`#formMateriPertemuan #item`).val(obj.item);
          $(`#formMateriPertemuan #item`).prop('disabled', true);

          if (obj.item == 'text') {
            $("#form-text").show()
            CKEDITOR.instances['text'].setData(obj.data);
          } else if (obj.item == 'video') {
            $("#form-video").show()
            $(`#formMateriPertemuan #video`).val(obj.data);
          }
        }
      }

    });
  }

  function hapusMateriPertemuan(id_materi, tipe) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus materi ${tipe}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/program/hapusMateriPertemuan/" + id_materi,
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
                title: `Berhasil menghapus materi ${tipe}`
              })

              showData(<?= $id_pertemuan ?>);
            }
          }
        });
      }
    })
  }

  function ubahUrutanMateri(id_materi, urutan, arah, id_materi_other) {
    $.ajax({
      url: "<?= base_url()?>/program/ubahUrutanMateri",
      type: "POST",
      data: {
        id_materi: id_materi,
        id_materi_other: id_materi_other,
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
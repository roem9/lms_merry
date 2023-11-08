<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<section class="py-3">
  <div class="row">
    <div class="col-md-8 me-auto text-left">
      <h5>List Program</h5>
      <p>Menu untuk mengelola seluruh data program yang ada di dalam Learning Management System (LMS) Anda</p>
    </div>
  </div>
  <div class="row mt-lg-4 mt-2" id="listOfProgram">

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Modal Add Data Program-->
<div class="modal fade" id="modalFormProgram" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormProgramLabel">Tambah Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- KALAU SUKSES -->
        <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
          <div class="sukses"></div>
        </div>
        <!-- KALAU ERROR -->
        <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
          <div class="error"></div>
        </div>
        <form id="formTambahProgram">
          <input type="hidden" name="id_program" id="id_program">
          <div class="col-12 mb-3">
            <label>Nama Program</label>
            <input name="nama_program" id="nama_program_add" class="multisteps-form__input form-control" type="text" placeholder="nama program">
          </div>
          <div class="form-group">
            <label for="deskrispi_add">Deskripsi Program</label>
            <textarea name="deskripsi" class="form-control" id="deskrispi_add" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="gambar_sampul_add" class="form-label">Gambar Sampul</label>
            <div id="image-cover" style="display:none" class="text-center"></div>
            <input name="gambar_sampul" class="form-control" type="file" id="gambar_sampul_add">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    showData("");

    // kumpulan component
    const btnSimpan = $("#btnSimpan");
    const formSearchProgram = $("#formSearchProgram")

    // kumpulan even listener
    btnSimpan.on("click", tambahProgram)
    formSearchProgram.on('keyup', searchProgram)
  });

  // kumpulan function


  function showModalFormProgram() {
    $('#modalFormProgramLabel').html('Tambah Program');

    $(`#formTambahProgram #id_program`).val('');
    $(`#formTambahProgram #nama_program_add`).val('');
    $(`#formTambahProgram #deskrispi_add`).val('');
    $(`#formTambahProgram #gambar_sampul_add`).val('');
    $(`#image-cover`).hide();

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }


  // show data from database
  function showData(nama_program) {
    let web = "";
    (nama_program == "") ? web = '<?= base_url()?>/program/getAllProgram': web = '<?= base_url()?>/program/getListProgram/' + nama_program
    $.ajax({
      url: web,
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)
        const listOfProgram = $("#listOfProgram");
        let obj = {};
        let html = `
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center text-center">
              <a href="javascript:;" class="btnModalFormProgram" data-bs-toggle="modal" data-bs-target="#modalFormProgram" onclick="showModalFormProgram()">
                <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                <h5 class=" text-secondary"> Program Baru </h5>
              </a>
            </div>
          </div>
        </div>
        `;

        for (var i = 0; i < data.length; i++) {
          obj = data[i];
          html += `
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="d-flex">
                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-2">
                      <img src="public/assets/img-program/${obj.image}" alt="gambar ${obj.nama_program}" onerror="this.onerror=null; this.src='public/assets/img/curved-images/white-curved.jpg'">
                    </div>
                    <div class="ms-3 my-auto">
                      <h6>${obj.nama_program}</h6>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <button class="btn btn-link text-secondary ps-0 pe-2" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-lg" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="program/designProgram/${obj.id_program}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg>
                          Design Program
                        </a>
                        <a class="dropdown-item" href="javascript:;" onclick="editProgram(${obj.id_program})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                          </svg>  
                          Info
                        </a>
                        <a class="dropdown-item text-light" style="background-color: var(--bs-orange)" href="javascript:;" onclick="hapusProgram(${obj.id_program}, '${obj.nama_program}')">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                          </svg>
                          Hapus
                        </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <p class="text-sm mt-3"> ${obj.deskripsi} </p>
                  <hr class="horizontal dark">
                  <div class="row">
                    <div class="col-6">
                      <h6 class="text-sm mb-0">${obj.subscription}</h6>
                      <p class="text-secondary text-sm font-weight-bold mb-0">Subscription</p>
                    </div>
                    <div class="col-3 text-end">
                        <h6 class="text-sm mb-0">${obj.peserta}</h6>
                        <p class="text-secondary text-sm font-weight-bold mb-0">Peserta</p>
                    </div>
                    <div class="col-3 text-end">
                      <h6 class="text-sm mb-0">${obj.kelas}</h6>
                      <p class="text-secondary text-sm font-weight-bold mb-0">Kelas</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>`
        }

        listOfProgram.html(html);
      }

    });
  }

  function searchProgram() {
    let data = $(this).val();

    showData(data);
  }

  function tambahProgram(e) {
    e.preventDefault();

    let id_program = $(`#formTambahProgram #id_program`).val();
    let nama_program = $(`#formTambahProgram #nama_program_add`).val();
    let deskripsi = $(`#formTambahProgram #deskrispi_add`).val();
    let gambar_sampul = $(`#formTambahProgram #gambar_sampul_add`)[0].files;

    // console.log(nama_program, deskripsi, gambar_sampul[0]);
    var fd = new FormData();

    // Append data 
    fd.append('id_program', id_program);
    fd.append('nama_program', nama_program);
    fd.append('deskripsi', deskripsi);
    fd.append('file', gambar_sampul[0]);

    $.ajax({
      url: "<?= base_url()?>/program/simpan",
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
            
            $("#modalFormProgram").modal("hide");

            Toast.fire({
              icon: 'success',
              title: `Berhasil menambahkan program `
            })

          } else {
            $(`#image-cover`).html(
              `<img src="public/assets/img-program/${$obj.image}" alt="" class="img-fluid" width="30%">`
            )
          }

          showData("");
        }
      }
    });
  }

  function editProgram($id) {
    $.ajax({
      url: "<?= base_url()?>/program/getProgram/" + $id,
      type: "get",
      success: function(hasil) {
        var obj = $.parseJSON(hasil);
        // console.log(obj);
        if (obj.id_program != '') {
          $('#modalFormProgram').modal('show');
          $('#modalFormProgramLabel').html('Edit Program');
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formTambahProgram #id_program`).val(obj.id_program);
          $(`#formTambahProgram #nama_program_add`).val(obj.nama_program);
          $(`#formTambahProgram #deskrispi_add`).val(obj.deskripsi);
          $(`#image-cover`).show();
          $(`#image-cover`).html(
            `<img src="public/assets/img-program/${obj.image}" alt="" class="img-fluid" width="30%">`
          )
        }
      }

    });
  }

  function hapusProgram(id, nama_program) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus program ${nama_program}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/program/hapusProgram/" + id,
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
                title: `Berhasil menghapus program ${nama_program}`
              })

              showData("");
            }
          }
        });
      }
    })
  }
</script>
<?= $this->endSection() ?>
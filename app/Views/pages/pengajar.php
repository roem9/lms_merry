<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0"><?= $title ?></h5>
          <p class="text-sm mb-0">
            List Seluruh Pengajar Lembaga Anda
          </p>
        </div>
      </div>
      <div class="d-lg-flex">
        <div>
          <div class="ms-auto my-auto d-none d-md-none d-lg-block">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormPengajar" data-bs-toggle="modal" data-bs-target="#modalFormPengajar">+&nbsp; Pengajar Baru</a>
          </div>
          <div class="ms-auto my-auto d-block d-md-block d-lg-none">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormPengajar" data-bs-toggle="modal" data-bs-target="#modalFormPengajar">+&nbsp;</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body overflow-auto p-3">
      <div class="row" id="listOfMember">
        <div class="card">
          <div class="">
            <table class="table text-dark table-hover align-items-center mb-0" id="table-pengajar">
              <thead>
                <tr>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder"></th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Status</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">NIP</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Nama Pengajar</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">No. WA</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Member Area</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Modal Add Data Pengajar-->
<div class="modal fade" id="modalFormPengajar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormPengajarLabel">Tambah Pengajar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="formTambahPengajar">
        <!-- KALAU SUKSES -->
        <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
          <div class="sukses"></div>
        </div>
        <!-- KALAU ERROR -->
        <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
          <div class="error"></div>
        </div>
        <input type="hidden" name="id_pengajar" id="id_pengajar">
        <div class="col-12 mb-3">
          <label>Tgl Masuk</label>
          <input name="tgl_masuk" id="tgl_masuk" class="multisteps-form__input form-control" type="date">
        </div>
        <div class="col-12 mb-3">
          <label>NIP</label>
          <input name="nip" id="nip" class="multisteps-form__input form-control" type="text" placeholder="NIP" disabled>
          <small class="text-xxs text-danger">* NIP digenerate oleh sistem</small>
        </div>
        <div class="col-12 mb-3">
          <label>Nama Pengajar</label>
          <input name="nama_pengajar" id="nama_pengajar" class="multisteps-form__input form-control" type="text" placeholder="nama pengajar">
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" class="form-control" id="alamat" rows="3"></textarea>
        </div>
        <div class="col-12 mb-3">
          <label>Tempat Lahir</label>
          <input name="t4_lahir" id="t4_lahir" class="multisteps-form__input form-control" type="text" placeholder="tempat lahir">
        </div>
        <div class="col-12 mb-3">
          <label>Tgl Lahir</label>
          <input name="tgl_lahir" id="tgl_lahir" class="multisteps-form__input form-control" type="date">
        </div>
        <div class="col-12 mb-3">
          <label>No. Whatsapp</label>
          <input name="no_wa" id="no_wa" class="multisteps-form__input form-control" type="text" placeholder="628122xxxx">
          <small class="text-xxs  text-danger">* Harap mengisi nomor whatsapp dengan kode negara, contoh : 6281xxxxx</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  // kumpulan function

  document.addEventListener('DOMContentLoaded', () => {
    showData();

    const btnModalFormPengajar = $(".btnModalFormPengajar");
    const btnSimpanFormMember = $("#modalFormPengajar #btnSimpan");
    const btnSimpanFormKelasOfMember = $("#modalFormKelasOfMember #btnSimpan");

    btnModalFormPengajar.on("click", showModalFormPengajar);
    btnSimpanFormMember.on("click", tambahPengajar);
    btnSimpanFormKelasOfMember.on("click", tambahKelasOfMember);

    // form validation only number
    $('#formTambahPengajar #no_wa').on('keyup', function() {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  })

  function bersihkanForm() {
    $(`#formTambahPengajar #id_pengajar`).val('');
    $(`#formTambahPengajar #nip`).val('');
    $(`#formTambahPengajar #nama_pengajar`).val('');
    $(`#formTambahPengajar #alamat`).val('');
    $(`#formTambahPengajar #t4_lahir`).val('');
    $(`#formTambahPengajar #tgl_lahir`).val('');
    $(`#formTambahPengajar #no_wa`).val('');
    $(`#formTambahPengajar #tgl_masuk`).val('');
  }

  function showModalFormPengajar() {
    $('#modalFormPengajarLabel').html('Tambah Pengajar');

    bersihkanForm();

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  // show data from database
  function showData() {
    $('#table-pengajar').DataTable({
      processing: true,
      serverSide: true,
      ajax: `<?= base_url()?>/pengajar/getListPengajar`,
      responsive: {
        details: {
            type: 'column'
        }
      },
      order: [[3, 'asc']],
      columns: [
        {
          className: 'dtr-control w-1',
          searchable: false,
          orderable: false,
          data: null,
          defaultContent: '',
        },
        {
          data: 'status',
          searchable: true,
          className: 'text-sm w-1 text-center',
          orderable: true,
          render: function(data, type, row) {
            if (row.status == "aktif") {
              return `
                <a href="javascript:void(0)" class="me-1" onclick='editStatusMember(${row.id_pengajar}, "nonaktif", "${row.nama_pengajar}")'>
                  <span class="badge bg-gradient-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                  </span>
                </a>
              `
            } else {
              return `
                <a href="javascript:void(0)" class="me-1" onclick='editStatusMember(${row.id_pengajar}, "aktif", "${row.nama_pengajar}")'>
                  <span class="badge bg-gradient-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                  </span>
                </a>
              `
            }
          }
        }, {
          data: 'nip',
          searchable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'nama_pengajar',
          searchable: true,
          className: 'text-sm'
        },
        {
          data: 'no_wa',
          render: function(data, type, row) {
            return `<a href="https://api.whatsapp.com/send?phone=${row.no_wa}&text=" target="_blank"><span class="badge bg-gradient-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            </svg> ${row.no_wa}
            </span></a>`;
          },
          searchable: true,
          className: 'text-sm w-1 text-center'
        },
        {
          data: null,
          render: function(data, type, row) {
            return `<a href="https://api.whatsapp.com/send?phone=${row.no_wa}&text=Link%20:%20<?= web_member() ?>%0AUsername%20:%20${row.nip}%0APassword%20:%20${row.password}" target="_blank"><span class="badge bg-gradient-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
              </svg> member area
            </span></a>`;
          },
          searchable: false,
          orderable: false,
          className: 'text-sm w-1 text-center'
        },
        {
          data: null,
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" class="me-1" onclick='editPengajar(${row.id_pengajar})'>
                <span class="badge bg-gradient-info">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" onclick='hapusPengajar(${row.id_pengajar}, "${row.nama_pengajar}")'>
                <span class="badge bg-gradient-danger">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" viewBox="0 0 16 16">
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                  </svg>
                </span>
              </a>
              `;
          },
          searchable: false,
          orderable: false,
          className: 'w-1 text-center'
        }
      ],
      language: {
        paginate: {
          first: '<<',
          previous: '<',
          next: '>',
          last: '>>'
        }
      },
      pageLength: 5,
      lengthMenu: [
        [5, 10, 20],
        [5, 10, 20]
      ]
    });
    $.fn.DataTable.ext.pager.numbers_length = 5;
  }

  function tambahPengajar(e) {
    e.preventDefault();

    let id_pengajar = $(`#formTambahPengajar #id_pengajar`).val();
    let nip = $(`#formTambahPengajar #nip`).val();
    let nama_pengajar = $(`#formTambahPengajar #nama_pengajar`).val();
    let alamat = $(`#formTambahPengajar #alamat`).val();
    let t4_lahir = $(`#formTambahPengajar #t4_lahir`).val();
    let tgl_lahir = $(`#formTambahPengajar #tgl_lahir`).val();
    let tgl_masuk = $(`#formTambahPengajar #tgl_masuk`).val();
    let no_wa = $(`#formTambahPengajar #no_wa`).val();
    // let $gambar_sampul = $(`#formTambahProgram #gambar_sampul_add`)[0].files;

    $.ajax({
      url: "<?= base_url()?>/pengajar/simpan",
      type: "POST",
      data: {
        id_pengajar: id_pengajar,
        nama_pengajar: nama_pengajar,
        alamat: alamat,
        t4_lahir: t4_lahir,
        tgl_lahir: tgl_lahir,
        tgl_masuk: tgl_masuk,
        no_wa: no_wa,
      },
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
            bersihkanForm();
            
            Toast.fire({
              icon: 'success',
              title: `Berhasil menambahkan pengajar`
            })
          } else {
            Toast.fire({
              icon: 'success',
              title: `Berhasil mengubah data pengajar`
            })
          }

          $("#modalFormPengajar").modal("hide");


        }
        
        $('#table-pengajar').DataTable().ajax.reload();
        $('html, .modal-body').animate({
          scrollTop: 0
        }, 'slow');
      }
    });
  }

  function editPengajar($id_pengajar) {
    $.ajax({
      url: "<?= base_url()?>/pengajar/getPengajar/" + $id_pengajar,
      type: "get",
      success: function(hasil) {
        var $obj = $.parseJSON(hasil);
        // console.log($obj);
        if ($obj.id_pengajar != '') {
          $('#modalFormPengajar').modal('show');
          $('#modalFormPengajarLabel').html($obj.nama_pengajar);
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formTambahPengajar #id_pengajar`).val($obj.id_pengajar);
          $(`#formTambahPengajar #nip`).val($obj.nip);
          $(`#formTambahPengajar #nama_pengajar`).val($obj.nama_pengajar);
          $(`#formTambahPengajar #alamat`).val($obj.alamat);
          $(`#formTambahPengajar #t4_lahir`).val($obj.t4_lahir);
          $(`#formTambahPengajar #tgl_lahir`).val($obj.tgl_lahir);
          $(`#formTambahPengajar #tgl_masuk`).val($obj.tgl_masuk);
          $(`#formTambahPengajar #no_wa`).val($obj.no_wa);
        }
      }

    });
  }

  function hapusPengajar(id, nama_pengajar) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus pengajar ${nama_pengajar}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/pengajar/hapusPengajar/" + id,
          type: "get",
          success: function(hasil) {
            if (hasil == 'true') {
              Toast.fire({
                icon: 'success',
                title: `Berhasil menghapus pengajar ${nama_pengajar}`
              })

              $('#table-pengajar').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `${nama_pengajar} tidak bisa dihapus karena telah memiliki kelas`
              })
            }
          }
        });
      }
    })
  }

  function editStatusPengajar(id_pengajar, status, nama_pengajar) {
    $.ajax({
      url: "<?= base_url()?>/pengajar/editStatusPengajar",
      type: "POST",
      data: {
        id_pengajar: id_pengajar,
        status: status
      },
      success: function(result) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        status = (status == "aktif") ? 'mengaktifkan' : 'menonaktifkan';

        Toast.fire({
          icon: 'success',
          title: `Berhasil ${status} pengajar ${nama_pengajar}`
        })

        $('#table-pengajar').DataTable().ajax.reload();
      }
    })
  }
</script>
<?= $this->endSection() ?>
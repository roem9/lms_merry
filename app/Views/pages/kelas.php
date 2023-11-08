<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-12">
  <form action="<?= base_url()?>/kelas/changePeriode" method="POST" class="mb-3" id="form">
    <div class="row g-2">
        <div class="col-md-3 col-sm-12">
            <select name="bulan" class="form form-control form-control-sm" required>
                <option value="">Semua Bulan</option>
                <option value="01" <?php if($bulan['value'] == "01") echo "selected";?>>Januari</option>
                <option value="02" <?php if($bulan['value'] == "02") echo "selected";?>>Februari</option>
                <option value="03" <?php if($bulan['value'] == "03") echo "selected";?>>Maret</option>
                <option value="04" <?php if($bulan['value'] == "04") echo "selected";?>>April</option>
                <option value="05" <?php if($bulan['value'] == "05") echo "selected";?>>Mei</option>
                <option value="06" <?php if($bulan['value'] == "06") echo "selected";?>>Juni</option>
                <option value="07" <?php if($bulan['value'] == "07") echo "selected";?>>Juli</option>
                <option value="08" <?php if($bulan['value'] == "08") echo "selected";?>>Agustus</option>
                <option value="09" <?php if($bulan['value'] == "09") echo "selected";?>>September</option>
                <option value="10" <?php if($bulan['value'] == "10") echo "selected";?>>Oktober</option>
                <option value="11" <?php if($bulan['value'] == "11") echo "selected";?>>November</option>
                <option value="12" <?php if($bulan['value'] == "12") echo "selected";?>>Desember</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-12">
            <!-- <div class="form-floating mb-3"> -->
                <select name="tahun" class="form form-control form-control-sm" required>
                    <option value="">Semua Tahun</option>
                    <option value="2022" <?php if($tahun['value'] == 2022) echo "selected";?>>2022</option>
                    <?php
                        $tahun_now = date("Y");
                        for ($i=2023; $i < $tahun_now + 1; $i++) :?>
                            <option value="<?= $i?>" <?php if($tahun['value'] == $i) echo "selected";?>><?= $i?></option>
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

<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0"><?= $title ?></h5>
          <p class="text-sm mb-0">
            <?= $description?>
          </p>
        </div>
      </div>
      <div class="d-lg-flex">
        <div>
          <div class="ms-auto my-auto d-none d-md-none d-lg-block">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormKelas" data-bs-toggle="modal" data-bs-target="#modalFormKelas">+&nbsp; Kelas Baru</a>
          </div>
          <div class="ms-auto my-auto d-block d-md-block d-lg-none">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormKelas" data-bs-toggle="modal" data-bs-target="#modalFormKelas">+&nbsp;</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body overflow-auto p-3">
      <div class="row">
        <div class="card">
          <div class="">
            <table class="table text-dark table-hover align-items-center mb-0" id="table-kelas">
              <thead>
                <tr>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder"></th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Status</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder none">Tgl Mulai</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder none">Tgl Selesai</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Nama Kelas</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Nama Pengajar</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Program</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Peserta</th>
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
<!-- Modal Add Data Member-->
<div class="modal fade" id="modalFormKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormKelasLabel">Tambah Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="formTambahKelas">
        <!-- KALAU SUKSES -->
        <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
          <div class="sukses"></div>
        </div>
        <!-- KALAU ERROR -->
        <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
          <div class="error"></div>
        </div>
        <input type="hidden" name="id_kelas" id="id_kelas">
        <div class="col-12 mb-3">
          <label>Tgl Mulai</label>
          <input name="tgl_mulai" id="tgl_mulai" class="multisteps-form__input form-control" type="date">
        </div>
        <div class="col-12 mb-3">
          <label>Tgl Selesai</label>
          <input name="tgl_selesai" id="tgl_selesai" class="multisteps-form__input form-control" type="date">
        </div>
        <div class="col-12 mb-3">
          <label for="program">Program Kelas</label>
          <select name="fk_id_program" id="fk_id_program" class="multisteps-form__input form-control">
            <option value="">Pilih Program</option>
            <?php $programs = list_program();
            foreach ($programs as $program) : ?>
              <option value="<?= $program['id_program'] ?>"><?= $program['nama_program'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12 mb-3">
          <label for="pengajar">Pengajar</label>
          <select name="fk_id_pengajar" id="fk_id_pengajar" class="multisteps-form__input form-control">
            <option value="">Pilih Pengajar</option>
            <?php $pengajars = list_pengajar();
            foreach ($pengajars as $pengajar) : ?>
              <option value="<?= $pengajar['id_pengajar'] ?>"><?= $pengajar['nama_pengajar'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12 mb-3">
          <label>Nama Kelas</label>
          <input name="nama_kelas" id="nama_kelas" class="multisteps-form__input form-control" type="text" placeholder="nama kelas">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Data Member-->
<div class="modal fade" id="modalKelasMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKelasMemberLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table align-items-center ">
            <tbody id="listMemberOfKelas">
              <!-- generate by jquery -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
  // kumpulan function

  document.addEventListener('DOMContentLoaded', () => {
    showData();

    const btnModalFormKelas = $(".btnModalFormKelas");
    const btnSimpan = $("#btnSimpan");

    btnModalFormKelas.on("click", showModalFormKelas);
    btnSimpan.on("click", tambahKelas);
  })

  function bersihkanForm() {
    $(`#formTambahKelas #id_kelas`).val('');
    $(`#formTambahKelas #tgl_mulai`).val('');
    $(`#formTambahKelas #tgl_selesai`).val('');
    $(`#formTambahKelas #fk_id_program`).val('');
    $(`#formTambahKelas #fk_id_pengajar`).val('');
    $(`#formTambahKelas #nama_kelas`).val('');
  }

  function showModalFormKelas() {
    $('#modalFormKelasLabel').html('Tambah Kelas');

    bersihkanForm();

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  // show data from database
  function showData() {
    $('#table-kelas').DataTable({
      processing: true,
      serverSide: true,
      ajax: `<?= base_url()?>/kelas/getListKelas`,
      responsive: {
        details: {
            type: 'column'
        }
      },
      order: [[4, 'asc']],
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
          searchable: false,
          className: 'text-sm w-1 text-center',
          orderable: false,
          render: function(data, type, row) {
            if (row.status == "aktif") {
              return `
                <a href="javascript:void(0)" class="me-1" onclick="editStatusKelas(${row.id_kelas}, 'nonaktif', '${row.nama_kelas}')">
                  <span class="badge bg-gradient-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                  </span>
                </a>
              `
            } else {
              return `
                <a href="javascript:void(0)" class="me-1" onclick="editStatusKelas(${row.id_kelas}, 'aktif', '${row.nama_kelas}')">
                  <span class="badge bg-gradient-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                  </span>
                </a>
              `
            }
          }
        },
        {
          data: 'tgl_mulai',
          searchable: false,
          className: 'text-sm w-1',
          orderable: false
        },
        {
          data: 'tgl_selesai',
          searchable: false,
          className: 'text-sm w-1',
          orderable: false
        },
        {
          data: 'nama_kelas',
          searchable: true,
          className: 'text-sm',
          orderable: true
        },
        {
          data: 'nama_pengajar',
          searchable: true,
          className: 'text-sm',
          orderable: true
        },
        {
          data: 'nama_program',
          searchable: true,
          className: 'text-sm w-1',
          orderable: true
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          className: 'text-sm w-1 text-center',
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" onclick="getMemberOfKelas(${row.id_kelas}, '${row.nama_kelas}')"><span class="badge bg-gradient-success"> ${row.peserta}
              </span></a>`
          }
        },
        {
          data: null,
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" class="me-1" onclick="editKelas(${row.id_kelas})">
                <span class="badge bg-gradient-info">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" onclick="hapusKelas(${row.id_kelas}, '${row.nama_kelas}')">
                <span class="badge bg-gradient-danger">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
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

  function tambahKelas(e) {
    e.preventDefault();

    let id_kelas = $(`#formTambahKelas #id_kelas`).val();
    let tgl_mulai = $(`#formTambahKelas #tgl_mulai`).val();
    let tgl_selesai = $(`#formTambahKelas #tgl_selesai`).val();
    let fk_id_program = $(`#formTambahKelas #fk_id_program`).val();
    let fk_id_pengajar = $(`#formTambahKelas #fk_id_pengajar`).val();
    let nama_kelas = $(`#formTambahKelas #nama_kelas`).val();
    // let $gambar_sampul = $(`#formTambahProgram #gambar_sampul_add`)[0].files;

    $.ajax({
      url: "<?= base_url()?>/kelas/simpan",
      type: "POST",
      data: {
        id_kelas: id_kelas,
        tgl_mulai: tgl_mulai,
        tgl_selesai: tgl_selesai,
        fk_id_program: fk_id_program,
        fk_id_pengajar: fk_id_pengajar,
        nama_kelas: nama_kelas
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
              title: `Berhasil menambahkan kelas`
            })
          } else {
            Toast.fire({
              icon: 'success',
              title: `Berhasil mengubah data kelas`
            })
          }

          $("#modalFormKelas").modal("hide");

          $('#table-kelas').DataTable().ajax.reload();
          $('html, .modal-body').animate({
            scrollTop: 0
          }, 'slow');
        }
      }
    });
  }

  function editKelas($id_kelas) {
    $.ajax({
      url: "<?= base_url()?>/kelas/getKelas/" + $id_kelas,
      type: "get",
      success: function(hasil) {
        var $obj = $.parseJSON(hasil);
        // console.log($obj);
        if ($obj.id_kelas != '') {
          $('#modalFormKelas').modal('show');
          $('#modalFormKelasLabel').html($obj.nama_kelas);
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formTambahKelas #id_kelas`).val($obj.id_kelas);
          $(`#formTambahKelas #tgl_mulai`).val($obj.tgl_mulai);
          $(`#formTambahKelas #tgl_selesai`).val($obj.tgl_selesai);
          $(`#formTambahKelas #fk_id_program`).val($obj.fk_id_program);
          $(`#formTambahKelas #fk_id_pengajar`).val($obj.fk_id_pengajar);
          $(`#formTambahKelas #nama_kelas`).val($obj.nama_kelas);
        }
      }

    });
  }

  function hapusKelas(id, nama_kelas) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus kelas ${nama_kelas}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/kelas/hapusKelas/" + id,
          type: "get",
          success: function(hasil) {
            if (hasil == 'true') {
              Toast.fire({
                icon: 'success',
                title: `Berhasil menghapus kelas ${nama_kelas}`
              })

              $('#table-kelas').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `${nama_kelas} tidak bisa dihapus karena telah memiliki member`
              })
            }
          }
        });
      }
    })
  }

  function getMemberOfKelas(id, nama_kelas) {
    // console.log(id, nama_kelas);
    $("#modalKelasMember").modal('show');
    $("#modalKelasMemberLabel").html(`Member Kelas ${nama_kelas}`);

    showMemberOfKelas(id, nama_kelas);
  }

  function showMemberOfKelas(id, nama_kelas) {
    $.ajax({
      url: "<?= base_url()?>/kelas/getMemberOfKelas/" + id,
      type: "get",
      success: function(data) {
        var data = $.parseJSON(data);
        const listMemberOfKelas = $("#listMemberOfKelas");

        let obj = {};
        let html = ``;

        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            obj = data[i];
            html += `
              <tr>
                  <td>
                    <span class="text-sm font-weight-bold mb-0">${i + 1}. ${obj.nama_member}</span>
                  </td>
                  <td class="text-end">
                    <a href="javascript:void(0)" onclick="hapusMemberOfKelas(${obj.id_kelas_member}, '${obj.nama_member}', ${id}, '${nama_kelas}')">
                      <span class="badge bg-gradient-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                          <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                      </span>
                    </a>
                  </td>
                </tr>`
          }
        } else {
          html += `<div class="alert alert-warning text-light" role="alert">
                      Data member kosong
                  </div>`
        }

        listMemberOfKelas.html(html);
      }
    })
  }

  function editStatusKelas(id_kelas, status, nama_kelas) {
    $.ajax({
      url: "<?= base_url()?>/kelas/editStatusKelas",
      type: "POST",
      data: {
        id_kelas: id_kelas,
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
          title: `Berhasil ${status} kelas ${nama_kelas}`
        })

        $('#table-kelas').DataTable().ajax.reload();
      }
    })
  }

  function hapusMemberOfKelas(id_kelas_member, nama_member, id_kelas, nama_kelas) {
    Swal.fire({
      title: `Apa Anda yakin akan mengeluarkan ${nama_member} dari kelas ${nama_kelas}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/kelas/hapusMemberOfKelas/" + id_kelas_member,
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
                title: `Berhasil mengeluarkan peserta ${nama_kelas} dari kelas ${nama_kelas}`
              })

              showMemberOfKelas(id_kelas, nama_kelas)
              $('#table-kelas').DataTable().ajax.reload();
            }
          }
        });
      }
    })
  }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0"><?= $title ?></h5>
          <p class="text-sm mb-0">
            List Seluruh Member Subscription Anda
          </p>
        </div>
      </div>
    </div>
    <div class="card-body overflow-auto p-3">
      <div class="row" id="listOfMember">
        <div class="card">
          <div class="">
            <table class="table text-dark table-hover align-items-center mb-0" id="table-member">
              <thead>
                <tr>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder"></th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">NIM</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Nama Member</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Program</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Tgl Mulai</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Tgl Berakhir</th>
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
  <!-- Modal Add Kelas Member / Subscription-->
  <div class="modal fade" id="modalFormKelasOfMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFormKelasOfMemberLabel">Tambah Kelas / Subscription</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="formTambahKelasOfMember">
          <!-- KALAU SUKSES -->
          <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
            <div class="sukses"></div>
          </div>
          <!-- KALAU ERROR -->
          <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
            <div class="error"></div>
          </div>
          <input type="hidden" name="id_subscription_member" id="id_subscription_member">
          <div class="col-12 mb-3">
            <label>Nama Member</label>
            <input name="nama_member" id="nama_member" class="multisteps-form__input form-control" type="text" placeholder="Nama Member" disabled>
          </div>
          <div class="memberSubscription">
            <div class="col-12 mb-3">
              <label for="program">Program</label>
              <select name="fk_id_program" id="fk_id_program" class="multisteps-form__input form-control" disabled>
                <option value="">Pilih Program</option>
                <?php $programs = list_program();
                foreach ($programs as $program) : ?>
                  <option value="<?= $program['id_program'] ?>"><?= $program['nama_program'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <label>Tgl Mulai</label>
              <input name="tgl_mulai" id="tgl_mulai" class="multisteps-form__input form-control" type="date">
            </div>
            <div class="col-12 mb-3">
              <label>Tgl Berakhir</label>
              <input name="tgl_berakhir" id="tgl_berakhir" class="multisteps-form__input form-control" type="date">
              <small class="text-danger text-xs">*kosongkan tgl berakhir untuk subscription unlimited</small>
            </div>
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

    const btnSimpan = $("#modalFormKelasOfMember #btnSimpan");
    btnSimpan.on("click", simpanSubscriptionOfMember);
  })

  function bersihkanForm() {
    $(`#formTambahMember #id_member`).val('');
    $(`#formTambahMember #nim`).val('');
    $(`#formTambahMember #nama_member`).val('');
    $(`#formTambahMember #alamat`).val('');
    $(`#formTambahMember #t4_lahir`).val('');
    $(`#formTambahMember #tgl_lahir`).val('');
    $(`#formTambahMember #no_wa`).val('');
  }

  function showModalFormMember() {
    $('#modalFormMemberLabel').html('Tambah Member');

    bersihkanForm();

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  // show data from database
  function showData() {
    $('#table-member').DataTable({
      processing: true,
      serverSide: true,
      ajax: `<?= base_url()?>/member/getListMemberSubscription`,
      responsive: {
        details: {
            type: 'column'
        }
      },
      order: [[2, 'asc']],
      columns: [
        {
          className: 'dtr-control w-1',
          searchable: false,
          orderable: false,
          data: null,
          defaultContent: '',
        }, 
        {
          data: 'nim',
          searchable: true,
          orderable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'nama_member',
          searchable: false,
          orderable: false,
          className: 'text-sm'
        },
        {
          data: 'nama_program',
          searchable: true,
          orderable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'tgl_mulai',
          searchable: true,
          orderable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'tgl_berakhir',
          searchable: true,
          orderable: true,
          className: 'text-sm w-1',
          render: function(data, type, row){
            if(row.tgl_berakhir == "0000-00-00"){
              return '<center>&#8734;</center>';
            } else {
              return row.tgl_berakhir
            }
          }
        },
        {
          data: null,
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" class="me-1" onclick="editSubscriptionMember(${row.id_subscription_member})">
                <span class="badge bg-gradient-info">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" onclick='hapusSubscriptionOfMember(${row.id_subscription_member}, "${row.nama_program}", "${row.nama_member}")'>
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

  function simpanSubscriptionOfMember(e) {
    e.preventDefault();

    let id_subscription_member = $(`#formTambahKelasOfMember #id_subscription_member`).val();
    let tgl_mulai = $(`#formTambahKelasOfMember #tgl_mulai`).val();
    let tgl_berakhir = $(`#formTambahKelasOfMember #tgl_berakhir`).val();

    $.ajax({
      url: "<?= base_url()?>/member/simpanSubscriptionOfMember",
      type: "POST",
      data: {
        id_subscription_member: id_subscription_member,
        tgl_mulai: tgl_mulai,
        tgl_berakhir: tgl_berakhir
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

          $('#table-member').DataTable().ajax.reload();
          $('html, .modal-body').animate({
            scrollTop: 0
          }, 'slow');
        }
      }
    });
  }

  function editSubscriptionMember($id_subscription_member) {
    $.ajax({
      url: "<?= base_url()?>/member/getSubscriptionMember/" + $id_subscription_member,
      type: "get",
      success: function(hasil) {
        var $obj = $.parseJSON(hasil);
        if ($obj.id_member != '') {
          $('#modalFormKelasOfMember').modal('show');
          $('#modalFormKelasOfMemberLabel').html($obj.nama_member);
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formTambahKelasOfMember #id_subscription_member`).val($obj.id_subscription_member);
          $(`#formTambahKelasOfMember #nama_member`).val($obj.nama_member);
          $(`#formTambahKelasOfMember #fk_id_program`).val($obj.fk_id_program);
          $(`#formTambahKelasOfMember #tgl_mulai`).val($obj.tgl_mulai);
          $(`#formTambahKelasOfMember #tgl_berakhir`).val($obj.tgl_berakhir);
        }
      }

    });
  }

  function hapusSubscriptionOfMember(id_subscription_member, nama_program, nama_member, id_member) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus ${nama_member} dari subscription program ${nama_program}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/member/hapusSubscriptionOfMember/" + id_subscription_member,
          type: "get",
          success: function(hasil) {
            if (result.isConfirmed) {
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

              Toast.fire({
                icon: 'success',
                title: `Berhasil menghapus ${nama_member} dari subscription program ${nama_program}`
              })

              $('#table-member').DataTable().ajax.reload();
            }
          }
        });
      }
    })
  }
</script>
<?= $this->endSection() ?>
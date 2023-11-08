<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0"><?= $title ?></h5>
          <p class="text-sm mb-0">
            List Seluruh Member Kelas Lembaga Anda
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
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Kelas</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Tgl Mulai</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Tgl Selesai</th>
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
<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  // kumpulan function

  document.addEventListener('DOMContentLoaded', () => {
    showData();
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
      ajax: `<?= base_url()?>/member/getListMemberKelas`,
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
          searchable: true,
          orderable: true,
          className: 'text-sm'
        },
        {
          data: 'nama_kelas',
          searchable: true,
          orderable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'tgl_mulai',
          searchable: false,
          orderable: false,
          className: 'text-sm w-1'
        },
        {
          data: 'tgl_selesai',
          searchable: false,
          orderable: false,
          className: 'text-sm w-1'
        },
        {
          data: null,
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" onclick='hapusKelasOfMember(${row.id_kelas_member}, "${row.nama_kelas}", "${row.nama_member}")'>
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

  function hapusKelasOfMember(id_kelas_member, nama_kelas, nama_member) {
    Swal.fire({
      title: `Apa Anda yakin akan mengeluarkan ${nama_member} dari kelas ${nama_kelas}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, keluarkan!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/member/hapusKelasOfMember/" + id_kelas_member,
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
                title: `Berhasil mengeluarkan ${nama_member} dari kelas ${nama_kelas}`
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
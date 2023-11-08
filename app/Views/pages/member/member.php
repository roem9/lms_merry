<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0"><?= $title ?></h5>
          <p class="text-sm mb-0">
            List Seluruh Member Lembaga Anda
          </p>
        </div>
      </div>
      <div class="d-lg-flex">
        <div>
          <div class="ms-auto my-auto d-none d-md-none d-lg-block">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormMember" data-bs-toggle="modal" data-bs-target="#modalFormMember">+&nbsp; Member Baru</a>
          </div>
          <div class="ms-auto my-auto d-block d-md-block d-lg-none">
            <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormMember" data-bs-toggle="modal" data-bs-target="#modalFormMember">+&nbsp;</a>
          </div>
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
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Status</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">NIM</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder all">Nama Member</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">No. WA</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Member Area</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Kelas</th>
                  <th class="text-uppercase text-dark text-xxs font-weight-bolder desktop">Subs</th>
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
<div class="modal fade" id="modalFormMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormMemberLabel">Tambah Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="formTambahMember">
        <!-- KALAU SUKSES -->
        <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
          <div class="sukses"></div>
        </div>
        <!-- KALAU ERROR -->
        <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
          <div class="error"></div>
        </div>
        <input type="hidden" name="id_member" id="id_member">
        <div class="col-12 mb-3">
          <label>NIM</label>
          <input name="nim" id="nim" class="multisteps-form__input form-control" type="text" placeholder="NIM" disabled>
          <small class="text-xxs text-danger">* NIM digenerate oleh sistem</small>
        </div>
        <div class="col-12 mb-3">
          <label>Nama Member</label>
          <input name="nama_member" id="nama_member" class="multisteps-form__input form-control" type="text" placeholder="nama member">
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
        <input type="hidden" name="fk_id_member" id="fk_id_member">
        <div class="col-12 mb-3">
          <label>Nama Member</label>
          <input name="nama_member" id="nama_member" class="multisteps-form__input form-control" type="text" placeholder="Nama Member" disabled>
        </div>
        <div class="col-12 mb-3">
          <label for="tipe_member">Tipe Member</label>
          <select name="tipe_member" id="tipe_member" class="multisteps-form__input form-control">
            <option value="">Pilih Tipe Member</option>
            <option value="Member Kelas">Member Kelas</option>
            <option value="Member Subscription">Member Subscription</option>
          </select>
        </div>
        <div class="memberKelas isNotShow">
          <div class="col-12 mb-3">
            <label for="program">Kelas</label>
            <select name="fk_id_kelas" id="fk_id_kelas" class="multisteps-form__input form-control">
  
            </select>
          </div>
        </div>
        <div class="memberSubscription isNotShow">
          <div class="col-12 mb-3">
            <label for="program">Program</label>
            <select name="fk_id_program" id="fk_id_program" class="multisteps-form__input form-control">
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

<!-- Modal list kelas Member-->
<div class="modal fade" id="modalListKelasOfMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListKelasOfMemberLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <h6>List Kelas</h6>
          <table class="table align-items-center ">
            <tbody id="listKelasOfMember">
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

<!-- Modal list Subscription Member-->
<div class="modal fade" id="modalListSubscriptionOfMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListSubscriptionOfMemberLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <h6>List Subscription</h6>
          <table class="table align-items-center ">
            <tbody id="listSubscriptionOfMember">
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

<?= $this->section('js-script') ?>
<script>
  // kumpulan function

  document.addEventListener('DOMContentLoaded', () => {
    showData();

    const btnModalFormMember = $(".btnModalFormMember");
    const btnSimpanFormMember = $("#modalFormMember #btnSimpan");
    const btnSimpanFormKelasOfMember = $("#modalFormKelasOfMember #btnSimpan");

    btnModalFormMember.on("click", showModalFormMember);
    btnSimpanFormMember.on("click", tambahMember);
    btnSimpanFormKelasOfMember.on("click", tambahKelasOfMember);

    // form validation only number
    $('#formTambahMember #no_wa').on('keyup', function() {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
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
      ajax: `<?= base_url()?>/member/getListMember`,
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
                <a href="javascript:void(0)" class="me-1" onclick='editStatusMember(${row.id_member}, "nonaktif", "${row.nama_member}")'>
                  <span class="badge bg-gradient-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                  </span>
                </a>
              `
            } else {
              return `
                <a href="javascript:void(0)" class="me-1" onclick='editStatusMember(${row.id_member}, "aktif", "${row.nama_member}")'>
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
          data: 'nim',
          searchable: true,
          className: 'text-sm w-1'
        },
        {
          data: 'nama_member',
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
            return `<a href="https://api.whatsapp.com/send?phone=${row.no_wa}&text=Link%20:%20<?= web_member() ?>%0AUsername%20:%20${row.nim}%0APassword%20:%20${row.password}" target="_blank"><span class="badge bg-gradient-success">
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
          searchable: false,
          orderable: false,
          className: 'text-sm w-1 text-center',
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" onclick='showKelasOfMember(${row.id_member}, "${row.nama_member}")'><span class="badge bg-gradient-success"> ${row.kelas}
              </span></a>`
          }
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          className: 'text-sm w-1 text-center',
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" onclick='showSubscriptionOfMember(${row.id_member}, "${row.nama_member}")'"><span class="badge bg-gradient-success"> ${row.subscription}
              </span></a>`
          }
        },
        {
          data: null,
          render: function(data, type, row) {
            return `
              <a href="javascript:void(0)" class="me-1" onclick='showModalTambahKelasOfMember(${row.id_member}, "${row.nama_member}")'>
                <span class="badge bg-gradient-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" class="me-1" onclick='editMember(${row.id_member})'>
                <span class="badge bg-gradient-info">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                  </svg>
                </span>
              </a>
              <a href="javascript:void(0)" onclick='hapusMember(${row.id_member}, "${row.nama_member}")'>
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

  function tambahMember(e) {
    e.preventDefault();

    let id_member = $(`#formTambahMember #id_member`).val();
    let nim = $(`#formTambahMember #nim`).val();
    let nama_member = $(`#formTambahMember #nama_member`).val();
    let alamat = $(`#formTambahMember #alamat`).val();
    let t4_lahir = $(`#formTambahMember #t4_lahir`).val();
    let tgl_lahir = $(`#formTambahMember #tgl_lahir`).val();
    let no_wa = $(`#formTambahMember #no_wa`).val();
    // let $gambar_sampul = $(`#formTambahProgram #gambar_sampul_add`)[0].files;

    $.ajax({
      url: "<?= base_url()?>/member/simpan",
      type: "POST",
      data: {
        id_member: id_member,
        nama_member: nama_member,
        alamat: alamat,
        t4_lahir: t4_lahir,
        tgl_lahir: tgl_lahir,
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
          }

          $("#modalFormMember").modal("hide");

          Toast.fire({
            icon: 'success',
            title: `Berhasil menambahkan member`
          })

          $('#table-member').DataTable().ajax.reload();
          $('html, .modal-body').animate({
            scrollTop: 0
          }, 'slow');
        }
      }
    });
  }

  function editMember($id_member) {
    $.ajax({
      url: "<?= base_url()?>/member/getMember/" + $id_member,
      type: "get",
      success: function(hasil) {
        var $obj = $.parseJSON(hasil);
        // console.log($obj);
        if ($obj.id_member != '') {
          $('#modalFormMember').modal('show');
          $('#modalFormMemberLabel').html($obj.nama_member);
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formTambahMember #id_member`).val($obj.id_member);
          $(`#formTambahMember #nim`).val($obj.nim);
          $(`#formTambahMember #nama_member`).val($obj.nama_member);
          $(`#formTambahMember #alamat`).val($obj.alamat);
          $(`#formTambahMember #t4_lahir`).val($obj.t4_lahir);
          $(`#formTambahMember #tgl_lahir`).val($obj.tgl_lahir);
          $(`#formTambahMember #no_wa`).val($obj.no_wa);
        }
      }

    });
  }

  function showModalTambahKelasOfMember(id_member, nama_member) {
    $('.alert-error').hide();
    $('.alert-sukses').hide();

    $("#modalFormKelasOfMember").modal('show');
    $("#formTambahKelasOfMember #fk_id_member").val(id_member);
    $("#formTambahKelasOfMember #nama_member").val(nama_member);

    $.ajax({
      url: "<?= base_url()?>/kelas/getListKelasOption",
      type: "get",
      success: function(data) {
        var data = $.parseJSON(data);

        let obj = {};
        let html = `<option value="">Pilih Kelas</option>`;

        for (var i = 0; i < data.length; i++) {
          obj = data[i];
          html += `<option value="${obj.id_kelas}">[${obj.peserta}] ${obj.nama_kelas}</option>`
        }

        $("#fk_id_kelas").html(html);
      }
    })

    
    $.ajax({
      url: "<?= base_url()?>/kelas/getListKelasOption",
      type: "get",
      success: function(data) {
        var data = $.parseJSON(data);

        let obj = {};
        let html = `<option value="">Pilih Kelas</option>`;

        for (var i = 0; i < data.length; i++) {
          obj = data[i];
          html += `<option value="${obj.id_kelas}">[${obj.peserta}] ${obj.nama_kelas}</option>`
        }

        $("#fk_id_kelas").html(html);
      }
    })

    $(".isNotShow").hide();
    $(`#formTambahKelasOfMember #tipe_member`).val("");
    $(`#formTambahKelasOfMember #fk_id_kelas`).val("");
    $(`#formTambahKelasOfMember #fk_id_program`).val("");
    $(`#formTambahKelasOfMember #tgl_mulai`).val("");
    $(`#formTambahKelasOfMember #tgl_berakhir`).val("");
  }

  $("#tipe_member").on("change", function(){
    let tipe_member = $(this).val();

    $(".isNotShow").hide();
    if(tipe_member == 'Member Kelas'){
      $(".memberKelas").show();
      $("[nam]")
    } else if(tipe_member == 'Member Subscription'){
      $(".memberSubscription").show();
    }
    
    $(`#formTambahKelasOfMember #fk_id_kelas`).val("");
    $(`#formTambahKelasOfMember #fk_id_program`).val("");
    $(`#formTambahKelasOfMember #tgl_mulai`).val("");
    $(`#formTambahKelasOfMember #tgl_berakhir`).val("");
  })

  function tambahKelasOfMember(e) {
    e.preventDefault();

    var data = {};
    let fk_id_member = $(`#formTambahKelasOfMember #fk_id_member`).val();
    let tipe_member = $(`#formTambahKelasOfMember #tipe_member`).val();
    let fk_id_kelas = $(`#formTambahKelasOfMember #fk_id_kelas`).val();
    let fk_id_program = $(`#formTambahKelasOfMember #fk_id_program`).val();
    let tgl_mulai = $(`#formTambahKelasOfMember #tgl_mulai`).val();
    let tgl_berakhir = $(`#formTambahKelasOfMember #tgl_berakhir`).val();

    data = {
      fk_id_member: fk_id_member,
      tipe_member: tipe_member,
      fk_id_kelas: fk_id_kelas,
      fk_id_program: fk_id_program,
      tgl_mulai: tgl_mulai,
      tgl_berakhir: tgl_berakhir
    };

    $.ajax({
      url: "<?= base_url()?>/member/tambahKelasOfMember",
      type: "POST",
      data: data,
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
            $(`#formTambahKelasOfMember #fk_id_kelas`).val('')
          }

          $("#modalFormKelasOfMember").modal('hide');

          Toast.fire({
            icon: 'success',
            title: `Berhasil menambahkan kelas / subscription`
          })

          $('#table-member').DataTable().ajax.reload();
        }

        $('html, .modal-body').animate({
          scrollTop: 0
        }, 'slow');
      }
    });
  }

  function hapusMember(id, nama_member) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus member ${nama_member}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/member/hapusMember/" + id,
          type: "get",
          success: function(hasil) {
            if (hasil == 'true') {
              Toast.fire({
                icon: 'success',
                title: `Berhasil menghapus member ${nama_member}`
              })

              $('#table-member').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `${nama_member} tidak bisa dihapus karena telah memiliki kelas / subscription`
              })
            }
          }
        });
      }
    })
  }

  function showKelasOfMember(id_member, nama_member) {
    $.ajax({
      url: "<?= base_url()?>/member/getKelasOfMember/" + id_member,
      type: "get",
      success: function(data) {
        var data = $.parseJSON(data);
        // console.log(data);

        $("#modalListKelasOfMember").modal('show');
        $("#modalListKelasOfMemberLabel").html(nama_member);
        const listKelasOfMember = $("#listKelasOfMember");

        let obj = {};
        let html = ``;

        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            obj = data[i];
            html += `
              <tr>
                  <td>
                    <span class="text-sm font-weight-bold mb-0">${i + 1}. ${obj.nama_kelas}</span>
                  </td>
                  <td class="text-end">
                    <a href="javascript:void(0)" onclick='hapusKelasOfMember(${obj.id_kelas_member}, "${obj.nama_kelas}", "${nama_member}", ${id_member})'>
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
                      Data kelas kosong
                  </div>`
        }

        listKelasOfMember.html(html);
      }
    })
  }

  function showSubscriptionOfMember(id_member, nama_member) {
    $.ajax({
      url: "<?= base_url()?>/member/getSubscriptionOfMember/" + id_member,
      type: "get",
      success: function(data) {
        var data = $.parseJSON(data);
        // console.log(data);

        $("#modalListSubscriptionOfMember").modal('show');
        $("#modalListSubscriptionOfMemberLabel").html(nama_member);
        const listSubscriptionOfMember = $("#listSubscriptionOfMember");

        let obj = {};
        let html = ``;

        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            obj = data[i];
            html += `
              <tr>
                  <td>
                    <span class="text-sm font-weight-bold mb-0">${i + 1}. ${obj.nama_program}</span>
                  </td>
                  <td class="text-end">
                    <a href="javascript:void(0)" onclick='hapusSubscriptionOfMember(${obj.id_subscription_member}, "${obj.nama_program}", "${nama_member}", ${id_member})'>
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
                      Data subscription kosong
                  </div>`
        }

        listSubscriptionOfMember.html(html);
      }
    })
  }

  function hapusKelasOfMember(id_kelas_member, nama_kelas, nama_member, id_member) {
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

              showKelasOfMember(id_member, nama_member)

              $('#table-member').DataTable().ajax.reload();
            }
          }
        });
      }
    })
  }

  function hapusSubscriptionOfMember(id_subscription_member, nama_program, nama_member, id_member) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus subscription program ${nama_program}?`,
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
                title: `Berhasil menghapus subscription program ${nama_program}`
              })

              showSubscriptionOfMember(id_member, nama_member)

              $('#table-member').DataTable().ajax.reload();
            }
          }
        });
      }
    })
  }

  function editStatusMember(id_member, status, nama_member) {
    $.ajax({
      url: "<?= base_url()?>/member/editStatusMember",
      type: "POST",
      data: {
        id_member: id_member,
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
          title: `Berhasil ${status} member ${nama_member}`
        })

        $('#table-member').DataTable().ajax.reload();
      }
    })
  }
</script>
<?= $this->endSection() ?>
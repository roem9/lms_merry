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
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormPertemuanProgram" data-bs-toggle="modal" data-bs-target="#modalFormPertemuanProgram">+&nbsp; Pertemuan Baru</a>
        </div>
        <div class="ms-auto my-auto d-block d-md-block d-lg-none">
          <button type="button" class="btn bg-gradient-info btn-sm mb-0 btnModalFormPertemuanProgram" data-bs-toggle="modal" data-bs-target="#modalFormPertemuanProgram">+&nbsp;</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card ">
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody id="listOfPertemuanProgram">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Modal Add Data Program-->
<div class="modal fade" id="modalFormPertemuanProgram" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormPertemuanProgramLabel">Tambah Pertemuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPertemuanProgram">
          <!-- KALAU SUKSES -->
          <div class="alert alert-success fade show text-light alert-sukses" role="alert" style="display: none">
            <div class="sukses"></div>
          </div>
          <!-- KALAU ERROR -->
          <div class="alert alert-danger fade show text-light alert-error" role="alert" style="display: none">
            <div class="error"></div>
          </div>
          <input type="hidden" name="fk_id_program" id="fk_id_program" value="<?= $id_program ?>">
          <input type="hidden" name="id_pertemuan" id="id_pertemuan">
          <div class="col-12 mb-3">
            <label>Nama Pertemuan</label>
            <input name="nama_pertemuan" id="nama_pertemuan" class="multisteps-form__input form-control" type="text" placeholder="nama pertemuan">
          </div>
          <div class="col-12 mb-3">
            <label for="tipe_latihan">Tipe Latihan</label>
            <select name="tipe_latihan" id="tipe_latihan" class="multisteps-form__input form-control">
              <option value="">Pilih Tipe Latihan</option>
              <option value="Koreksi Otomatis">Koreksi Otomatis</option>
              <option value="Tidak Ada Latihan">Tidak Ada Latihan</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label for="pengulangan_latihan">Perulangan Latihan</label>
            <select name="pengulangan_latihan" id="pengulangan_latihan" class="multisteps-form__input form-control">
              <option value="">Pilih Perulangan Latihan</option>
              <option value="Sekali">Sekali</option>
              <option value="Berkali-kali">Berkali-kali</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Poin Persoal</label>
            <input name="poin" id="poin" class="multisteps-form__input form-control" type="text" placeholder="poin persoal">
          </div>
          <div class="col-12 mb-3">
            <label for="pembahasan">Tampilkan Pembahasan Soal?</label>
            <select name="pembahasan" id="pembahasan" class="multisteps-form__input form-control">
              <option value="">Pilih</option>
              <option value="ya">Ya</option>
              <option value="tidak">Tidak</option>
            </select>
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
    showData(<?= $id_program ?>);

    // kumpulan component
    const btnSimpan = $("#btnSimpan");
    const btnModalFormPertemuanProgram = $(".btnModalFormPertemuanProgram");

    // kumpulan even listener
    btnSimpan.on("click", simpanPertemuanProgram);
    btnModalFormPertemuanProgram.on("click", showModalFormPertemuanProgram);

    // form validation only number
    $('#formPertemuanProgram #poin').on('keyup', function() {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    // form validation tipe latihan
    $("#formPertemuanProgram #tipe_latihan").on('change', function() {
      let data = $(this).val();

      if (data == 'Tidak Ada Latihan') {
        $("#formPertemuanProgram #pengulangan_latihan").val('')
        $("#formPertemuanProgram #poin").val('')
        $("#formPertemuanProgram #pembahasan").val('')

        $("#formPertemuanProgram #pengulangan_latihan").prop('disabled', true)
        $("#formPertemuanProgram #poin").prop('disabled', true)
        $("#formPertemuanProgram #pembahasan").prop('disabled', true)
      } else {
        $("#formPertemuanProgram #pengulangan_latihan").val('')
        $("#formPertemuanProgram #poin").val('')
        $("#formPertemuanProgram #pembahasan").val('')

        $("#formPertemuanProgram #pengulangan_latihan").prop('disabled', false)
        $("#formPertemuanProgram #poin").prop('disabled', false)
        $("#formPertemuanProgram #pembahasan").prop('disabled', false)
      }
    })

    $("#moveSelected").on('change', function() {
      let url = $(this).val()
      window.location.href = "<?= base_url()?>/program/" + url
    })
  });

  // kumpulan function
  function showModalFormPertemuanProgram() {
    $('#modalFormPertemuanProgramLabel').html('Tambah Program');

    bersihkanFormPertemuanProgram();

    $('.alert-error').hide();
    $('.alert-sukses').hide();
  }

  function bersihkanFormPertemuanProgram() {
    $(`#formPertemuanProgram #id_pertemuan`).val('');
    $(`#formPertemuanProgram #nama_pertemuan`).val('');
    $(`#formPertemuanProgram #tipe_latihan`).val('');
    $(`#formPertemuanProgram #pengulangan_latihan`).val('');
    $(`#formPertemuanProgram #poin`).val('');
    $(`#formPertemuanProgram #pembahasan`).val('');

    $("#formPertemuanProgram #pengulangan_latihan").prop('disabled', false)
    $("#formPertemuanProgram #poin").prop('disabled', false)
    $("#formPertemuanProgram #pembahasan").prop('disabled', false)
  }

  // show data from database
  function showData(id_program) {
    $.ajax({
      url: `<?= base_url()?>/program/getAllPertemuan/${id_program}`,
      type: "GET",
      success: function(data) {
        data = JSON.parse(data)
        const listOfPertemuanProgram = $("#listOfPertemuanProgram");
        let obj = {};
        let html = `
        `;

        let latihan = '';
        let urutan = '';

        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            obj = data[i];

            latihan = (obj.tipe_latihan != 'Tidak Ada Latihan') ? `<a href="<?= base_url()?>/program/latihanPertemuan/${obj.id_pertemuan}" class="me-1">
                      <span class=" badge bg-gradient-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                          <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                          <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z" />
                        </svg>
                      </span>
                    </a>` : `<span class=" badge bg-gradient-warning" data-toggle="tooltip" data-placement="top" title="Tidak ada latihan">-</span>`

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
                          <span onclick="ubahUrutan(${obj.id_pertemuan}, ${obj.urutan}, 'turun', ${data[i+1].id_pertemuan})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                            </svg>
                          </span>`
              }
            } else if (i == data.length - 1) {
              urutan = `<span onclick="ubahUrutan(${obj.id_pertemuan}, ${obj.urutan}, 'naik', ${data[i-1].id_pertemuan})">
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
              urutan = `<span onclick="ubahUrutan(${obj.id_pertemuan}, ${obj.urutan}, 'naik', ${data[i-1].id_pertemuan})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                          </svg>
                        </span>
                        <span class="ms-1 me-1 text-xs">${obj.urutan}</span>
                        <span onclick="ubahUrutan(${obj.id_pertemuan}, ${obj.urutan}, 'turun', ${data[i+1].id_pertemuan})">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                          </svg>
                        </span>`
            }

            html += `
              <tr>
                <td class="w-1">
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">Urutan:</p>
                    ${urutan}
                  </div>
                </td>
                <td class="">
                  <div class="d-flex px-2 py-1 align-items-center">
                    <div class="ms-4">
                      <p class="text-xs font-weight-bold mb-0">Nama Pertemuan:</p>
                      <h6 class="text-sm mb-0">${obj.nama_pertemuan}</h6>
                    </div>
                  </div>
                </td>
                <td class="w-1">
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">Materi:</p>
                    <a href="<?= base_url()?>/program/materiPertemuan/${obj.id_pertemuan}" class="me-1">
                      <span class=" badge bg-gradient-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal" viewBox="0 0 16 16">
                          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                        </svg>
                      </span>
                    </a>
                  </div>
                </td>
                <td class="w-1">
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">Latihan:</p>
                    ${latihan}
                  </div>
                </td>
                <td class="w-1">
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">Action:</p>
                    <a href="javascript:void(0)" class="me-1" onclick="editPertemuanProgram(${obj.id_pertemuan}, '${obj.nama_pertemuan}')">
                      <span class=" badge bg-gradient-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                          <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                        </svg>
                      </span>
                    </a>
                    <a href="javascript:void(0)" class="me-1" onclick="hapusPertemuanProgram(${obj.id_pertemuan}, '${obj.nama_pertemuan}', ${obj.fk_id_program})">
                      <span class=" badge bg-gradient-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                          <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                      </span>
                    </a>
                  </div>
                </td>
              </tr>`
          }
        } else {
          html += `
            <tr>
              <td>
                <div class="alert alert-warning text-light" role="alert">
                  Pertemuan Kosong
                </div>
              </td>
            </tr>`;
        }

        listOfPertemuanProgram.html(html);
      }

    });
  }

  function simpanPertemuanProgram(e) {
    e.preventDefault();

    let fk_id_program = $(`#formPertemuanProgram #fk_id_program`).val();
    let id_pertemuan = $(`#formPertemuanProgram #id_pertemuan`).val();
    let nama_pertemuan = $(`#formPertemuanProgram #nama_pertemuan`).val();
    let tipe_latihan = $(`#formPertemuanProgram #tipe_latihan`).val();
    let pengulangan_latihan = $(`#formPertemuanProgram #pengulangan_latihan`).val();
    let poin = $(`#formPertemuanProgram #poin`).val();
    let pembahasan = $(`#formPertemuanProgram #pembahasan`).val();

    if (tipe_latihan == 'Tidak Ada Latihan') {
      pengulangan_latihan = 'null'
      pembahasan = 'null'
      poin = 0
    }

    $.ajax({
      url: "<?= base_url()?>/program/simpanPertemuanProgram",
      type: "POST",
      data: {
        fk_id_program: fk_id_program,
        id_pertemuan: id_pertemuan,
        nama_pertemuan: nama_pertemuan,
        tipe_latihan: tipe_latihan,
        pengulangan_latihan: pengulangan_latihan,
        poin: poin,
        pembahasan: pembahasan
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
            bersihkanFormPertemuanProgram()
          }

          showData(fk_id_program);
        }
      }
    });
  }

  function editPertemuanProgram(id_pertemuan) {
    $.ajax({
      url: "<?= base_url()?>/program/getPertemuanProgram/" + id_pertemuan,
      type: "get",
      success: function(hasil) {
        var obj = $.parseJSON(hasil);
        // console.log(obj);
        if (obj.id_pertemuan != '') {
          bersihkanFormPertemuanProgram();

          $('#modalFormPertemuanProgram').modal('show');
          $('#modalFormPertemuanProgramLabel').html('Edit Pertemuan');
          $('.alert-error').hide();
          $('.alert-sukses').hide();

          $(`#formPertemuanProgram #id_pertemuan`).val(obj.id_pertemuan);
          $(`#formPertemuanProgram #nama_pertemuan`).val(obj.nama_pertemuan);
          $(`#formPertemuanProgram #tipe_latihan`).val(obj.tipe_latihan);

          if (obj.tipe_latihan != 'Tidak Ada Latihan') {
            $(`#formPertemuanProgram #pengulangan_latihan`).val(obj.pengulangan_latihan);
            $(`#formPertemuanProgram #poin`).val(obj.poin);
            $(`#formPertemuanProgram #pembahasan`).val(obj.pembahasan);
          } else {
            $(`#formPertemuanProgram #pengulangan_latihan`).val('');
            $(`#formPertemuanProgram #poin`).val('');
            $(`#formPertemuanProgram #pembahasan`).val('');

            $(`#formPertemuanProgram #pengulangan_latihan`).prop('disabled', true);
            $(`#formPertemuanProgram #poin`).prop('disabled', true);
            $(`#formPertemuanProgram #pembahasan`).prop('disabled', true);
          }
        }
      }

    });
  }

  function hapusPertemuanProgram(id_pertemuan, nama_pertemuan, id_program) {
    Swal.fire({
      title: `Apa Anda yakin akan menghapus pertemuan ${nama_pertemuan}?`,
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url()?>/program/hapusPertemuanProgram/" + id_pertemuan,
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
                title: `Berhasil menghapus ${nama_pertemuan}`
              })

              showData(id_program);
            }
          }
        });
      }
    })
  }

  function ubahUrutan(id_pertemuan, urutan, arah, id_pertemuan_other) {
    $.ajax({
      url: "<?= base_url()?>/program/ubahUrutan",
      type: "POST",
      data: {
        id_pertemuan: id_pertemuan,
        id_pertemuan_other: id_pertemuan_other,
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
        showData(<?= $id_program ?>);
      }
    });
  }
</script>
<?= $this->endSection() ?>
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
    </div>
    <div class="card-body p-3">
      <div class="row">
        <div class="card">
          <div class="mb-3">
            <canvas id="myChart"></canvas>
          </div>
          
          <div>
            <canvas id="myChartRetur"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js-script') ?>

<script>
  const ctx = document.getElementById('myChart');

  function showData(){
    $.ajax({
      url: "<?= base_url()?>/home/laporanStatistik",
      type: "get",
      success: function(hasil) {
        var obj = $.parseJSON(hasil);
        console.log(obj);

        const data = {
          labels: obj.label,
          datasets: [
            {
              label: 'Data Subscription',
              data: obj.subscription,
              fill: false,
              borderColor: 'rgb(75, 192, 192)',
              tension: 0.1
            },
            {
              label: 'Data Kelas',
              data: obj.kelas,
              fill: false,
              borderColor: 'rgb(255, 0, 0)',
              tension: 0.1
            },
            {
              label: 'Data Member Kelas',
              data: obj.member,
              fill: false,
              borderColor: 'rgb(0, 255, 0)',
              tension: 0.1
            }
        ]
        };
      
        new Chart(ctx, {
          type: 'line',
          data: data,
          options: {
              maintainAspectRatio: false,
              aspectRatio: 1, // 5:1 width-to-height ratio
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
        });
      }
    });
  }

  showData();

</script>

<?= $this->endSection() ?>
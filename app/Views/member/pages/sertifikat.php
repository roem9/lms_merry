<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $nama_member?> - <?= $nama_kelas?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<?php
        $path = base_url().'/public/assets/img-sertifikat/sertifikat.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<style>
  @font-face {
    font-family: 'Buffalo-Nickel';
    font-style: normal;
    font-weight: normal;
    src: url("<?= base_url()?>/vendor/dompdf/dompdf/lib/fonts/Buffalo-Nickel.ttf") format('truetype');
  }

  
  @font-face {
    font-family: 'Alpha';
    font-style: normal;
    font-weight: normal;
    src: url("<?= base_url()?>/vendor/dompdf/dompdf/lib/fonts/Alpha54.ttf") format('truetype');
  }

    @page { margin: 0; }
    
    body {
        /* display: block;
        position: fixed; */
        background-image: url('<?= $base64?>');
        background-size: cover;
        background-repeat: no-repeat;
    }

    .namaPeserta {
      position: absolute;
      font-family: 'Buffalo-Nickel';
      font-size: 50px;
      color: #56688d;
      top: 240px;
      /* background-color: red; */
      width: 100%;
    }

    .deskripsi {
      position: absolute;
      font-family: 'Alpha';
      font-size: 20px;
      color: #56688d;
      top: 330px;
      /* background-color: green; */
      width: 100%;
      display: flex;
      justify-content: center;
    }

    .deskripsiText {
      font-family: 'Alpha';
      font-size: 20px;
      color: #56688d;
      /* background-color: red; */
      line-height: 1; 
      width: 70%;
      margin: 0 auto;
    }

    .barcode {
      position: absolute;
      top: 50px;
      width: 100%;
    }
</style>
<body>
  <div class="barcode">
    <center>
      <img src="<?= $barcode?>" alt="" width="100px">
    </center>
  </div>
  
  <div class="namaPeserta">
    <center><?= $nama_member?></center>
  </div>
  <div class="deskripsi">
    <div class="deskripsiText">
      <center>
        For outstanding achievements and results in participating in and completing <?= $nama_kelas?> Class
      </center>
    </div>
  </div>
</body>
</html>
<script>
  function manageAjax() {
    var no_anggota_field = $("#no_anggota").val()
    $.ajax({
      url: "<?php echo base_url() . 'index.php/kredit/manageajaxgetdataanggota'; ?>",
      type: "POST",
      data: {
        id: no_anggota_field
      },
      success: function(ajaxData) {
        $('.data-ajax').html(ajaxData);
      }
    });
  }

  // fungsi untuk membuat tanggal menjadi otomatis sesuai jangka waktu pembayaran
  function manageDate() {
    var tgl_pembayaran_field = $("#tgl_pembayaran").val()
    var jangka_waktu_field = $("#jangka_waktu_bulan").val()

    $.ajax({
      url: "<?php echo base_url() . 'index.php/kredit/manageAjaxDate'; ?>",
      type: "POST",
      data: {
        tgl_pembayaran_field: tgl_pembayaran_field,
        jangka_waktu_field: jangka_waktu_field
      },
      success: function(response) {
        $("#tgl_lunas").val(response);
      }
    });
  }

  // membuat jumlah pokok menjadi otomatis sesuai dengan jumlah pembiayaan da njangka waktu yang diinginkan
  function hitungPokokBahas() {
    var jmlPembiayaan = $('#jumlah_pembiayaan').val();
    var jangkaWaktu = $('#jangka_waktu_bulan').val();
    var jmlPokok = parseInt(jmlPembiayaan) / parseInt(jangkaWaktu);
    var jmlBahas = 0.01 * jmlPokok;
    $('#jml_pokok_bulanan').val(jmlPokok);
    $("#jml_bahas_bulanan"). val(jmlBahas);
  }

</script>
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#">Kredit / Pembiayaan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Kredit/Pembiayaan</li>
    </ol>
  </nav>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Kredit/Pembiayaan</h6>
    </div>
    <div class="card-body">
      <?php
      echo $this->session->flashdata("input_success");
      echo $this->session->flashdata("input_failed");
      echo $this->session->flashdata("update_success");
      echo $this->session->flashdata("update_failed");
      echo $this->session->flashdata("delete_success");
      echo $this->session->flashdata("delete_failed");
      ?>
      <form method="POST" action="<?php echo base_url() . 'index.php/kredit/simpanKreditBaru' ?>">
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputnomer_rekening">Nomer Rekening</label>
            <input type="text" name="no_rekening_pembiayaan" class="form-control" id="no_rekening_pembiayaan" placeholder="Masukan Nomer Rekening" autofocus>
          </div>
          <div class="col-md-4">
            <label for="">No. Anggota</label>
            <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
              <option value="">--Pilih--</option>
              <?php foreach ($anggota as $a) { ?>
                <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota . ' - ' . $a->nama ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row data-ajax">

        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputTanggalPembayaran">Tanggal Pembiayaan</label>
            <input type="date" class="form-control" id="tgl_pembayaran" value="<?php echo date('Y-m-d'); ?>" name="tgl_pembayaran" placeholder="Tanggal Pembayaran">
          </div>
          <div class="form-group col-md-4">
            <label for="inputJumlah">Jumlah Pembiayaan</label>
            <input type="number" name="jumlah_pembiayaan" class="form-control" id="jumlah_pembiayaan" placeholder="Masukan jumlah pembiayaan" onkeyup="hitungPokokBahas()" required>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputJangkaWaktu">Jangka Waktu</label>
            <select name="jangka_waktu_bulan" id="jangka_waktu_bulan" class="form-control select2_" onchange="manageDate();hitungPokokBahas()" required>
              <option value="">--Pilih Jangka Waktu--</option>
              <option value=" 3">3 Bulan</option>
              <option value="6">6 Bulan</option>
              <option value="12">12 Bulan</option>
              <option value="18">18 Bulan</option>
              <option value="24">24 Bulan</option>
              <option value="30">30 Bulan</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="inputSampai">Tanggal Lunas</label>
            <input type="date" name="tgl_lunas" class="form-control" id="tgl_lunas" placeholder="Tanggal Lunas">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputPokok">Pokok</label>
            <input type="text" name="jml_pokok_bulanan" onchange="" class="form-control" id="jml_pokok_bulanan" placeholder="Pokok">
          </div>
          <div class="form-group col-md-4">
            <label for="inputAlamat">Bahas</label>
            <input type="number" name="jml_bahas_bulanan" class="form-control" id="jml_bahas_bulanan" placeholder="Bahas">
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
          <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
        </div>

      </form>
    </div>
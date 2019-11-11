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

  function manageDate() {
    var tgl_pembayaran_field = $("#tgl_pembayaran").val()
    var jangka_waktu_field = $("#jangka_waktu").val()

    $.ajax({
      url: "<?php echo base_url() . 'index.php/kredit/manageajaxDate'; ?>",
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
      <form method="POST" action="<?php echo base_url() . 'index.php/kredit/simpanKreditBaru' ?>">
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputnomer_rekening">Nomer Rekening</label>
            <input type="text" name="nomer_rekening" class="form-control" id="inputnomer_rekening" placeholder="Masukan Nomer Rekening" autofocus>
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
            <label for="inputTanggalPembayaran">Tanggal Pembayaran</label>
            <?php
            $tgl = date('Y-m-d');
            ?>
            <input type="date" class="form-control" id="tgl_pembayaran" value="<?php echo $tgl; ?>" name="tgl_pembayaran" placeholder="Tanggal Pembayaran">
          </div>
          <div class="form-group col-md-4">
            <label for="inputJumlah">Jumlah Pembayaran</label>
            <input type="number" name="jumlah" class="form-control" id="inputJumlahPembayaran" placeholder="000xxx">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputPokok">Pokok</label>
            <input type="number" name="pokok" class="form-control" id="inputPokok" placeholder="Pokok">
          </div>
          <div class="form-group col-md-4">
            <label for="inputAlamat">Bahas</label>
            <input type="number" name="bahas" class="form-control" id="inputBahas" placeholder="Bahas">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputJangkaWaktu">Jangka Waktu</label>
            <select name="jangka_waktu" id="jangka_waktu" class="form-control form-control-sm" onchange="manageDate()" required>
              <option value="">--Pilih Jangka Waktu--</option>
              <option value="3">3 Bulan</option>
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
        <!-- <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
      </div>
      <div class="form-group">
        <label for="inputAddress2">Address 2</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
      </div> -->

        <!-- <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            Check me out
          </label>
        </div>
      </div> -->
        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
          <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
        </div>

      </form>
    </div>
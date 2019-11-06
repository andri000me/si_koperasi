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
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputnomer_rekening">Nomer Rekening</label>
            <input type="text" name="nomer_rekening" class="form-control" id="inputnomer_rekening" placeholder="Masukan Nomer Rekening" autofocus>
          </div>
          <div class="col-md-6">
            <label for="">No. Anggota</label>
            <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
              <option value="">--Pilih--</option>
              <?php foreach ($anggota as $a) { ?>
                <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota . ' - ' . $a->nama ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="row data-ajax">

          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputTanggalPembayaran">Tanggal Pembayaran</label>
              <input type="date" class="form-control" id="inputTanggalPembayaran" placeholder="Tanggal Pembayaran">
            </div>
            <div class="form-group col-md-6">
              <label for="inputJumlah">Jumlah Pembayaran</label>
              <input type="number" class="form-control" id="inputJumlahPembayaran" placeholder="000xxx">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPokok">Pokok</label>
              <input type="number" class="form-control" id="inputPokok" placeholder="Pokok">
            </div>
            <div class="form-group col-md-6">
              <label for="inputAlamat">Bahas</label>
              <input type="text" class="form-control" id="inputBahas" placeholder="Bahas">
            </div>
            <div class="form-group col-md-6">
              <label for="inputJangkaWaktu">Jangka Waktu</label>
              <select name="status" id="" class="form-control form-control-sm" required>
                <option value="">--Pilih Jangka Waktu--</option>
                <option value="1">3 Bulan</option>
                <option value="2">6 Bulan</option>
                <option value="3">12 Bulan</option>
                <option value="4">18 Bulan</option>
                <option value="5">24 Bulan</option>
                <option value="6">30 Bulan</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputSampai">Tanggal Lunas</label>
              <input type="date" class="form-control" id="inputTanggalLunas" placeholder="Tanggal Lunas">
            </div>
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
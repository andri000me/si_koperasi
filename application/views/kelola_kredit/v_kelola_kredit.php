<script>
    function edit(id) {
        $.ajax({
            url: "<?php echo base_url() . 'index.php/kelola_kredit/edit'; ?>",
            type: "POST",
            data: {
                id: id
            },
            success: function(ajaxData) {
                $("#modaledit").html(ajaxData);
                $("#modaledit").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    }
</script>
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#">Kredit / Pembiayaan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Kelola Kredit</li>
    </ol>
  </nav>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Kelola Kredit</h6>
    </div>
    <div class="card-body">
      <form method="POST" action="">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputnomer_rekening">Nomer Rekening Kredit</label>
            <input type="text" name="nomer_rekening" class="form-control" id="inputnomer_rekening" placeholder="Masukan Nomer Rekening" autofocus>
          </div>
          <div class="form-group col-md-6">
            <label for="nama">Atas Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Anda" autofocus>
          </div>
          <div class="form-row">
          <div class="form-group col-md-6">
              <label for="inputJangkaWaktu">Jangka Waktu</label>
              <select name="jangkaWaktu" id="" class="form-control form-control-sm" required>
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
              <label for="inputJumlah">Jumlah Pembiayaan</label>
              <input type="number" class="form-control" id="inputJumlahPembiayaan" placeholder="Masukan Jumlah Pembiayaan">
            </div>
            <div class="form-group col-md-6">
              <label for="inputAlamat">Pokok</label>
              <input type="text" class="form-control" id="inputPokok" placeholder="Pokok">
            </div>
            <div class="form-group col-md-6">
              <label for="inputAlamat">Bahas</label>
              <input type="text" class="form-control" id="inputBahas" placeholder="Bahas">
            </div>
            <div class="form-group col-md-6">
              <label for="inputTanggal">Tanggal</label>
              <input type="date" class="form-control" id="inputTanggal" placeholder="Masukan Tanggal">
            </div>
            <div class="form-group col-md-6">
              <label for="inputSampai">Periode Tagihan</label>
              <input type="date" class="form-control" id="inputPeriodeTagihan" placeholder="Masukan Periode Tagihan">
            </div>
            <div class="form-group col-md-6">
              <label for="inputAlamat">Pokok</label>
              <input type="text" class="form-control" id="inputPokok" placeholder="Pokok">
            </div>
            <div class="form-group col-md-6">
              <label for="inputAlamat">Bahas</label>
              <input type="text" class="form-control" id="inputBahas" placeholder="Bahas">
            </div>
            <div class="form-group col-md-6">
              <label for="inputDenda">Denda</label>
              <input type="number" class="form-control" id="inputdendan" placeholder="Masukan Denda">
            </div>
            <div class="form-group col-md-6">
              <label for="inputJumlah">Jumlah</label>
              <input type="number" class="form-control" id="inputJumlah" placeholder="Masukan Jumlah">
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
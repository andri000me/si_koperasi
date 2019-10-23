<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Kredit atau Pembiayaan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Kredit/Pembiayaan</li>
  </ol>
</nav>
<div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Kredit/Pembiayaan</h6>
        </div>
        <div class="card-body">
    <form>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputNIK">NIK</label>
          <input type="text" class="form-control" id="inputNIK" placeholder="380081xxx" autofocus>
        </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputNama">Nama</label>
          <input type="text" class="form-control" id="inputNama" placeholder="Nama Lengkap">
        </div>
        <div class="form-group col-md-6">
          <label for="inputAlamat">Alamat</label>
          <input type="text" class="form-control" id="inputAlamat" placeholder="Alamat">
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
          <label for="inputAlamat">Pokok</label>
          <input type="text" class="form-control" id="inputPokok" placeholder="Pokok">
        </div>
      <div class="form-group col-md-6">
          <label for="inputAlamat">Bahas</label>
          <input type="text" class="form-control" id="inputBahas" placeholder="Bahas">
        </div>
        <div class="form-group col-md-6">
          <label for="inputJangkaWaktu">Jangka Waktu</label>
          <input type="text" class="form-control" id="inputJangkaWaktu" placeholder="Bulan">
        </div>
        <div class="form-group col-md-6">
          <label for="inputSampai">Tanggal Lunas</label>
          <input type="date" class="form-control" id="inputTanggalLunas" placeholder="Tanggal Lunas">
        </div>
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
     <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
     <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
    </form>
</div>

<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Form Sijaka</li>
  </ol>
</nav>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Form Buka Rekening</h6>
  </div>
  <div class="card-body">
    <form>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputNRSj">NRSj</label>
          <input type="text" class="form-control" id="inputNRSj" placeholder="84565xxxx" autofocus>
        </div>
        <div class="form-group col-md-6">
          <label for="inputNIK">NIK</label>
          <input type="text" class="form-control" id="inputNIK" placeholder="380081xxx">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputNama">Nama</label>
          <input type="text" class="form-control" id="inputNama" placeholder="Nama Lengkap" readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="inputAlamat">Alamat</label>
          <input type="text" class="form-control" id="inputAlamat" placeholder="Alamat" readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputJumlah">Jumlah</label>
          <input type="number" class="form-control" id="inputJumlah" placeholder="85000xxx">
        </div>
        <div class="form-group col-md-6">
          <label for="inputJangkaWaktu">Jangka Waktu</label>
          <input type="text" class="form-control" id="inputJangkaWaktu" placeholder="Bulan">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputMulai">Mulai</label>
          <input type="date" class="form-control" id="inputMulai" placeholder="Bulan">
        </div>
        <div class="form-group col-md-6">
          <label for="inputSampai">Sampai</label>
          <input type="date" class="form-control" id="inputSampai" placeholder="Sampai">
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
      <div class="form-row">
        <!-- <div class="form-group col-md-6">
          <label for="inputCity">City</label>
          <input type="text" class="form-control" id="inputCity">
        </div> -->
        <div class="form-group col-md-2">
          <label for="inputNilaiBahas">Nilai Bahas</label>
          <select id="inputBahas" class="form-control">
            <option selected>0.7%</option>
            <option>Custom</option>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="inputJmlNilaiBahas">Jumlah Bayar</label>
          <input type="text" class="form-control" id="inputJmlBahas">
        </div>
        <div class="form-group col-md-2">
          <label for="inputPembayaranBahas">Pembayaran Bahas</label>
          <select id="inputPembayaranBahas" class="form-control">
            <option selected>Tunai</option>
            <option>Kredit Rekening</option>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="inputJmlPembayaranBahas">jumlah Bayar</label>
          <input type="text" class="form-control" id="inputJmlPembayaranBahas">
        </div>
        <div class="form-group col-md-2">
          <label for="inputPembayaranBahas">Perpanjangan Otomatis</label>
          <select id="inputPembayaranBahas" class="form-control">
            <option>Pilih</option>
            <option>Ya</option>
            <option>Tidak</option>
          </select>
        </div>
      </div>
        
      
      <!-- <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            Check me out
          </label>
        </div>
      </div> -->
      <button type="submit" class="btn btn-primary float-right" style="margin-left:5px;">Simpan</button>
      <button type="reset" class="btn btn-danger float-right">Clear</button>
    </form>
  </div>
  </div>
</div>

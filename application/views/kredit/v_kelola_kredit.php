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
      <?php
      echo $this->session->flashdata("input_success");
      echo $this->session->flashdata("input_failed");
      echo $this->session->flashdata("update_success");
      echo $this->session->flashdata("update_failed");
      echo $this->session->flashdata("delete_success");
      echo $this->session->flashdata("delete_failed");
      ?>
      <form method="POST" action="<?php echo base_url() . 'index.php/kredit/simpanKelolaKredit' ?>">
        <div class="row">
          <div class="form-group col-md-4">
            <label for="">No. Rekening Kredit</label>
            <select name="no_rekening_pembiayaan" id="no_rekening_pembiayaan" class="form-control select2_" onchange="manageAjax();" required>
              <option value="">--Pilih--</option>
              <?php foreach ($kredit as $k) { ?>
                <option value="<?php echo $k->no_rekening_pembiayaan; ?>"><?php echo $k->no_rekening_pembiayaan.'-'.$k->nama ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="inputTanggal">Atas Nama</label>
            <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="" readonly="">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputTanggal">Tanggal Pembayaran</label>
            <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" placeholder="Masukan Tanggal">
          </div>
          <div class="form-group col-md-4">
            <label for="inputSampai">Periode Tagihan</label>
            <input type="hidden" name="periode_tagihan" id="periode_tagihan">
            <input type="text" class="form-control" id="show_periode_tagihan" name="show_periode_tagihan" placeholder="Masukan Periode Tagihan" readonly="">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputAlamat">Pokok</label>
            <input type="text" class="form-control" id="jml_pokok" name="jml_pokok" placeholder="Jumlah Pokok" onkeyup="calculate()">
          </div>
          <div class="form-group col-md-4">
            <label for="inputAlamat">Bahas</label>
            <input type="text" class="form-control" id="jml_bahas" name="jml_bahas" placeholder="Bahas" onkeyup="calculate()">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="inputDenda">Denda</label>
            <input type="number" class="form-control" id="denda" name="denda" value="0" placeholder="Masukan Denda" onkeyup="calculate()">
          </div>
          <div class="form-group col-md-4">
            <label for="total">Total</label>
            <input type="number" class="form-control" id="total" name="total" placeholder="Masukan Jumlah" readonly="">
          </div>
        </div>
        <div class="row"> 
          <div class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
          </div>
        </div>
    </div>
  </div>
  </form>
</div>

<script>
  function manageAjax() {
    var no_rekening_pembiayaan_field = $("#no_rekening_pembiayaan").val()

    $.ajax({
      url: "<?php echo base_url() . 'index.php/kredit/manageAjaxGetDataKelolaKredit'; ?>",
      type: "POST",
      data: {
        id: no_rekening_pembiayaan_field
      },
      success: function(ajaxData) {
        var obj = JSON.parse(ajaxData)
        $("#atas_nama").val(obj.nama)
        $("#periode_tagihan").val(obj.date)
        $("#show_periode_tagihan").val(obj.show_date)
        $("#jml_pokok").val(obj.pokok)
        $("#jml_bahas").val(obj.bagi_hasil)

        calculate()
      }
    });
  }

  function calculate(){
    var pokok = parseInt($("#jml_pokok").val())
    var bahas = parseInt($("#jml_bahas").val())
    var denda = parseInt($("#denda").val())

    var jumlah = pokok + bahas + denda
    $("#total").val(jumlah);
  }
</script>
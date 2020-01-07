<script>
    function manageAjax() {
        var no_anggota_field = $("#no_anggota").val()
        $.ajax({
            url: "<?php echo base_url() . 'index.php/sijaka/manageajaxgetdataanggota'; ?>",
            type: "POST",
            data: {
                id : no_anggota_field
            },
            success: function(ajaxData) {
                $('.data-ajax').html(ajaxData);
            }
        });
    }

    function manageDate() {
    var tgl_awal_field = $("#tgl_awal").val()
    var jangka_waktu_field = $("#jangka_waktu").val()

    $.ajax({
      url: "<?php echo base_url() . 'index.php/sijaka/manageajaxDate'; ?>",
      type: "POST",
      data: {
   
        tgl_awal_field: tgl_awal_field,
        jangka_waktu_field: jangka_waktu_field
      },
      success: function(response) {
        $("#tgl_akhir").val(response);

      }
    });
  }

    function manageHitungBahas(){
      var jumlah = parseInt($("#inputJumlah").val())
      //var nilai_bahas = parseInt($("#nilai_bahas").val())
      var nilai_bahas = 0.7/100
      var inputJmlBahas = jumlah * nilai_bahas
      $("#inputJmlBahas").val(inputJmlBahas)
    }

    function manageSimuda(){
      var no_rekening_simuda_field = $("#no_rekening_simuda").val()
      $.ajax({
        url: "<?php echo base_url() . 'index.php/sijaka/manageajaxsimuda'; ?>",
        type: "POST",
        data: {
          id : no_rekening_simuda_field 
        },
        success: function(ajaxData) {
          $('.data-ajax').html(ajaxData);
        }
      });
    }

    function managePembayaran() {
        var pembayaran_bahas_field = $("#inputPembayaranBahas").val()
        if(pembayaran_bahas_field == "Tunai"){
          $("#no_rekening_simuda").attr("disabled", "disabled")     
        }else if(pembayaran_bahas_field == "Kredit Rekening"){
          $("#no_rekening_simuda").removeAttr("disabled") 
        }      
    }

    function manageCustom() {
      var nilai_bahas_field = $("#inputBahas").val()
      if(nilai_bahas_field == "0.7%"){
        $("#inputJmlBahas").attr("readonly")
      }else if(nilai_bahas_field == "Custom"){
        $("#inputJmlBahas").removeAttr("readonly")
      }
    }
    $(document).ready(function () {
      $("#inputJmlBahas").attr("readonly", true);
      $('#inputBahas').change(function (e) {
        if ($(this).val() == 'Custom') {
          $("#inputJmlBahas").removeAttr("readonly")
        }
        else{
          $("#inputJmlBahas").attr("readonly", true)
        }
      });
    
    });
</script>
<!-- BreadCumb -->

<!-- Content -->
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
    <form method="POST" action="<?php echo base_url() . 'index.php/sijaka/simpanRekeningBaruSijaka' ?>">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="NRSj">No. Rekening</label>
          <input name="NRSj" type="text" class="form-control" id="NRSj" placeholder="84565xxxx" autofocus required>
        </div>
        <div class="col-md-4">
          <label for="">No. Anggota</label>
          <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
              <option value="">--Pilih--</option>
              <?php foreach($anggota as $a){ ?>
              <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota.' - '.$a->nama ?></option>
              <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="inputJumlah">Jumlah</label>
          <input name="jumlah" type="number" class="form-control" id="inputJumlah" placeholder="85000xxx" onkeyup="manageHitungBahas()" required>
        </div>
      </div>
      <div class='row data-ajax'>

      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputTanggalAwal">Tanggal Awal</label>
            <?php
            $tgl = date('Y-m-d');
            ?>
            <input name="tanggal_awal" type="date" class="form-control" id="tgl_awal" value="<?php echo $tgl; ?>" name="tgl_awal" placeholder="Tanggal Awal">
        </div>
        <div class="form-group col-md-4">
          <label for="inputJangkaWaktu">Jangka Waktu</label>
            <select name="jangka_waktu" id="jangka_waktu" class="form-control select2_" onchange="manageDate()" required>
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
            <label for="inputTanggalAkhir">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" readonly>
        </div>
      </div>
      <div class="form-row">
      </div>
       <div class="form-row">
        <div class="form-group col-md-2">
          <label for="inputNilaiBahas">Nilai Bahas</label>
          <select name="nilai_bahas" id="inputBahas" class="form-control" required>
            <option value="0.7%" selected>0.7%</option>
            <option value="Custom">Custom</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="inputJmlNilaiBahas">Jumlah Bayar Bahas</label>
          <input name="presentase_bagi_hasil_bulanan" type="number" class="form-control" value="" id="inputJmlBahas">
        </div>
        <div class="form-group col-md-2">
          <label for="perpanjanganOtomatis">Perpanjangan Otomatis</label>
          <select name="perpanjangan_otomatis" id="perpanjanganOtomatis" class="form-control" required>
            <option>--Pilih--</option>
            <option>Y</option>
            <option>N</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="inputPembayaranBahas">Pembayaran</label>
          <select name="pembayaran_bahas" id="inputPembayaranBahas" class="form-control" onchange="managePembayaran()" required>
          <option value="">--Pilih--</option>
            <option value="Tunai">Tunai</option>
            <option value="Kredit Rekening">Kredit Rekening</option>
          </select>
        </div>
        <div class="form-group col-md-4">
            <label for="">Rekening Simuda</label>
            <select name="no_rekening_simuda" id="no_rekening_simuda" class="form-control select2_" required>
                <option value="">--Pilih--</option>
                <?php foreach($simuda as $s){ ?>
                <option value="<?php echo $s->no_rekening_simuda; ?>"><?php echo $s->no_rekening_simuda.' - '.$s->nama ?></option>
                <?php } ?>
            </select>
        </div>  
      </div>
      <div>
        <div class="row mt-2">
          <div class="col-md-4">
              <button type="submit" class="btn btn-primary mr-1">Simpan</button>
              <button type="reset" class="btn btn-danger">Clear</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
</div>

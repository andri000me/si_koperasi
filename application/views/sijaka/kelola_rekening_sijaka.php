<script>
    $(document).ready(function(){
        $("#simpan_pengajuan").attr('disabled',true);
    });
    function getNominalSaldo() {
        var NRSj = $("#NRSj").val()
        $.ajax({
            url: "<?php echo base_url() . 'index.php/sijaka/getNominalSaldoSijaka'; ?>",
            type: "POST",
            data: {
                id : NRSj
            },
            success: function(ajaxData) {
                $('.data-ajax').html(ajaxData);
            }
        });
    }

    //tanya perhitungan algoritma saldo
    function hitungSaldoAkhir(){
           var saldo_awal = parseInt($("#saldo_awal").val())
           var tipe = $("#tipe").find(":selected").val()
           var jumlah = parseInt($("#jumlah").val())
           var saldo_akhir = 0

           if(tipe == "K"){
                saldo_akhir = saldo_awal + jumlah     
           }else if(tipe == "D"){
                saldo_akhir = saldo_awal - jumlah
           } 
           
           $("#saldo_akhir").val(saldo_akhir)
    }
    function controlButtonPengajuan(){
        var limit_debet = $("#limit_debet").val()
        var tipe = $("#tipe").find(":selected").val()
        var jumlah = parseInt($("#jumlah").val())
        
        if(tipe == "D" && jumlah>=limit_debet){
            $("#simpan_proses").attr('disabled',true);
            $("#simpan_pengajuan").attr('disabled',false);
        }else{
            $("#simpan_proses").attr('disabled',false);
            $("#simpan_pengajuan").attr('disabled',true);
            
        }
    }
</script>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Form Kelola Rekening</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Kelola Rekening</h6>
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
            <form method="POST" action="<?php echo base_url().'index.php/sijaka/simpanKelolaRekeningSijaka' ?>">
               <!-- <input type="hidden" name="limit_debet" id="limit_debet" value="<?php echo $limit_debet_simuda; ?>"> -->
                <div class="row">
                    <div class="col-md-4">
                        <label for="">No. Rekening</label>
                        <select name="NRSj" id="NRSj" class="form-control select2_" onchange="getNominalSaldo();controlButtonPengajuan()" required>
                            <option value="">--Pilih--</option>
                            <?php foreach($master_sijaka as $i){ ?>
                            <option value="<?php echo $i->NRSj; ?>"><?php echo $i->NRSj.' - '.$i->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="data-ajax col-md-4">
                        <label for="">Saldo Awal</label>
                        <input type="number" class="form-control" name="saldo_awal" id="saldo_awal" value="0" readonly required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Datetime</label>
                        <input type="datetime-local" class="form-control" name="datetime" id="datetime" value="<?php echo date('Y-m-d h:i'); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control" onchange="hitungSaldoAkhir();controlButtonPengajuan()" required>
                            <option value="K">Kredit</option>
                            <option value="D">Debit</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" onkeyup="hitungSaldoAkhir();controlButtonPengajuan()"  required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Saldo Akhir</label>
                        <input type="number" class="form-control" name="saldo_akhir" id="saldo_akhir" readonly required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <button type="submit" name="simpan_" id="simpan_proses" value="proses" class="btn btn-sm btn-primary mr-1">Proses</button>
                        <button type="submit" name="simpan_" id="simpan_pengajuan" value="pengajuan" class="btn btn-sm btn-success mr-1">Pengajuan</button>
                        <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
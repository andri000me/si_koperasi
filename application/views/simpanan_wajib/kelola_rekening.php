<script>
    $(document).ready(function(){
        $("#simpan_pengajuan").attr('disabled',true);
    });
    function getNominalSaldo(){
        var no_anggota = $('#no_anggota').val();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/simpanan_wajib/manageAjaxGetSaldo'; ?>",
            type: "POST",
            data: {
                no_anggota : no_anggota
            },
            success: function(ajaxData) {
                $('#saldo_awal').val(ajaxData);
            }
        });
    }

    function getBulan(){
        var no_anggota = $('#no_anggota').val();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/simpanan_wajib/manageAjaxGetBulan'; ?>",
            type: "POST",
            data: {
                no_anggota : no_anggota
            },
            success: function(response) {
                var obj = JSON.parse(response)
                $("#tgl_temp").val(obj.tgl_temp)
                $("#bulan_show").val(obj.tgl_temp_show)
                
                
            }
        });
    }
    
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
</script>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/simpanan_wajib/nominatif'; ?>">Simpanan Wajib</a></li>
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
            <form method="POST" action="<?php echo base_url().'index.php/Simpanan_Wajib/add' ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">No. Anggota</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="getNominalSaldo();getBulan()" required>
                            <option value="">--Pilih--</option>
                            <?php foreach($anggota as $a){ ?>
                            <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota.' - '.$a->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Saldo Awal</label>
                        <input type="number" class="form-control" name="saldo_awal" id="saldo_awal" value="0" readonly required>
                    </div>
                    <div class="col-md-3">
                        <label for="">Bulan</label>
                        <input type="hidden" name="tgl_temp" id="tgl_temp">
                        <input type="text" class="form-control" name="bulan_show" id="bulan_show" readonly required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Datetime</label>
                        <input type="datetime-local" class="form-control" name="tgl_pembayaran" id="datetime" value="<?php echo date('Y-m-d h:i'); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control" onchange="hitungSaldoAkhir();controlButtonPengajuan()" required>
                            <option value="K">Kredit</option>
                            <option value="D">Debit</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" onkeyup="hitungSaldoAkhir();controlButtonPengajuan()"  required>
                    </div>
                    <div class="col-md-3">
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
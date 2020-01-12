<script>
    function preview() {
        var nominal = $("#nominal").val()
        if(nominal == ""){
            return alert('Nominal Harus Diisi')
        }else{
            $.ajax({
                url: "<?php echo base_url() . 'index.php/simuda/previewPerhitunganAkhirBulan'; ?>",
                type: "POST",
                data: { nominal : nominal },
                success: function(ajaxData) {
                    $(".ajax-data").html(ajaxData);
                }
            });
        }
    }
</script>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Simuda</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perhitungan Bagi Hasil</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Perhitungan Bagi Hasil</h6>
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
            <form name="perhitungan_akhir_bulan" method="POST" action="<?php echo base_url().'index.php/simuda/simpanPerhitunganBagiHasil'; ?>">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="" class="font-weight-bold">Bulan</label>
                        <input type="text" name="bulan" id="bulan" class="form-control form-control-sm" value="<?php echo date('m',strtotime("last month")); ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="">Tahun</label>   
                        <input type="text" name="tahun" id="tahun" class="form-control form-control-sm" value="<?php echo date('Y',strtotime("last month")); ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="">Nominal</label>   
                        <input type="number" name="nominal" id="nominal" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-success mr-1" value="preview" onclick="preview()">Preview</button>
                        <button type="submit" class="btn btn-sm btn-primary" value="Simpan" onclick="return confirm('Anda Yakin?')">Simpan</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No.Rekening</th>
                            <th>No. Anggota</th>
                            <th>Nama</th>
                            <th>Saldo</th>
                            <th>Saldo Terendah</th>
                            <th>Saldo Terkini</th>
                            <th>Bagi Hasil</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="ajax-data">
                        <?php
                        $no = 1;
                        foreach($nominatif as $i){ 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $i->no_rekening_simuda; ?></td>
                            <td><?php echo $i->no_anggota; ?></td>
                            <td><?php echo $i->nama; ?></td>
                            <td class="text-right"><?php echo number_format($i->saldo_bulan_lalu,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($i->saldo_terendah_bulan_lalu,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($i->saldo_bulan_ini,0,',','.'); ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function preview(){
        $.ajax({
                url: "<?php echo base_url() . 'index.php/sijaka/previewHitungKewajibanBulanan'; ?>",
                type: "POST",
                success: function(ajaxData) {
                    $(".ajax-data").html(ajaxData);
                }
            });
    }
</script>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Hitung Kewajiban Bulanan</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hitung Kewajiban Bulanan</h6>
        </div>
        <div class="card-body">
            <?php
            echo $this->session->flashdata("input_success");
            echo $this->session->flashdata("input_failed");
            ?>
            <form name="hitung_kewajiban_bulanan" method="POST" action="<?php echo base_url().'index.php/sijaka/simpanPerhitunganKewajibanBulanan'; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <p style="font-weight:bold;font-style:italic;">**Perhitungan Dilakukan Pada Tanggal Terakhir Tiap Bulan</p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="" class="font-weight-bold">Bulan-Tahun</label>
                        <input type="text" name="bulan" id="bulan" class="form-control form-control-sm" value="<?php echo date('m-Y',strtotime("+1 month")); ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-success mr-1" value="preview" onclick="preview()">Preview</button>
                        <button type="submit" class="btn btn-sm btn-primary" value="Simpan" onclick="return confirm('Anda Yakin Menyimpan Data Pembayaran Sijaka Bulan Depan?')">Simpan</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NRSj</th>
                            <th>Anggota</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="ajax-data">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
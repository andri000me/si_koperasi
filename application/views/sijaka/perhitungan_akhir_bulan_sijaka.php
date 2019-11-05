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
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perhitungan Akhir Bulan</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Perhitungan Akhir Bulan</h6>
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
            <form name="perhitungan_akhir_bulan" method="POST" action="<?php echo base_url().'index.php/simuda/simpanPerhitunganAkhirBulan'; ?>">
            <div class="form-group row">
                <div class="col-md-1">
                    <label for="">Nominal</label>   
                </div>
                <div class="col-md-4">
                    <input type="number" name="nominal" id="nominal" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-success mr-1" value="preview" onclick="preview()">Preview</button>
                    <button type="submit" class="btn btn-sm btn-primary" value="Simpan"">Simpan</button>
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
                            <th>Saldo Bulan Ini</th>
                            <th>Saldo Terendah</th>
                            <th>Bagi Hasil</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <!-- <tbody class="ajax-data">
                        <?php
                        $no = 1;
                        foreach($nominatif as $i){ 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $i->no_rekening_simuda; ?></td>
                            <td><?php echo $i->no_anggota; ?></td>
                            <td><?php echo $i->nama; ?></td>
                            <td class="text-right"><?php echo number_format($i->saldo_bulan_ini,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($i->saldo_terendah,0,',','.'); ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                        </tr>
                        <?php } ?>
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/anggota/add">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">No. Anggota</label>
                                <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Terang</label>
                                <input type="text" name="nama_terang" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Status</label>
                                <select name="status" id="" class="form-control form-control-sm" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modaledit">
</div>
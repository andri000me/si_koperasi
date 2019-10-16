<script>
    function manageAjax() {
        var no_rekening_simuda = $("#no_rekening_simuda").val()
        $.ajax({
            url: "<?php echo base_url() . 'index.php/simuda/manageajaxgetmastersimuda'; ?>",
            type: "POST",
            data: {
                id : no_rekening_simuda
            },
            success: function(ajaxData) {
                $('.data-ajax').html(ajaxData);
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
    <li class="breadcrumb-item"><a href="#">Simuda</a></li>
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
            <form method="POST" action="<?php echo base_url().'index.php/simuda/simpanKelolaRekening' ?>">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">No. Rekening</label>
                        <input type="text" name="no_rekening_simuda" id="no_rekening_simuda" class="form-control" value="" onkeyup="manageAjax()" required>
                    </div>
                </div>
                <div class="row data-ajax">
                    
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
                        <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
                    </div>
                </div>
            </form>
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
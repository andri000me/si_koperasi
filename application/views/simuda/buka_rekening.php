<script>
    function manageAjax() {
        var no_anggota_field = $("#no_anggota").val()
        $.ajax({
            url: "<?php echo base_url() . 'index.php/simuda/manageajaxgetdataanggota'; ?>",
            type: "POST",
            data: {
                id: no_anggota_field
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
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Simuda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form Buka Rekening</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Buka Rekening</h6>
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
            <form method="POST" action="<?php echo base_url() . 'index.php/simuda/simpanRekeningBaru' ?>">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">No. Rekening</label>
                        <input type="text" name="no_rekening_simuda" class="form-control" value="" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">No. Anggota</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($anggota as $a) { ?>
                                <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota . ' - ' . $a->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row data-ajax">

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Saldo Awal</label>
                        <input type="number" name="saldo_awal" class="form-control" value="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Status</label>
                        <select name="status_pembukaan_rekening" id="" class="form-control">
                            <option value="0">Baru</option>
                            <option value="1">Migrasi Sistem</option>
                        </select>
                    </div>
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
<script>
    $(document).ready(function() {
        $('.select2_').select2({
            theme: 'bootstrap4',
        });
    });
</script>
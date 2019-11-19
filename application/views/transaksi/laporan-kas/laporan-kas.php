<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Kas</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Kas</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Kode Perkiraan</label>
                        <select name="kode" id="kode" class="form-control select2_" required>
                            <option value="">--Pilih Kode Perkiraan--</option>
                            <?php foreach ($rekening as $key) { ?>
                                <option value="<?php echo $key->kode_rekening; ?>" <?php echo isset($_GET['kode']) && $_GET['kode'] == $key->kode_rekening ? 'selected' : '' ?> ><?php echo $key->kode_rekening . ' - ' . $key->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Tanggal</label>
                        <?php
                        $tgl = date('Y-m-d');
                        ?>
                        <input type="date" class="form-control" id="dari" value="<?php echo isset($_GET['dari']) ? $_GET['dari'] : $tgl ?>" name="dari" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">S/d</label>
                        <input type="date" class="form-control" id="sampai" value="<?php echo isset($_GET['sampai']) ? $_GET['sampai'] : $tgl ?>" name="sampai" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-primary mr-1">Proses</button>
                        <button type="reset" class="btn btn-sm btn-default btn-secondary">Reset</button>
                    </div>
                </div>
            </form>

            <?php
            if (!empty($_GET['kode']) && !empty($_GET['dari']) && !empty($_GET['sampai'])) {
            ?>
                <br>
                <hr>
                <br>
                <center>
                    <h5>Koperasi Madani</h5>
                    <h6><b> Laporan Kas</b></h6>
                    <h6><b>Periode : <?php echo date('d-m-Y',strtotime($_GET['dari'])) . ' S/D ' . date('d-m-Y',strtotime($_GET['sampai'])) ?> </b></h6>
                </center>
            <?php
            }
            ?>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('.select2_').select2({
            theme: 'bootstrap4',
        });
    });
</script>
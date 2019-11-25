<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Bank</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Bank</h6>
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
                    <h6><b> Laporan Bank</b></h6>
                    <h6><b><?php echo $namaRekening->nama . ' (' . $namaRekening->kode_rekening . ')' ?></b></h6>
                    <h6><b>Periode : <?php echo date('d-m-Y',strtotime($_GET['dari'])) . ' S/D ' . date('d-m-Y',strtotime($_GET['sampai'])) ?> </b></h6>
                </center>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="table" width="100%" cellspacing="0">
                                <thead class="text-center bg-primary text-white">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode Bank</th>
                                        <th>Keterangan</th>
                                        <th>Lawan</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ttlMasuk = 0;
                                $ttlKeluar = 0;

                                foreach ($laporanBank as $key => $value) {
                                    
                                    if ($value->tipe == 'D') {
                                        $ttlMasuk = $ttlMasuk + $value->nominal;
                                    }
                                    else{
                                        $ttlKeluar = $ttlKeluar + $value->nominal;
                                    }
                                    $nominal = $value->tipe == 'D' ? '<td>' . number_format($value->nominal, 2, ',', '.') . '</td> <td align="center"> - </td>' : '<td align="center"> - </td> <td>' . number_format($value->nominal, 2, ',', '.') . '</td>' ;
                                    echo"
                                    <tr>
                                        <td>".date('d-m-Y', strtotime($value->tanggal))."</td>
                                        <td>$value->kode_trx_bank</td>
                                        <td>$value->keterangan</td>
                                        <td>$value->lawan</td>
                                        $nominal
                                    </tr>";
                                }
                                ?>
                                </tbody>
                                <tfoot class="bg-warning text-white">
                                    <tr align="center">
                                        <th colspan="4">Total</th>
                                        <th><?php echo number_format($ttlMasuk, 2, ',', '.') ?></th>
                                        <th><?php echo number_format($ttlKeluar, 2, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
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
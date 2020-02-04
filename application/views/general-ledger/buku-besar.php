<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">General Ledger</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku Besar</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buku Besar</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Kode Perkiraan</label>
                        <select name="kode" id="kode" class="form-control select2_" required>
                            <option value="">--Pilih Kode Perkiraan--</option>
                            <?php foreach ($allRekening as $key) { ?>
                                <option value="<?php echo $key->kode_rekening; ?>" <?php echo isset($_GET['kode']) && $_GET['kode'] == $key->kode_rekening ? 'selected' : '' ?> ><?php echo $key->kode_rekening . ' - ' . $key->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">S/d</label>
                        <select name="rk_sampai" id="rk_sampai" class="form-control select2_">
                            <option value="">--Pilih Kode Perkiraan--</option>
                            <?php foreach ($allRekening as $key) { ?>
                                <option value="<?php echo $key->kode_rekening; ?>" <?php echo isset($_GET['rk_sampai']) && $_GET['rk_sampai'] == $key->kode_rekening ? 'selected' : '' ?> ><?php echo $key->kode_rekening . ' - ' . $key->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Tanggal</label>
                        <?php
                        $tgl = date('Y-m-d');
                        ?>
                        <input type="date" class="form-control" id="dari" value="<?php echo isset($_GET['dari']) ? $_GET['dari'] : $tgl ?>" name="dari" required>
                    </div>
                    <div class="form-group col-md-3">
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
                    <h6><b>Periode : <?php echo date('d-m-Y',strtotime($_GET['dari'])) . ' S/D ' . date('d-m-Y',strtotime($_GET['sampai'])) ?> </b></h6>
                </center>
                <?php
                foreach ($kode as $key => $valKode) {
                ?>
                    <center><h6><b>Buku Besar : <?= $valKode->nama ." (". $valKode->kode_rekening .")" ?></b></h6></center>
                    <div class="table-resposive">
                        <table class="table table-bordered table-hover table-striped" id="table" width="100%" cellspacing="0">
                            <thead class="text-center bg-primary text-white">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nomor Bukti</th>
                                    <th>Keterangan</th>
                                    <th>Lawan</th>
                                    <th>Debet Rp.</th>
                                    <th>Kredit Rp.</th>
                                    <th>Saldo Rp.</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_debet = 0;
                            $total_kredit = 0;
                            $saldo = 0;

                            // count jumlah transaksi sebelum tanggal dari
                            $cekTransaksi = $this->M_buku_besar->cekTransaksi($valKode->kode_rekening, $_GET['dari'])[0];
                            
                            // ambil saldo awal per kode rekening
                            $getSaldoAwal = $this->M_buku_besar->getSaldoAwal($valKode->kode_rekening)[0];

                            // cek tipe rekening (debet atau kredit)
                            $tipeRekening = $this->M_buku_besar->cekTipeRk($valKode->kode_rekening)[0];
                            
                            // cek apakah ada transaksi sebelum tanggal dari
                            if ($cekTransaksi->jml_transaksi > 0) {
                                // count jumlah $valKode->kode_rekening yg ada di field kode di ak_jurnal
                                $getField =  $this->M_buku_besar->getField($valKode->kode_rekening, $_GET['dari'])[0];

                                // menampung nominal ketika $valKode->kode_rekening terdapat juga di field lawan
                                $saldoAwalDebet2 = 0;
                                $saldoAwalKredit2 = 0;

                                // cek apakah $valKode->kode_rekening terdapat di field kode
                                if ($getField->jml > 0) {
                                    $getSaldoDebet = $this->M_buku_besar->getSaldoDebet($valKode->kode_rekening, $_GET['dari'])[0];

                                    $getSaldoKredit = $this->M_buku_besar->getSaldoKredit($valKode->kode_rekening, $_GET['dari'])[0];

                                    // count $valKode->kode_rekening yg ada di field lawan
                                    $cekLawan = $this->M_buku_besar->cekLawan($valKode->kode_rekening, $_GET['dari'])[0];

                                    if ($cekLawan->jml > 0) {
                                        $getSaldoDebet2 = $this->M_buku_besar->getSaldoDebet2($valKode->kode_rekening, $_GET['dari'])[0];

                                        $getSaldoKredit2 = $this->M_buku_besar->getSaldoKredit2($valKode->kode_rekening, $_GET['dari'])[0];

                                        $saldoAwalDebet2 = $getSaldoDebet2->saldo;
                                        $saldoAwalKredit2 = $getSaldoKredit2->saldo;
                                    }
                                }
                                else{
                                    $getSaldoDebet = $this->M_buku_besar->getSaldoDebet2($valKode->kode_rekening, $_GET['dari'])[0];

                                    $getSaldoKredit = $this->M_buku_besar->getSaldoKredit2($valKode->kode_rekening, $_GET['dari'])[0];
                                }

                                // hitung saldo awal dari $valKode->kode_rekening
                                if ($tipeRekening->tipe == 'D') {
                                    $saldo = $getSaldoAwal->saldo_awal + ($getSaldoDebet->saldo + $saldoAwalDebet2 - $getSaldoKredit->saldo - $saldoAwalKredit2);
                                }
                                else{
                                    $saldo = $getSaldoAwal->saldo_awal - ($getSaldoDebet->saldo + $saldoAwalDebet2) + ($getSaldoKredit->saldo + $saldoAwalKredit2);
                                }
                                
                            }
                            else{
                                $saldo = $getSaldoAwal->saldo_awal;
                            }

                            $tgl = date('d-m-Y', strtotime($_GET['dari']));
                            echo "
                                <tr>
                                    <td>$tgl</td>
                                    <td>-</td>
                                    <td>Saldo Awal</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>". number_format($saldo, 2, ',', '.') ."</td>
                                </tr>
                            ";

                            // get data transaksi dari tb ak_jurnal
                            $bukuBesar = $this->M_buku_besar->getBukuBesar($valKode->kode_rekening, $_GET['dari'], $_GET['sampai']);

                            foreach ($bukuBesar as $key => $value) {
                                // cek lawannya ada di field lawan apa di field kode
                                if ($value->kode == $valKode->kode_rekening) {
                                    $fieldLawan = 'lawan';
                                }
                                else{
                                    $fieldLawan = 'kode';
                                }

                                $tanggal = date('d-m-Y', strtotime($value->tanggal));
                            ?>
                                <tr>
                                    <td> <?php echo $tanggal ?> </td>
                                    <td> <?php echo $value->kode_transaksi ?> </td>
                                    <td> <?php echo $value->keterangan ?> </td>
                                    <td> <?php echo $value->$fieldLawan . ' ( ' . $this->M_buku_besar->getNamaRekening($value->$fieldLawan) . ' )'  ?> </td>
                                    <?php
                                    // jika lawan terdapat di field lawan
                                    if ($fieldLawan == 'lawan') {
                                        // jika tipe transaksi = debet
                                        if ($value->tipe == 'D') {
                                            $total_debet = $total_debet + $value->nominal;
                                            // jika tipe rekening = debet
                                            if ($tipeRekening->tipe == 'D') {
                                                // total debet dan saldo akhir akan bertambah
                                                $saldo = $saldo + $value->nominal;
                                            }
                                            else{
                                                // total debet bertambah, saldo akhir akan berkurang
                                                $saldo = $saldo - $value->nominal;
                                            }
                                            echo "
                                            <td>". number_format($value->nominal, 2, ',', '.') ."</td>
                                            <td></td>
                                            <td>". number_format($saldo, 2, ',', '.') ."</td>
                                            ";
                                        }
                                        // tipe transaksi = kredit
                                        else{
                                            $total_kredit = $total_kredit + $value->nominal;
                                            // jika tipe rekening nya = debet, maka total kredit bertambah, saldo berkurang
                                            if ($tipeRekening->tipe == 'D') {
                                                $saldo = $saldo - $value->nominal;
                                            }
                                            else{
                                                // total debet bertambah, saldo akhir akan bertambah
                                                $saldo = $saldo + $value->nominal;
                                            }
                                            echo "
                                            <td></td>
                                            <td>". number_format($value->nominal, 2, ',', '.') ."</td>
                                            <td>". number_format($saldo, 2, ',', '.') ."</td>
                                            ";
                                        }
                                    }
                                    // jika lawan terdapat di field kode
                                    else{
                                        if ($value->tipe == 'D') {
                                            $total_kredit = $total_kredit + $value->nominal;
                                            if ($tipeRekening->tipe == 'D') {
                                                $saldo = $saldo - $value->nominal;
                                            }
                                            else{
                                                $saldo = $saldo + $value->nominal;
                                            }
                                            echo "
                                            <td></td>
                                            <td>". number_format($value->nominal, 2, ',', '.') ."</td>
                                            <td>". number_format($saldo, 2, ',', '.') ."</td>
                                            ";
                                        }
                                        else{
                                            $total_debet = $total_debet + $value->nominal;
                                            if ($tipeRekening->tipe == 'D') {
                                                $saldo = $saldo + $value->nominal;
                                            }else{
                                                $saldo = $saldo - $value->nominal;
                                            }
                                            echo "
                                            <td>". number_format($value->nominal, 2, ',', '.') ."</td>
                                            <td></td>
                                            <td>". number_format($saldo, 2, ',', '.') ."</td>
                                            ";
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <tfoot class="bg-warning text-white">
                                <tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th><?php echo number_format($total_debet, 2, ',', '.') ?></th>
									<th><?php echo number_format($total_kredit, 2, ',', '.') ?></th>
									<th></th>
								</tr>
                            </tfoot>
                        </table>
                    </div>
                <?php
                echo "<br>";
                }
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
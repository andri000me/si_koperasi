<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">General Ledger</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laba Rugi</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laba Rugi Bulanan</h6>
        </div>
        <div class="card-body">
        <?php
        $month = date('Y-m');
        ?>
        <form method="GET" action="">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Bulan</label>
                        <input type="month" name="bulan" id="bulan" class="form-control" value="<?php echo isset($_GET['bulan']) ? $_GET['bulan'] : $month ?>">
                    </div>
                    <!-- <div class="col-md-9"></div> -->
                    <div class="col-md-3 mt-4">
                        <button type="submit" style="margin-top: 5%;" class="btn btn-sm btn-primary mr-1">Filter</button>
                        <button type="reset" style="margin-top: 5%;" class="btn btn-sm btn-default btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_GET['bulan'])) {
            ?>
            <br>
            <hr>
            <br>
            <center>
            <h5><b>Koperasi Madani</b></h5>
            <h6><b>Laba Rugi Bulanan</b></h6>
            <h6><b>Bulan : <?php echo date('m - Y', strtotime($_GET['bulan']))?></b></h6>
            </center>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="table" width="100%" cellspacing="0">
                            <thead class="text-center bg-primary text-white">
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle">Kode</th>
                                    <th rowspan="2" style="vertical-align:middle">Keterangan</th>
                                    <th colspan="2">Saldo Awal</th>
                                    <th colspan="2">Mutasi</th>
                                    <th colspan="2">Saldo Akhir</th>
                                    <tr>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </tr>
                            </thed>
                            <tbody>
                            <?php
                            /*
                            $ttlSaldoAwalDebet = 0;
                            $ttlSaldoAwalKredit = 0;
                            $ttlMutasiDebet = 0;
                            $ttlMutasiKredit = 0;
                            $ttlSaldoAkhirDebet = 0;
                            $ttlSaldoAkhirKredit = 0;
                            
                            foreach ($rekening as $key => $valKode) {
                                $tipeRekening = $this->M_neraca_saldo->cekTipeRk($valKode->kode_rekening)[0];

                                // cek apakah ada di field kode
                                $cekField = $this->M_neraca_saldo->cekField($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];
                                
                                // cek trx  sebelumnya dari field kode
                                $cekTrx = $this->M_neraca_saldo->cekTrx($valKode->kode_rekening, $_GET['dari'])[0];

                                // cek apakah $valKode->kode ada di field kode
                                if ($cekField->ttl > 0) {
                                    // nyimpen saldo sementara
                                    $tempDebet = 0;
                                    $tempKredit = 0;

                                    // sum total mutasi debet
                                    $sumMutasiDebet = $this->M_neraca_saldo->sumMutasiDebet($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];
                                    
                                    // sum total mutasi kredit
                                    $sumMutasiKredit = $this->M_neraca_saldo->sumMutasiKredit($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                    $tempDebet = $sumMutasiDebet->ttl;
                                    $tempKredit = $sumMutasiKredit->ttl;

                                    // cek apakah $valKode->kode juga terdapat di field lawan
                                    $cekLawan = $this->M_neraca_saldo->cekLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];
                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_neraca_saldo->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                        $sumMutasiKredit = $this->M_neraca_saldo->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                        $tempDebet = $tempDebet + $sumMutasiDebet->ttl;
                                        $tempKredit = $tempKredit + $sumMutasiKredit->ttl;
                                    }
                                    $mutasiDebet = $tempDebet;
                                    $mutasiKredit = $tempKredit;
                                }
                                else{
                                    $cekLawan = $this->M_neraca_saldo->cekLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_neraca_saldo->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                        $sumMutasiKredit = $this->M_neraca_saldo->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['dari'], $_GET['sampai'])[0];

                                        $mutasiDebet = $sumMutasiDebet->ttl;
                                        $mutasiKredit = $sumMutasiKredit->ttl;
                                    }
                                    else{
                                        $mutasiDebet = 0;
                                        $mutasiKredit = 0;
                                    }
                                }

                                if ($cekTrx->ttl > 0) {
                                    $tempAwalDebet = 0;
                                    $tempAwalKredit = 0;

                                    $sumMutasiAwalDebet = $this->M_neraca_saldo->sumMutasiAwalDebet($valKode->kode_rekening, $_GET['dari'])[0];

                                    $sumMutasiAwalKredit = $this->M_neraca_saldo->sumMutasiAwalKredit($valKode->kode_rekening, $_GET['dari'])[0];

                                    if ($tipeRekening->tipe == 'D') {
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl;
                                    }
                                    else{
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl  + $valKode->saldo_awal;
                                    }

                                    // cek apakah trx sebelumnya juga ada di field lawan
                                    $cekLawanBefore = $this->M_neraca_saldo->cekLawanBefore($valKode->kode_rekening, $_GET['dari'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_neraca_saldo->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['dari'])[0];

                                        $sumMutasiAwalKredit = $this->M_neraca_saldo->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['dari'])[0];

                                        $tempAwalDebet = $tempAwalDebet + $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $tempAwalKredit + $sumMutasiAwalKredit->ttl;
                                    }

                                    $mutasiAwalDebet = $tempAwalDebet;
                                    $mutasiAwalKredit = $tempAwalKredit;
                                }
                                else{
                                    $cekLawanBefore = $this->M_neraca_saldo->cekLawanBefore($valKode->kode_rekening, $_GET['dari'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_neraca_saldo->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['dari'])[0];

                                        $sumMutasiAwalKredit = $this->M_neraca_saldo->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['dari'])[0];

                                        if ($tipeRekening->tipe == 'D') {
                                            $mutasiAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                            $mutasiAwalKredit = $sumMutasiAwalKredit->ttl;
                                        }
                                        else {
                                            $mutasiAwalDebet = $sumMutasiAwalDebet->ttl;
                                            $mutasiAwalKredit = $sumMutasiAwalKredit->ttl + $valKode->saldo_awal;
                                        }

                                    }
                                    else{
                                        if ($tipeRekening->tipe == 'D') {
                                            $mutasiAwalDebet = $valKode->saldo_awal;
                                            $mutasiAwalKredit = 0;
                                        }else {
                                            $mutasiAwalDebet = 0;
                                            $mutasiAwalKredit = $valKode->saldo_awal;
                                        }
                                    }
                                }

                                $saldoAkhir = ($mutasiAwalDebet + $mutasiDebet) - ($mutasiAwalKredit + $mutasiKredit);
                                $ttlMutasiDebet = $ttlMutasiDebet + $mutasiDebet;
                                $ttlMutasiKredit = $ttlMutasiKredit + $mutasiKredit;
                                $saldoAwal = $mutasiAwalDebet - $mutasiAwalKredit;

                                if ($tipeRekening->tipe == 'D') {
                                    $ttlSaldoAkhirDebet = $ttlSaldoAkhirDebet + $saldoAkhir;
                                    $ttlSaldoAwalDebet = $ttlSaldoAwalDebet + $saldoAwal;
                                }
                                else{
                                    $ttlSaldoAkhirKredit = ($ttlSaldoAkhirKredit + $saldoAkhir);
                                    $ttlSaldoAwalKredit = $ttlSaldoAwalKredit + $saldoAwal;
                                }
                                */
                            ?>
                                <!-- <tr>
                                    <td><?php echo $valKode->kode_rekening ?></td>
                                    <td><?php echo $valKode->nama ?></td>
                                    <?php
                                    if ($tipeRekening->tipe == 'D') {
                                        echo "<td>". number_format($saldoAwal, 2, ',', '.') ."</td> <td>0,00</td>";
                                    }else{
                                        echo "<td>0,00</td> <td>". number_format($saldoAwal * -1, 2, ',', '.') ."</td>";
                                    }
                                    echo '<td>'. number_format($mutasiDebet, 2, ',', '.') .'</td>';
                                    echo '<td>'. number_format($mutasiKredit, 2, ',', '.') .'</td>';
                                    if ($tipeRekening->tipe == 'D') {
                                        echo "<td>". number_format($saldoAkhir, 2, ',', '.') ."</td> <td>0,00</td>";
                                    }else{
                                        echo "<td>0,00</td> <td>". number_format($saldoAkhir * -1, 2, ',', '.') ."</td>";
                                    }
                                    ?>
                                </tr> -->
                            <?php
                            // }
                            ?>
                            </tbody>
                            <tfoot class="bg-warning text-white">
                                <!-- <th colspan="2"></th>
                                <th><?php echo number_format($ttlSaldoAwalDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAwalKredit * -1, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlMutasiDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlMutasiKredit, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAkhirDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAkhirKredit * -1, 2, ',', '.') ?></th> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <?php
            }
            ?>

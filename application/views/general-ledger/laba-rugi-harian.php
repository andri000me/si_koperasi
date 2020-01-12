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
            <h6 class="m-0 font-weight-bold text-primary">Laba Rugi</h6>
        </div>
        <div class="card-body">
        <?php
        $date = date('Y-m-d');
        ?>
        <form method="GET" action="">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : $date ?>">
                    </div>
                    <!-- <div class="col-md-9"></div> -->
                    <div class="col-md-3 mt-4">
                        <button type="submit" style="margin-top: 5%;" class="btn btn-sm btn-primary mr-1">Filter</button>
                        <button type="reset" style="margin-top: 5%;" class="btn btn-sm btn-default btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_GET['tanggal'])) {
            ?>
            <br>
            <hr>
            <br>
            <center>
            <h5><b>Koperasi Madani</b></h5>
            <h6><b>Laba Rugi</b></h6>
            <h6><b>Tanggal : <?php echo date('d-m-Y', strtotime($_GET['tanggal']))?></b></h6>
            </center>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="table" width="100%" cellspacing="0">
                            <thead class="text-center bg-primary text-white">
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle">Kode</th>
                                    <th rowspan="2" style="vertical-align:middle">Keterangan</th>
                                    <th rowspan="2" style="vertical-align:middle">Saldo Awal</th>
                                    <th colspan="2">Mutasi</th>
                                    <th rowspan="2" style="vertical-align:middle">Saldo Akhir</th>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </tr>
                            </thed>
                            <tbody>
                            <tr>
                                <th></th>
                                <th>PENDAPATAN</th>
                                <th colspan="4"></th>
                            </tr>
                            <?php
                            
                            $ttlSaldoAwalDebet = 0;
                            $ttlSaldoAwalKredit = 0;
                            $ttlMutasiDebet = 0;
                            $ttlMutasiKredit = 0;
                            $ttlSaldoAkhirDebet = 0;
                            $ttlSaldoAkhirKredit = 0;
                            $totalPendapatan = 0;
                            $totalPendapatanAwal = 0;
                            $totalBiaya = 0;
                            $totalBiayaAwal = 0;
                            $totalBiayaNonOperasional = 0;
                            $totalBiayaNonOperasionalAwal = 0;
                            $totalPajakPenghasilan = 0;
                            $totalPajakPenghasilanAwal = 0;                            
                            $totalMutasiBiaya = 0;
                            $totalMutasiPendapatan = 0;
                            foreach ($rekeningPendapatan as $key => $valKode) {
                                $tipeRekening = $this->M_laba_rugi->cekTipeRk($valKode->kode_rekening)[0];

                                // cek apakah ada di field kode
                                $cekField = $this->M_laba_rugi->cekField($valKode->kode_rekening, $_GET['tanggal'])[0];
                                
                                // cek trx  sebelumnya dari field kode
                                $cekTrx = $this->M_laba_rugi->cekTrx($valKode->kode_rekening, $_GET['tanggal'])[0];

                                // cek apakah $valKode->kode ada di field kode
                                if ($cekField->ttl > 0) {
                                    // nyimpen saldo sementara
                                    $tempDebet = 0;
                                    $tempKredit = 0;

                                    // sum total mutasi debet
                                    $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebet($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    
                                    // sum total mutasi kredit
                                    $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $tempDebet = $sumMutasiDebet->ttl;
                                    $tempKredit = $sumMutasiKredit->ttl;

                                    // cek apakah $valKode->kode juga terdapat di field lawan
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempDebet = $tempDebet + $sumMutasiDebet->ttl;
                                        $tempKredit = $tempKredit + $sumMutasiKredit->ttl;
                                    }
                                    $mutasiDebet = $tempDebet;
                                    $mutasiKredit = $tempKredit;
                                }
                                else{
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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

                                    $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebet($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($tipeRekening->tipe == 'D') {
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl;
                                    }
                                    else{
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl  + $valKode->saldo_awal;
                                    }

                                    // cek apakah trx sebelumnya juga ada di field lawan
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempAwalDebet = $tempAwalDebet + $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $tempAwalKredit + $sumMutasiAwalKredit->ttl;
                                    }

                                    $mutasiAwalDebet = $tempAwalDebet;
                                    $mutasiAwalKredit = $tempAwalKredit;
                                }
                                else{
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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
                                
                            ?>
                                <tr>
                                    <td><?php echo $valKode->kode_rekening ?></td>
                                    <td><?php echo $valKode->nama ?></td>
                                    <?php
                                    echo "<td>". number_format($saldoAwal, 2, ',', '.') ."</td>";
                                    echo '<td>'. number_format($mutasiDebet, 2, ',', '.') .'</td>';
                                    echo '<td>'. number_format($mutasiKredit, 2, ',', '.') .'</td>';
                                    echo "<td>". number_format($saldoAkhir * -1, 2, ',', '.') ."</td>";
                                    
                                    ?>
                                </tr>
                            <?php
                            $totalMutasiPendapatan += $mutasiKredit;
                            $totalPendapatanAwal += $saldoAwal;
                            $totalPendapatan += $saldoAkhir;
                            }
                            ?>
                            <tr>
                                <th></th>
                                <th>TOTAL PENDAPATAN</th>
                                <?php
                                echo "<th>". number_format($totalPendapatanAwal * -1, 2, ',', '.') ."</th>";
                                ?>
                                <th colspan="2"></th>
                                <?php
                                echo "<th>". number_format($totalPendapatan * -1, 2, ',', '.') ."</th>";
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <th>BIAYA-BIAYA</th>
                                <th colspan="4"></th>
                            </tr>
                            <?php
                            foreach ($rekeningBiaya as $key => $valKode) {
                                $tipeRekening = $this->M_laba_rugi->cekTipeRk($valKode->kode_rekening)[0];

                                // cek apakah ada di field kode
                                $cekField = $this->M_laba_rugi->cekField($valKode->kode_rekening, $_GET['tanggal'])[0];
                                
                                // cek trx  sebelumnya dari field kode
                                $cekTrx = $this->M_laba_rugi->cekTrx($valKode->kode_rekening, $_GET['tanggal'])[0];

                                // cek apakah $valKode->kode ada di field kode
                                if ($cekField->ttl > 0) {
                                    // nyimpen saldo sementara
                                    $tempDebet = 0;
                                    $tempKredit = 0;

                                    // sum total mutasi debet
                                    $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebet($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    
                                    // sum total mutasi kredit
                                    $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $tempDebet = $sumMutasiDebet->ttl;
                                    $tempKredit = $sumMutasiKredit->ttl;

                                    // cek apakah $valKode->kode juga terdapat di field lawan
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempDebet = $tempDebet + $sumMutasiDebet->ttl;
                                        $tempKredit = $tempKredit + $sumMutasiKredit->ttl;
                                    }
                                    $mutasiDebet = $tempDebet;
                                    $mutasiKredit = $tempKredit;
                                }
                                else{
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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

                                    $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebet($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($tipeRekening->tipe == 'D') {
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl;
                                    }
                                    else{
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl  + $valKode->saldo_awal;
                                    }

                                    // cek apakah trx sebelumnya juga ada di field lawan
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempAwalDebet = $tempAwalDebet + $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $tempAwalKredit + $sumMutasiAwalKredit->ttl;
                                    }

                                    $mutasiAwalDebet = $tempAwalDebet;
                                    $mutasiAwalKredit = $tempAwalKredit;
                                }
                                else{
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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
                                
                            ?>
                                <tr>
                                    <td><?php echo $valKode->kode_rekening ?></td>
                                    <td><?php echo $valKode->nama ?></td>
                                    <?php
                                        echo "<td>". number_format($saldoAwal, 2, ',', '.') ."</td>";
                                    echo '<td>'. number_format($mutasiDebet, 2, ',', '.') .'</td>';
                                    echo '<td>'. number_format($mutasiKredit, 2, ',', '.') .'</td>';
                                    
                                    echo "<td>". number_format($saldoAkhir, 2, ',', '.') ."</td>";
                                    
                                    ?>
                                </tr>
                            <?php
                                $totalMutasiBiaya += $mutasiDebet;
                                $totalBiayaAwal += $saldoAwal;
                                $totalBiaya += $saldoAkhir;
                            }
                            ?>
                            <tr>
                                <th></th>
                                <th>TOTAL BIAYA</th>
                                <?php
                                echo "<th>". number_format($totalBiayaAwal, 2, ',', '.') ."</th>";
                                ?>
                                <th colspan="2"></th>
                                <?php
                                echo "<th>". number_format($totalBiaya, 2, ',', '.') ."</th>";
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Biaya Non Operasional</th>
                                <th colspan="4"></th>
                            </tr>
                            <?php
                            foreach ($rekeningBiayaNonOperasional as $key => $valKode) {
                                $tipeRekening = $this->M_laba_rugi->cekTipeRk($valKode->kode_rekening)[0];

                                // cek apakah ada di field kode
                                $cekField = $this->M_laba_rugi->cekField($valKode->kode_rekening, $_GET['tanggal'])[0];
                                
                                // cek trx  sebelumnya dari field kode
                                $cekTrx = $this->M_laba_rugi->cekTrx($valKode->kode_rekening, $_GET['tanggal'])[0];

                                // cek apakah $valKode->kode ada di field kode
                                if ($cekField->ttl > 0) {
                                    // nyimpen saldo sementara
                                    $tempDebet = 0;
                                    $tempKredit = 0;

                                    // sum total mutasi debet
                                    $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebet($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    
                                    // sum total mutasi kredit
                                    $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $tempDebet = $sumMutasiDebet->ttl;
                                    $tempKredit = $sumMutasiKredit->ttl;

                                    // cek apakah $valKode->kode juga terdapat di field lawan
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempDebet = $tempDebet + $sumMutasiDebet->ttl;
                                        $tempKredit = $tempKredit + $sumMutasiKredit->ttl;
                                    }
                                    $mutasiDebet = $tempDebet;
                                    $mutasiKredit = $tempKredit;
                                }
                                else{
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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

                                    $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebet($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($tipeRekening->tipe == 'D') {
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl;
                                    }
                                    else{
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl  + $valKode->saldo_awal;
                                    }

                                    // cek apakah trx sebelumnya juga ada di field lawan
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempAwalDebet = $tempAwalDebet + $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $tempAwalKredit + $sumMutasiAwalKredit->ttl;
                                    }

                                    $mutasiAwalDebet = $tempAwalDebet;
                                    $mutasiAwalKredit = $tempAwalKredit;
                                }
                                else{
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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
                                
                            ?>
                                <tr>
                                    <td><?php echo $valKode->kode_rekening ?></td>
                                    <td><?php echo $valKode->nama ?></td>
                                    <?php
                                        echo "<td>". number_format($saldoAwal, 2, ',', '.') ."</td>";
                                    echo '<td>'. number_format($mutasiDebet, 2, ',', '.') .'</td>';
                                    echo '<td>'. number_format($mutasiKredit, 2, ',', '.') .'</td>';
                                    
                                    echo "<td>". number_format($saldoAkhir, 2, ',', '.') ."</td>";
                                    
                                    ?>
                                </tr>
                            <?php
                                $totalBiayaNonOperasionalAwal += $saldoAwal;
                                $totalBiayaNonOperasional += $saldoAkhir;
                            }
                            ?>
                            <tr>
                                <th></th>
                                <th>SHU Sebelum Pajak</th>
                                <?php
                                $shuSebelumPajakAwal = ($totalPendapatanAwal * -1) - $totalBiayaAwal - $totalBiayaNonOperasionalAwal;
                                if ($shuSebelumPajakAwal < 0) {
                                    echo "<th> ( ". number_format($shuSebelumPajakAwal, 2, ',', '.') ." ) </th>";
                                }
                                else{
                                    echo "<th>". number_format($shuSebelumPajakAwal, 2, ',', '.') ."</th>";
                                }
                                ?>

                                <?php
                                $shuSebelumPajak = $totalMutasiPendapatan - $totalMutasiBiaya;
                                if ($shuSebelumPajak < 0) {
                                    echo "<th> ( ". number_format($shuSebelumPajak, 2, ',', '.') ." ) </th>";
                                }
                                else{
                                    echo "<th>". number_format($shuSebelumPajak, 2, ',', '.') ."</th>";
                                }
                                echo "<th></th> <th>". number_format($shuSebelumPajakAwal + $shuSebelumPajak, 2, ',', '.') ."</th>";
                                ?>
                            </tr>
                            <!-- <tr>
                                <th></th>
                                <th>Biaya Non Operasional</th>
                                <th colspan="4"></th>
                            </tr> -->
                            <tr>
                                <th></th>
                                <th>Pajak Penghasilan</th>
                                <th colspan="4"></th>
                            </tr>
                            <?php
                            foreach ($rekeningPajakPenghasilan as $key => $valKode) {
                                $tipeRekening = $this->M_laba_rugi->cekTipeRk($valKode->kode_rekening)[0];

                                // cek apakah ada di field kode
                                $cekField = $this->M_laba_rugi->cekField($valKode->kode_rekening, $_GET['tanggal'])[0];
                                
                                // cek trx  sebelumnya dari field kode
                                $cekTrx = $this->M_laba_rugi->cekTrx($valKode->kode_rekening, $_GET['tanggal'])[0];

                                // cek apakah $valKode->kode ada di field kode
                                if ($cekField->ttl > 0) {
                                    // nyimpen saldo sementara
                                    $tempDebet = 0;
                                    $tempKredit = 0;

                                    // sum total mutasi debet
                                    $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebet($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    
                                    // sum total mutasi kredit
                                    $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $tempDebet = $sumMutasiDebet->ttl;
                                    $tempKredit = $sumMutasiKredit->ttl;

                                    // cek apakah $valKode->kode juga terdapat di field lawan
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempDebet = $tempDebet + $sumMutasiDebet->ttl;
                                        $tempKredit = $tempKredit + $sumMutasiKredit->ttl;
                                    }
                                    $mutasiDebet = $tempDebet;
                                    $mutasiKredit = $tempKredit;
                                }
                                else{
                                    $cekLawan = $this->M_laba_rugi->cekLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($cekLawan->ttl > 0) {
                                        $sumMutasiDebet = $this->M_laba_rugi->sumMutasiDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiKredit = $this->M_laba_rugi->sumMutasiKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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

                                    $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebet($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKredit($valKode->kode_rekening, $_GET['tanggal'])[0];

                                    if ($tipeRekening->tipe == 'D') {
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl + $valKode->saldo_awal;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl;
                                    }
                                    else{
                                        $tempAwalDebet = $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $sumMutasiAwalKredit->ttl  + $valKode->saldo_awal;
                                    }

                                    // cek apakah trx sebelumnya juga ada di field lawan
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $tempAwalDebet = $tempAwalDebet + $sumMutasiAwalDebet->ttl;
                                        $tempAwalKredit = $tempAwalKredit + $sumMutasiAwalKredit->ttl;
                                    }

                                    $mutasiAwalDebet = $tempAwalDebet;
                                    $mutasiAwalKredit = $tempAwalKredit;
                                }
                                else{
                                    $cekLawanBefore = $this->M_laba_rugi->cekLawanBefore($valKode->kode_rekening, $_GET['tanggal'])[0];
                                    if ($cekLawanBefore->ttl > 0) {
                                        $sumMutasiAwalDebet = $this->M_laba_rugi->sumMutasiAwalDebetByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

                                        $sumMutasiAwalKredit = $this->M_laba_rugi->sumMutasiAwalKreditByLawan($valKode->kode_rekening, $_GET['tanggal'])[0];

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
                                
                            ?>
                                <tr>
                                    <td><?php echo $valKode->kode_rekening ?></td>
                                    <td><?php echo $valKode->nama ?></td>
                                    <?php
                                        echo "<td>". number_format($saldoAwal, 2, ',', '.') ."</td>";
                                    echo '<td>'. number_format($mutasiDebet, 2, ',', '.') .'</td>';
                                    echo '<td>'. number_format($mutasiKredit, 2, ',', '.') .'</td>';
                                    
                                    echo "<td>". number_format($saldoAkhir, 2, ',', '.') ."</td>";
                                    
                                    ?>
                                </tr>
                            <?php
                                $totalPajakPenghasilanAwal += $saldoAwal;
                                $totalPajakPenghasilan += $saldoAkhir;
                            }
                            ?>
                            <tr>
                                <th></th>
                                <th>SISA HASIL USAHA</th>
                                <?php
                                $shuAwal = ($totalPendapatanAwal * -1) - $totalBiayaAwal - $totalBiayaNonOperasionalAwal - $totalPajakPenghasilanAwal;
                                if ($shuAwal < 0) {
                                    echo "<th> ( ". number_format($shuAwal, 2, ',', '.') ." ) </th>";
                                }
                                else{
                                    echo "<th>". number_format($shuAwal, 2, ',', '.') ."</th>";
                                }

                                echo "<th> ( ". number_format(($shuSebelumPajak - $totalPajakPenghasilan) , 2, ',', '.') ." ) </th>";
                                ?>
                                <th></th>
                                <?php
                                $shu = ($totalPendapatan * -1) - $totalBiaya - $totalBiayaNonOperasional - $totalPajakPenghasilan;
                                if ($shu < 0) {
                                    echo "<th>". number_format($shu, 2, ',', '.') ."</th>";
                                }
                                else{
                                    echo "<th>". number_format($shu, 2, ',', '.') ."</th>";
                                }
                                ?>
                            </tr>
                            </tbody>
                            <!-- <tfoot class="bg-warning text-white">
                                <th colspan="2"></th>
                                <th><?php echo number_format($ttlSaldoAwalDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAwalKredit * -1, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlMutasiDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlMutasiKredit, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAkhirDebet, 2, ',', '.') ?></th>
                                <th><?php echo number_format($ttlSaldoAkhirKredit * -1, 2, ',', '.') ?></th>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>


            <?php
            }
            ?>

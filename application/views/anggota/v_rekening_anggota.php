<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Data Master</a></li>
            <li class="breadcrumb-item"><a href="#">Anggota</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekening (<?php echo $id." - ";foreach($anggota as $i){echo $i->nama;} ?>)</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <?php
                        foreach ($simpanan_pokok as $s) {
                        ?>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Simpanan Pokok</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp. ".number_format($s->jumlah,0,',','.'); ?></div>
                            <div class="text-xs font-weight-bold text-gray-600 mt-1">Tanggal Pembayaran : <?php echo $s->tanggal_pembayaran; ?></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <?php
                        foreach ($simpanan_wajib as $w) {
                        ?>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Simpanan Wajib</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp. ".number_format($w->saldo,0,',','.'); ?></div>
                            <div class="text-xs font-weight-bold text-gray-600 mt-1">Pembayaran Terakhir : <?php echo date('m-Y',strtotime($w->tgl_temp)); ?></div>
                        </div>
                        <div class="col-auto">
                            <!-- <i class="fas fa-calendar fa-2x text-gray-300"></i> -->
                            <button class="btn btn-sm btn-primary"><i class="icofont-eye"></i> Detail</button>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Simuda -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Simuda</h6>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">No.Rekening</th>
                            <th class="text-center">Saldo Bulan Lalu</th>
                            <th class="text-center">Saldo Bulan Ini</th>
                            <th class="text-center">Saldo Terendah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($simuda as $p) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><?php echo $p->no_rekening_simuda; ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_bulan_lalu,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_bulan_ini,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_terendah,0,',','.'); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url().'index.php/simuda/detailRekening/'.$p->no_rekening_simuda; ?>" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                                <!-- <td style="text-align:center;">
                                    <button type="button" class="btn btn-sm btn-success" onclick="edit(<?php echo $p->no_anggota; ?>)"><i class="icofont-ui-edit"></i></button>
                                    <?php if($p->status==1){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Menonaktifkan Anggota?')" href="<?php echo base_url() . 'index.php/user/disableAccount/' . $p->no_anggota; ?>" class="btn btn-sm btn-danger" ><i class="icofont-ui-power"></i></a>
                                    <?php }else if($p->status==0){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Mengaktifkan Anggota?')" href="<?php echo base_url() . 'index.php/user/enableAccount/' . $p->no_anggota; ?>" class="btn btn-sm btn-primary" ><i class="icofont-ui-power"></i></a>
                                    <?php } ?>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Sijaka -->
    <!-- Kredit -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kredit / Pembiayaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">No.Rek Kredit</th>
                            <th class="text-center">Jumlah Pembiayaan</th>
                            <th class="text-center">Berjalan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($kredit as $i){ 
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++."."; ?></td>
                            <td><?php echo $i->no_rekening_pembiayaan; ?></td>
                            <td class="text-right"><?php echo number_format($i->jumlah_pembiayaan,0,',','.'); ?></td>
                            <td class="text-center"><?php echo "0/".$i->jangka_waktu_bulan; ?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'index.php/kredit/detail/'.$i->no_rekening_pembiayaan; ?>" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

</div>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Nominatif</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Nominatif</h6>
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
                            <th class="text-center">No&nbsp;Rekening</th>
                            <th class="text-center">No.&nbsp;Anggota</th>
                            <th class="text-center">Tgl.&nbsp;Pembayaran</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Bahas&nbsp;Bulanan</th>
                            <th class="text-center">Pembayaran</th>
                            <th class="text-center">Rek.&nbsp;Simuda</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($nominatif as $p) {
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $p->NRSj; ?></td>
                            <td><?php echo $p->no_anggota.' - '.$p->nama;?></td>
                            <td><?php echo $p->tanggal_pembayaran; ?></td>
                            <td class="text-right"><?php echo number_format($p->jumlah_simpanan,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($p->jumlah_bahas_bulanan,0,',','.'); ?></td>
                            <td><?php echo $p->pembayaran_bahas; ?></td>
                            <td><?php echo $p->rekening_simuda; ?></td>
                            <td><?php echo $p->progress_bahas.'/'.$p->jangka_waktu; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url().'index.php/sijaka/detailRekeningSijaka/'.$p->NRSj; ?>" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
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
            <!-- <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-plus-circle"></i> Tambah</button> -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Rekening</th>
                            <th>No. Anggota</th>
                            <!-- <th>Nama</th> -->
                            <th>Jumlah</th>
                            <!-- <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th> -->
                            <th>Jumlah Bayar Bahas</th>
                            <!-- <th>Pembayaran</th> -->
                            <th>Rekening Simuda</th>
                            <!-- <th>Perpanjangan Otomatis</th> -->
                            <th>Aksi</th>
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
                            <td class="text-right"><?php echo $p->jumlah_awal; ?></td>
                            <!-- <td><?php echo $p->tanggal_awal; ?></td>
                            <td><?php echo $p->tanggal_akhir; ?></td> -->
                            <td class="text-right"><?php echo $p->presentase_bagi_hasil_bulanan; ?></td>
                            <!-- <td><?php echo $p->pembayaran_bahas; ?></td> -->
                            <td><?php echo $p->rekening_simuda; ?></td>
                            <!-- <td><?php echo $p->otomatis_perpanjang; ?></td> -->
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
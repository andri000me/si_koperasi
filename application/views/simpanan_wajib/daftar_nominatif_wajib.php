<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Data Simpanan Wajib</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nominatif</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Nominatif Simpanan Wajib</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">No. Anggota</th>
                            <th class="text-center">Nama Anggota</th>
                            <th class="text-center">Saldo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($nominatif as $w) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++."."; ?></td>
                            <td><?php echo $w->no_anggota; ?></td>
                            <td><?php echo $w->nama; ?></td>
                            <td class="text-right"><?php echo number_format($w->saldo,0,',','.'); ?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'index.php/simpanan_wajib/detail/'.$w->no_anggota ?>" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
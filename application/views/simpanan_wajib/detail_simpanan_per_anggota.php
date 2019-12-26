<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Simpanan Wajib</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Simpanan Per Anggota</li>
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
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Saldo</th>
                            <th class="text-center">Teller</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($simpanan_per_anggota as $i) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++."."; ?></td>
                                <td ><?php echo $i->tgl_pembayaran; ?></td>
                                <td class="text-right"><?php echo number_format($i->debet,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($i->kredit,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($i->saldo,0,',','.'); ?></td>
                                <td><?php echo $i->nama_terang; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="modal" id="modaledit">
</div>
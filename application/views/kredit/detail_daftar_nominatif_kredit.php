<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Kredit / Pembiayaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Daftar Nominatif (<?php echo $id; ?>)</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Daftar Nominatif (<?php echo $id; ?>)</h6>
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
                            <th class="text-center">Tgl. Bayar</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Pokok</th>
                            <th class="text-center">Bahas</th>
                            <th class="text-center">Denda</th>
                            <th class="text-center">Total</th>
                            <th>Op.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($detail_kredit as $data){
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data->tanggal_pembayaran; ?></td>
                            <td><?php echo $data->periode_tagihan ?></td>
                            <td class="text-right"><?php echo number_format($data->jml_pokok,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($data->jml_bahas,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($data->denda,0,',','.'); ?></td>
                            <td class="text-right"><?php echo number_format($data->total,0,',','.'); ?></td>
                            <td><?php echo $data->nama_terang; ?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
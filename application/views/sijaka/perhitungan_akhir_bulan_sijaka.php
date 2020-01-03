<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
            <li class="breadcrumb-item active" aria-current="page">Perhitungan Akhir Bulan Sijaka</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Perhitungan Akhir Bulan Sijaka</h6>
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
            <form onsubmit="return confirm('Apakah anda yakin ingin memproses?')" name="perhitungan_akhir_bulan_sijaka" method="POST" action="<?php echo base_url().'index.php/sijaka/updatePerhitunganAkhirBulanSijaka'; ?>">
            <div class="form-group row">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-success mr-1" value="proses">Proses</button>
                </div>
            </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Rekening</th>
                            <th>No. Anggota</th>
                            <th>Jangka Waktu</th>
                            <th>Bulan Berjalan</th>
                            <th>Tanggal Akhir</th>
                            <th>Total Bahas</th>
                            <th>Grandtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($akhir_bulan as $a) {
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $a->NRSj; ?></td>
                            <td><?php echo $a->no_anggota.' - '.$a->nama;?></td>
                            <td><?php echo $a->jangka_waktu; ?></td>
                            <td><?php echo $a->bulan_berjalan; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($a->tanggal_akhir)); ?></td>
                            <td><?php echo number_format( $a->total_bahas, 0, ',', '.'); ?></td>
                            <td><?php echo number_format( $a->grandtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
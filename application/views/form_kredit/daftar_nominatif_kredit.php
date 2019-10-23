<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Kredit atau Pembiayaan</a></li>
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jumlah Pembiayaan</th>
                            <th>Pokok</th>
                            <th>Bahas</th>
                            <th>Jangka Waktu</th>
                            <th>Tgl. Lunas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- php echo foreach -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-sm btn-info" onclick="">Detail</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
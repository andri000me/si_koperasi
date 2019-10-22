<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Kredit / Pembiayaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Daftar Nominatif</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Daftar Nominatif</h6>
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
            <div class="row">
                <div class="col-2 ml-auto">
                    <a href="index" class="btn btn-primary" style="margin-left:30px;">Kembali</a>
                </div>
            </div><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No.Rek</th>
                            <th>Atas Nama</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Periode Tagihan</th>
                            <th>Jumlah Pokok</th>
                            <th>Jumlah Bahas</th>
                            <th>Denda</th>
                            <th>Total</th>
                            <th>User</th>
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
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Memorial</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Memorial</h6>
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
            <a href="<?php echo base_url().'index.php/transaksi/memorial/input' ?>">
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-plus-circle"></i> Tambah</button>
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Total</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        foreach ($memorial as $key) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $key->kode_trx_memorial; ?></td>
                                <td><?php echo $key->tanggal; ?></td>
                                <td><?php echo $key->tipe == "D" ? 'Debet' : 'Kredit' ; ?></td>
                                <td><?php echo number_format($key->grand_total, 2, ',', '.'); ?></td>
                                <td style="text-align:center;">
                                    <a href="<?php echo base_url()."index.php/transaksi/memorial/createEditSession/$key->kode_trx_memorial" ?>" style="text-decoration:none">
                                        <button class="btn btn-success btn-sm"><i class="icofont-ui-edit"></i></button>
                                    </a>
                                    <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/memorial/deleteMemorial/$key->kode_trx_memorial" ?>" class="open-confirm">
                                      <button class="btn btn-danger btn-sm"><i class="icofont-ui-delete"></i></button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        } 
                        $this->load->view("confirm");
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->

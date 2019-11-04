<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Monitoring</a></li>
    <li class="breadcrumb-item active" aria-current="page">Otorisasi </li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Otorisasi</h6>
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
                            <th>No.</th>
                            <th>No. Rekening</th>
                            <th>Debet</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($otorisasi as $i) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $i->no_rek; ?></td>
                                <td class="text-right"><?php echo number_format($i->nominal_debet,0,',','.'); ?></td>
                                <td class="text-center">
                                <?php 
                                    if($i->status == 'Open'){
                                        echo "<span class='badge badge-info'>Open</span>";
                                    }else if($i->status == 'Accepted'){
                                        echo "<span class='badge badge-primary'>Accepted</span>";
                                    }else if($i->status == 'Declined'){
                                        echo "<span class='badge badge-danger'>Declined</span>";
                                    }
                                ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
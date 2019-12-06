<script>
    function edit(id){
        $.ajax({
            url: "<?php echo base_url() . 'index.php/otorisasi/modalubahstatus'; ?>",
            type: "POST",
            data: {
                id: id
            },
            success: function(ajaxData) {
                $("#modaledit").html(ajaxData);
                $("#modaledit").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    }
</script>
<!-- BreadCumb -->

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
                            <th class="text-center">No.</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">No. Rekening</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($otorisasi as $i) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++."."; ?></td>
                                <td><?php echo $i->tanggal_input; ?></td>
                                <td><?php echo $i->tipe; ?></td>
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
                                <td style="text-align:center;">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?php echo $i->id_otorisasi; ?>')" <?php if($i->status <> 'Open'){echo "disabled";} ?>>Otorisasi</i></button>
                                </td>
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
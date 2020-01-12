<script>
    function preview(){
        $.ajax({
                url: "<?php echo base_url() . 'index.php/sijaka/previewHitungKewajibanBulanan'; ?>",
                type: "POST",
                success: function(ajaxData) {
                    $(".ajax-data").html(ajaxData);
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
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Penarikan Dana Pokok</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Penarikan Dana Pokok</h6>
        </div>
        <div class="card-body">
            <?php
            echo $this->session->flashdata("input_success");
            echo $this->session->flashdata("input_failed");
            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">NRSj</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Jumlah Simpanan</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($sijaka_selesai as $i){
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $i->NRSj; ?></td>
                            <td><?php echo $i->no_anggota.'-'.$i->nama; ?></td>
                            <td class="text-right"><?php echo number_format($i->jumlah_simpanan,0,',','.'); ?></td>
                            <td class="text-center"><?php echo $i->progress_bahas.'/'.$i->jangka_waktu; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url().'index.php/sijaka/prosesPenarikanPokokSijaka/'.$i->NRSj; ?>" class="btn btn-sm btn-success" onclick="return confirm('Anda Yakin Akan Melakukan Pencairan Dana Pokok?')">
                                    <i class="icofont-money"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
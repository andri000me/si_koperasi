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
    <li class="breadcrumb-item"><a href="#">Sijaka</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pembayaran Bahas</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran Bahas</h6>
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
                            <th class="text-center">NRSJ</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jumlah Pembayaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($dataPembayaranBahas as $i) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++."."; ?></td>
                                <td><?php echo $i->NRSj; ?></td>
                                <td><?php echo $i->no_anggota.' - '.$i->nama; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($i->tanggal_pembayaran)); ?></td>
                                <td class="text-right"><?php echo number_format($i->jumlah_pembayaran,0,',','.'); ?></td>
                                <td style="text-align:center;">
                                    <!-- <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?php echo $i->id_otorisasi; ?>')" <?php if($i->status <> 'Open'){echo "disabled";} ?>>Otorisasi</i></button> -->
                                    <a href="<?php echo base_url().'index.php/sijaka/kreditRekeningSimuda/'.$i->id_support_bagi_hasil; ?>" class="btn btn-sm btn-primary" onclick="return confirm('Anda Yakin Memindahkan Uang Ke Rekening Simuda?')">Kredit Rek. Simuda</a>
                                    <a href="<?php echo base_url().'index.php/sijaka/ambilBahasTunai/'.$i->id_support_bagi_hasil; ?>" class="btn btn-sm btn-success" onclick="return confirm('Anda Yakin Mencairkan Bahas Sijaka?')">Tunai</a>
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
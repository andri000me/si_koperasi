<!-- <script>
    function edit(id) {
        $.ajax({
            url: "<?php echo base_url() . 'index.php/anggota/edit'; ?>",
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
</script> -->
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Simuda</a></li>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No.Rekening</th>
                            <th>No. Anggota</th>
                            <th>Nama</th>
                            <th>Saldo Bulan Lalu</th>
                            <th>Saldo Bulan Ini</th>
                            <th>Saldo Terendah</th>
                            <th>Aksi</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($nominatif as $p) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $p->no_rekening_simuda; ?></td>
                                <td><?php echo $p->no_anggota; ?></td>
                                <td><?php echo $p->nama; ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_bulan_lalu,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_bulan_ini,0,',','.'); ?></td>
                                <td class="text-right"><?php echo number_format($p->saldo_terendah,0,',','.'); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url().'index.php/simuda/detailRekening/'.$p->no_rekening_simuda; ?>" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                                <!-- <td style="text-align:center;">
                                    <button type="button" class="btn btn-sm btn-success" onclick="edit(<?php echo $p->no_anggota; ?>)"><i class="icofont-ui-edit"></i></button>
                                    <?php if($p->status==1){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Menonaktifkan Anggota?')" href="<?php echo base_url() . 'index.php/user/disableAccount/' . $p->no_anggota; ?>" class="btn btn-sm btn-danger" ><i class="icofont-ui-power"></i></a>
                                    <?php }else if($p->status==0){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Mengaktifkan Anggota?')" href="<?php echo base_url() . 'index.php/user/enableAccount/' . $p->no_anggota; ?>" class="btn btn-sm btn-primary" ><i class="icofont-ui-power"></i></a>
                                    <?php } ?>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/anggota/add">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">No. Anggota</label>
                                <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Terang</label>
                                <input type="text" name="nama_terang" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Status</label>
                                <select name="status" id="" class="form-control form-control-sm" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modaledit">
</div>
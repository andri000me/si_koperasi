<script>
    function edit(id) {
        $.ajax({
            url: "<?php echo base_url() . 'index.php/user/edit'; ?>",
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
    function editPassword(id) {
        $.ajax({
            url: "<?php echo base_url() . 'index.php/user/editpassword'; ?>",
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
    <li class="breadcrumb-item"><a href="#">Data Master</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data User</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User</h6>
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
            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-plus-circle"></i> Tambah</button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Terang</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Hak Akses</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($user as $p) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $p->nama_terang; ?></td>
                                <td><?php echo $p->username; ?></td>
                                <td><?php echo $p->level; ?></td>
                                <td><?php if($p->status=="0"){echo "Non Aktif";}else if($p->status=="1"){echo "Aktif";} ?></td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn btn-sm btn-success" onclick="edit(<?php echo $p->id_user; ?>)"><i class="icofont-ui-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editPassword(<?php echo $p->id_user; ?>)"><i class="icofont-ui-password"></i></button>
                                    <?php if($p->status==1){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Menonaktifkan Akun?')" href="<?php echo base_url() . 'index.php/user/disableAccount/' . $p->id_user; ?>" class="btn btn-sm btn-danger" ><i class="icofont-ui-power"></i></a>
                                    <?php }else if($p->status==0){ ?>
                                    <a onclick="return confirm('Anda Yakin Ingin Mengaktifkan Akun?')" href="<?php echo base_url() . 'index.php/user/enableAccount/' . $p->id_user; ?>" class="btn btn-sm btn-primary" ><i class="icofont-ui-power"></i></a>
                                    <?php } ?>
                                </td>
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
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/user/add">
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
                                <label for="" class="pull-left">Nama Terang</label>
                                <input type="text" name="nama_terang" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm" placeholder="Masukkan Username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Password</label>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Masukkan Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Re-Password</label>
                                <input type="password" name="repassword" class="form-control form-control-sm" placeholder="Ulangi Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Hak Akses</label>
                                <select name="hak_akses" id="" class="form-control form-control-sm" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Dana">Dana</option>
                                    <option value="Teller">Teller</option>
                                </select>
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
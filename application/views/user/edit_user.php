<div class="modal-dialog">
        <div class="modal-content">
            <form name="edit-user" method="POST" action="<?php echo base_url(); ?>index.php/user/update">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <?php foreach($user as $u){ ?>
                        <input type="hidden" name="id_user" value="<?php echo $u->id_user; ?>">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Terang</label>
                                <input type="text" name="nama_terang" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $u->nama_terang; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm" placeholder="Masukkan Username" value="<?php echo $u->username; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Hak Akses</label>
                                <select name="hak_akses" id="" class="form-control form-control-sm" required>
                                    <option value="Manajemen" <?php if($u->level == "Manajemen"){echo "Selected";} ?>>Manajemen</option>
                                    <option value="Kasir" <?php if($u->level == "Kasir"){echo "Selected";} ?>>Kasir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Hak Akses</label>
                                <select name="hak_akses" id="" class="form-control form-control-sm" required>
                                    <option value="Manajemen" <?php if($u->level == "Manajemen"){echo "Selected";} ?>>Manajemen</option>
                                    <option value="Kasir" <?php if($u->level == "Kasir"){echo "Selected";} ?>>Kasir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Status</label>
                                <select name="hak_akses" id="" class="form-control form-control-sm" required>
                                    <option value="1" <?php if($u->level == "1"){echo "Selected";} ?>>Aktif</option>
                                    <option value="0" <?php if($u->level == "0"){echo "Selected";} ?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
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
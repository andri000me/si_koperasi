<div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form name="edit-password-user" method="POST" action="<?php echo base_url(); ?>index.php/user/updatepassword">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Password User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <div class="col-md-12">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Password</label>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Masukkan Password Baru">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Re-Password</label>
                                <input type="password" name="repassword" class="form-control form-control-sm" placeholder="Ulangi Password Baru">
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
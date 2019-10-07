<div class="container-fluid">
    <?php
        echo $this->session->flashdata("input_success");
        echo $this->session->flashdata("input_failed");
        echo $this->session->flashdata("update_success");
        echo $this->session->flashdata("update_failed");
        echo $this->session->flashdata("delete_success");
        echo $this->session->flashdata("delete_failed");
    ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
        </div>
        <div class="card-body">
            <form name="update_password_by_self" method="POST" action="<?php echo base_url() . 'index.php/user/updatePasswordBySelf' ?>">
                <input type="hidden" name="id_user" value="<?php echo $this->session->userdata('_id'); ?>">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">Password Lama</label>
                            <input type="password" name="oldpassword" class="form-control" placeholder="Masukkan Password Lama">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">Re-Password</label>
                            <input type="password" name="repassword" class="form-control" placeholder="Ulangi Password Baru">
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:10px;">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <button type="reset" class="btn btn-warning btn-sm">Reset</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>
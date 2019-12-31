<div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>index.php/anggota/update">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php foreach($anggota as $i){ ?>
                    <div class="row">
                        <input type="hidden" name="temp_no_anggota" value="<?php echo $i->no_anggota ?>">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">No. Anggota</label>
                                <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan No. Anggota" value="<?php echo $i->no_anggota; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Terang</label>
                                <input type="text" name="nama_terang" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $i->nama; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"><?php echo $i->alamat; ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
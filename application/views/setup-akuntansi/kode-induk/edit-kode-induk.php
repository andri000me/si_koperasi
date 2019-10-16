<div class="modal-dialog">
        <div class="modal-content">
            <form name="edit-kode-induk" method="POST" action="<?php echo base_url(); ?>index.php/setup-akuntansi/kodeinduk/update">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kode Induk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <?php foreach($kodeInduk as $key){ ?>
                        <input type="hidden" name="kode" value="<?= $key->kode_induk ?>">
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Kode Induk</label>
                                <input type="text" name="new_kode_induk" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $key->kode_induk; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Kode Induk</label>
                                <input type="text" name="nama" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $key->nama; ?>"required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Tipe</label>
                                <select name="tipe" id="" class="form-control form-control-sm" required>
                                    <option value="">--Pilih Tipe--</option>
                                    <option value="D" <?= $key->tipe == 'D' ? 'selected' : '' ?>>Debet</option>
                                    <option value="K" <?= $key->tipe == 'K' ? 'selected' : '' ?>>Kredit</option>
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
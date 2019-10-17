<div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="<?php echo base_url(); ?>index.php/simpanan_wajib/update">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Simpanan Wajib</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php foreach ($simpanan_wajib as $p) { ?>
                    <div class="row">
                        <input type="hidden" name="temp_id_simpanan_wajib" value="<?php echo $p->id_simpanan_wajib ?>">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">No. Anggota</label>
                                <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan Nomor Anggota" value="<?php echo $p->no_anggota; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Tanggal Bayar</label>
                                <input type="date" name="tgl_pembayaran" class="form-control form-control-sm" value="<?php echo $p->tgl_pembayaran; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" value="<?= $p->jumlah ?>" class="form-control form-control-sm">
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
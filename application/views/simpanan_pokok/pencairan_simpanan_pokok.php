<div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="<?php echo base_url(); ?>index.php/simpanan_pokok/prosesPencairanDana">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Pencairan Dana Simpanan Pokok</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="id_simpanan_pokok" id="id_simpanan_pokok" value="<?php echo $id; ?>">
                <?php
                foreach($simpanan_pokok as $i){
                ?>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="">Jumlah Dana</label>
                        <input type="text" class="form-control form-control-sm" name="jumlah" value="<?php echo $i->jumlah; ?>" readonly/>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-sm" value="Proses" />
            </div>
        </form>
    </div>
</div>
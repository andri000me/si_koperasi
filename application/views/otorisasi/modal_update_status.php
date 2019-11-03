<div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>index.php/otorisasi/updateStatus">
                <input type="hidden" name="id_otorisasi" value="<?php echo $id; ?>">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <select class="form-control" name="status" id="status">
                        <option value="Open">Open</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Declined">Declined</option>
                    </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
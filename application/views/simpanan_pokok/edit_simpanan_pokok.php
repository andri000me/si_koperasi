<div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Simpanan Pokok</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="temp_no_anggota" value="">
                    <div class="col-md-6">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">No. Anggota</label>
                            <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan Nomor Anggota" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">Tanggal Bayar</label>
                            <input type="date" name="input_tanggal" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-inner">
                            <label for="" class="pull-left">Jumlah</label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan Jumlah"></textarea>
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
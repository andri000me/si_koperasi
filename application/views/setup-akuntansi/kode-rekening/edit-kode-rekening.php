<div class="modal-dialog">
        <div class="modal-content">
            <form name="edit-kode-rekening" method="POST" action="<?php echo base_url(); ?>index.php/setup-akuntansi/koderekening/update">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kode Rekening</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <?php foreach($kodeRekening as $key){
                      $kode_rek = explode('.', $key->kode_rekening);
                      $kode_rek = $kode_rek[2];
                    ?>
                        <input type="hidden" name="kode" value="<?= $key->kode_rekening ?>">
                        <div class="col-md-6 mb-3">
                          <div class="form-group-inner">
                              <label for="" class="pull-left">Kode Induk</label>
                              <select name="kode_induk" id="" class="form-control form-control-sm" required style="width: 100%">
                                  <option value="">--Pilih Kode Induk--</option>
                                  <?php
                                  foreach ($kodeInduk as $keyInduk) {
                                  ?>
                                      <option value="<?= $keyInduk->kode_induk ?>" <?= $keyInduk->kode_induk == $key->kode_induk ? 'selected' : '' ?> > <?= $keyInduk->kode_induk . '&nbsp; -- &nbsp;' . $keyInduk->nama ?> </option>
                                  <?php
                                  }
                                  ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Kode Rekening</label>
                                <input type="text" name="new_kode_rekening" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $kode_rek ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Kode Rekening</label>
                                <input type="text" name="nama" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $key->nama; ?>"required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Saldo Awal</label>
                                <input type="number" step=".01" name="saldo_awal" class="form-control form-control-sm" placeholder="Masukkan Nama" value="<?php echo $key->saldo_awal; ?>">
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
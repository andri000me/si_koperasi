<div class="modal-dialog">
        <div class="modal-content">
            <form name="edit-kode-rekening" method="POST" action="<?php echo base_url(); ?>index.php/setup-akuntansi/settingrekening/update">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Setting Rekening</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <?php foreach($setting as $key){
                      // $kode_rek = explode('.', $key->kode_rekening);
                      // $kode_rek = $kode_rek[1];
                    ?>
                        <input type="hidden" name="id" value="<?= $key->id ?>">
                        <div class="col-md-6 mb-3">
                          <div class="form-group-inner">
                              <label for="" class="pull-left">Jenis Transaksi</label>
                              <select name="jenis_trx" id="" class="form-control form-control-sm select2_" required>
                                  <option value="">--Pilih Jenis Transaksi--</option>
                                  <option value="simuda" <?= $key->jenis_trx == 'simuda' ? 'selected' : '' ?> >Simuda</option>
                                  <option value="sijaka" <?= $key->jenis_trx == 'sijaka' ? 'selected' : '' ?>>Sijaka</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group-inner">
                              <label for="" class="pull-left">Rekening Debet</label>
                              <select name="rek_debet" id="" class="form-control form-control-sm select2_" required>
                                  <option value="">-- Pilih Rekening --</option>
                                  <?php
                                  foreach ($kodeRekening as $keyRek) {
                                    // echo $keyRek->kode_rekening;
                                    // echo "<option value='$keyRek->kode_rekening' $key->rek_debet == $keyRek->kode_rekening ? 'selected' : '' > $keyRek->kode_rekening --  $keyRek->nama </option>";
                                  ?>
                                  <option value="<?= $keyRek->kode_rekening ?> " <?= $keyRek->kode_rekening == $key->rek_debet ? 'selected' : '' ?> ><?= $keyRek->kode_rekening . ' -- ' . $keyRek->nama ?></option>
                                  <?php
                                  }
                                  ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group-inner">
                              <label for="" class="pull-left">Rekening Kredit</label>
                              <select name="rek_kredit" id="" class="form-control form-control-sm select2_" required>
                                  <option value="">-- Pilih Rekening --</option>
                                  <?php
                                  foreach ($kodeRekening as $keyRek2) {
                                    // echo "<option value='$keyRek2->kode_rekening' $key->rek_kredit == $keyRek2->kode_rekening ? selected : '' > $keyRek2->kode_rekening --  $keyRek2->nama </option>";
                                  ?>
                                  <option value="<?= $keyRek2->kode_rekening ?> " <?= $keyRek2->kode_rekening == $key->rek_kredit ? 'selected' : '' ?> ><?= $keyRek2->kode_rekening . ' -- ' . $keyRek2->nama ?></option>
                                  <?php
                                  }
                                  ?>
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

    <script>
    $(document).ready(function(){
  $('.select2_').select2({
      theme: 'bootstrap4',
  });
});</script>
<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
    <li class="breadcrumb-item"><a href="#">Edit Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $edit_bukti_bank->kode_trx_bank ?></li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Bank</h6>
        </div>
        <div class="card-body">
            <?php
            echo $this->session->flashdata("input_success");
            echo $this->session->flashdata("input_failed");
            echo $this->session->flashdata("update_success");
            echo $this->session->flashdata("update_failed");
            echo $this->session->flashdata("delete_success");
            echo $this->session->flashdata("delete_failed");
            ?>
            <a href="<?php echo base_url().'index.php/transaksi/bank' ?>">
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-arrow-left"></i> Kembali</button>
            </a>
            
            <form action="" method="post">
                <input type="hidden" name="edit_bukti_bank" value="edit_bukti_bank">
                <h2>
                  <?php
                  // unset($_SESSION->bukti_bank']);
                  // unset($_SESSION->detail_bank']);
                  
                  // echo "<pre>";
                  // print_r ($_SESSION['detail_bank']);
                  // echo "</pre>";
                  
                  
                  // $date = "BK-<span id='ym'>".date("ym")."</span>-<span id='nomor2'>$nom</span>";
                  if(isset($edit_bukti_bank)){
                    echo $edit_bukti_bank->kode_trx_bank;
                  }
                  
                  
                  ?>
                  </h2>
                  <!--div class="col-lg-4">
                    <input type="text" name="kode_bukti_bank" id="kode_bukti_bank" class="form-control form-control-user kode-bank" value="<?php echo isset($_SESSION['bukti_bank']) ? $_SESSION['bukti_bank']['kode_bukti_bank'] : $date . $no ?>" readonly>
                  </div-->
                <hr>
                <div class="row">
                    <div class="col-6 mb-3">
                      <label for="">Tanggal</label>
                      <input type="date" name="tanggal" class="form-control" value="<?= isset($edit_bukti_bank->tanggal) ? $edit_bukti_bank->tanggal : '' ?>" >
                      <div class="invalid-feedback">
                        <?php echo form_error('tanggal') ?>
                      </div>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="">Kode Bank</label>
                      <select name="kode_perkiraan" id="" class="form-control select2_ <?php echo form_error('kode_perkiraan') ? 'is-invalid' : '' ?>  ">
                        <option value="">--Pilih Kode Perkiraan Bank--</option>
                        <?php
                        foreach ($rekening as $key) {
                        // echo "<option value='$key->kode_rekening' isset($_SESSION[bukti_bank][kode_perkiraan]) && $_SESSION[bukti_bank][kode_perkiraan] == $key->kode_rekening ? selected : ''  > $key->kode_rekening -- $key->nama </option>";
                        ?>
                        <option value="<?php echo $key->kode_rekening ?>" <?php echo isset($edit_bukti_bank->kode_perkiraan) && $edit_bukti_bank->kode_perkiraan == $key->kode_rekening ? 'selected' : '' ?> > <?php echo $key->kode_rekening . ' -- ' . $key->nama ?> </option>
                        <?php
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo form_error('kode_perkiraan') ?>
                      </div>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="">Tipe Transaksi</label>
                      <select name="tipe" id="" class="form-control <?php echo form_error('tipe') ? 'is-invalid' : '' ?>">
                        <option value="">--Pilih Tipe--</option>
                        <option value="D" <?php echo isset($edit_bukti_bank->tipe) && $edit_bukti_bank->tipe == 'D' ? 'selected' : '' ?> >Debet</option>
                        <option value="K" <?php echo isset($edit_bukti_bank->tipe) && $edit_bukti_bank->tipe == 'K' ? 'selected' : '' ?> >Kredit</option>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo form_error('tipe') ?>
                      </div>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="">Nomor</label>
                      <input type="number" name="nomor" id="nomor" class="form-control" value="<?php echo isset($edit_bukti_bank->nomor) ? $edit_bukti_bank->nomor : "" ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                      <button type="submit" class="btn btn-primary btn-sm"><i class="icofont-spinner-alt-3"></i> Proses</button>
                      <button type="reset" class="btn btn-secondary btn-sm"><i class="icofont-close-circled"></i> Batal</button>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_SESSION['edit_bukti_bank'])) {
            ?>
            <hr>
            <br>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Perkiraan</th>
                        <th>Lawan</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;

                    if (isset($detail_edit_bukti_bank)) {
                      $no = 0;
                      foreach ($detail_edit_bukti_bank as $key => $value) {

                        $total = $total + $value->nominal;
                        $no++; 
                        ?>
                        <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $edit_bukti_bank->kode_perkiraan ?></td>
                          <td><?php echo $value->lawan ?></td>
                          <td><?php echo $value->keterangan ?></td>
                          <td><?php echo number_format($value->nominal, 2, ',', '.') ?></td>
                          <td>
                            <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/bank/deleteSessionDetailEdit/".$edit_bukti_bank->kode_trx_bank."/".$key ?>" class="open-confirm">
                              <button class="btn btn-danger btn-sm"><i class="icofont-ui-delete"></i></button>
                            </a>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="row">
                  <div class="col-auto">
                    <button data-toggle="modal" data-target="#addBank" class="btn btn-sm btn-info">Tambah Detail</button>
                    <!-- <a href="" data-toggle="modal" data-target="#addBank" class="btn btn-sm btn-info">Tambah Detail</a> -->
                  </div>
                  <div class="col-3 ml-auto">
                    <h5><b>Total : <?php echo "Rp. " . number_format($total, 2, ',', '.') ?> </b></h5>
                  </div>
                </div>
                <hr>
                <!-- btn save & reset session trx bank -->
                <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/bank/update/".$edit_bukti_bank->kode_trx_bank ?>" class="btn btn-success btn-sm open-confirm"><i class="fas fa-save"></i> Simpan</a>
                <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/bank/resetSession/edit_bukti_bank|edit_detail_bank|createEditSession:".$edit_bukti_bank->kode_trx_bank ?>" class="btn btn-danger btn-sm open-confirm"><i class="fas fa-trash"></i> Reset Transaksi</a>
                <!-- end btn save & reset session -->
              </div>
              

              <!-- modal add detail -->
              <div class="modal" id="addBank">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Detail Bank</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" data-modal="#addBank" data-count="0">
                        <input type="hidden" name="add_detail_bukti_bank" value="add_detail_bukti_bank">
                        <input type="hidden" name="id_detail_trx_bank" value="0">
                        <div class="row">
                          <div class="col-12 mb-3">
                            <label for="">Lawan</label>
                            <select name="lawan" id="" class="form-control select2_" required style="width: 100%">
                              <option value="">--Pilih Lawan--</option>
                              <?php
                              foreach ($allRekening as $key) {
                                echo "<option value='$key->kode_rekening'> $key->kode_rekening -- $key->nama </option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="">Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-control">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" id="" rows="1" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                          <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                        </div>
                      </form>
                  </div>
                </div>
              </div>

            </div>
            <?php
              $this->load->view("confirm");
            }
            ?>
        </div>
    </div>
</div>
<!-- The Modal -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Input Memorial</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Memorial</h6>
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
            <a href="<?php echo base_url().'index.php/transaksi/memorial' ?>">
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-arrow-left"></i> Kembali</button>
            </a>
            
            <form action="<?php echo base_url().'index.php/transaksi/memorial/input' ?>" method="post">
                <h2>
                  <?php
                  // unset($_SESSION['bukti_memorial']);
                  // unset($_SESSION['detail_memorial']);
                  
                  // echo "<pre>";
                  // print_r ($_SESSION['detail_memorial']);
                  // echo "</pre>";
                  
                  if(isset($_SESSION['bukti_memorial'])){
                    $b = $_SESSION['bukti_memorial'];
                    $tgl = explode("-",$b['tanggal']);
                    $y = substr($tgl[0],2,2);
                    $m = $tgl[1];
                    $ym = $y.$m;
                    $nom = $b['nomor'];
                  }
                  else{
                    // $mk = "";
                    $ym = "";
                    $nom = "";
                  }
                  $date = "BM-<span id='ym'>$ym</span>-<span id='nomor2'>$nom</span>";
                  $no = 0;
                  if ($nomor[0]['nomor'] == "") {
                      $no = 1;
                  } else {
                      $no = $nomor[0]['nomor'];
                  }
                  
                  $zero = '0000';
                  $noString = "" .  $no;
                  $no = substr($zero, 0, strlen($zero)- strlen($noString)) . $noString;
                  echo $date;
                  
                  ?>
                  </h2>
                  <!--div class="col-lg-4">
                    <input type="text" name="kode_bukti_memorial" id="kode_bukti_memorial" class="form-control form-control-user kode-memorial" value="<?php echo isset($_SESSION['bukti_memorial']) ? $_SESSION['bukti_memorial']['kode_bukti_memorial'] : $date . $no ?>" readonly>
                  </div-->
                <hr>
                <div class="row">
                    <div class="col-6 mb-3">
                      <label for="">Tanggal</label>
                      <input type="date" class="form-control getKode <?php echo form_error('tanggal') ? 'is-invalid' : '' ?>" name="tanggal" id="tanggal" data-val='["#tanggal"]' data-url="<?php echo base_url()."index.php/transaksi/memorial/getNomor" ?>" value="<?php echo isset($_SESSION['bukti_memorial']['tanggal']) ? $_SESSION['bukti_memorial']['tanggal'] : '' ?>">
                      <div class="invalid-feedback">
                        <?php echo form_error('tanggal') ?>
                      </div>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="">Tipe Transaksi</label>
                      <select name="tipe" id="" class="form-control <?php echo form_error('tipe') ? 'is-invalid' : '' ?>">
                        <option value="">--Pilih Tipe--</option>
                        <option value="D" <?php echo isset($_SESSION['bukti_memorial']['tipe']) && $_SESSION['bukti_memorial']['tipe'] == 'D' ? 'selected' : '' ?> >Debet</option>
                        <option value="K" <?php echo isset($_SESSION['bukti_memorial']['tipe']) && $_SESSION['bukti_memorial']['tipe'] == 'K' ? 'selected' : '' ?> >Kredit</option>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo form_error('tipe') ?>
                      </div>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="">Nomor</label>
                      <input type="number" name="nomor" id="nomor" class="form-control" value="<?php echo isset($_SESSION['bukti_memorial']['nomor']) ? $_SESSION['bukti_memorial']['nomor'] : "" ?>" readonly>
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
            if (isset($_SESSION['bukti_memorial'])) {
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
                    if (isset($_SESSION['detail_memorial'])) {
                      $no = 0;
                      foreach ($_SESSION['detail_memorial'] as $key => $value) {

                        $total = $total + $value['nominal'];
                        $no++; 
                        ?>
                        <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $value['kode_perkiraan'] ?></td>
                          <td><?php echo $value['lawan'] ?></td>
                          <td><?php echo $value['keterangan'] ?></td>
                          <td><?php echo number_format($value['nominal'], 2, ',', '.') ?></td>
                          <td></td>
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
                    <button data-toggle="modal" data-target="#addKas" class="btn btn-sm btn-info">Tambah Detail</button>
                    <!-- <a href="" data-toggle="modal" data-target="#addKas" class="btn btn-sm btn-info">Tambah Detail</a> -->
                  </div>
                  <div class="col-3 ml-auto">
                    <h5><b>Total : <?php echo "Rp. " . number_format($total, 2, ',', '.') ?> </b></h5>
                  </div>
                </div>
                <hr>
                <!-- btn save & reset session trx memorial -->
                <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/memorial/save" ?>" class="btn btn-success btn-sm open-confirm"><i class="fas fa-save"></i> Simpan</a>
                <a data-msg="Apakah Anda Yakin?" href="<?php echo base_url()."index.php/transaksi/memorial/resetSession/bukti_memorial|detail_memorial|input" ?>" class="btn btn-danger btn-sm open-confirm"><i class="fas fa-trash"></i> Reset Transaksi</a>
                <!-- end btn save & reset session -->
              </div>
              

              <!-- modal add detail -->
              <div class="modal" id="addKas">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Detail Memorial</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" data-modal="#addKas" data-count="0">
                        <input type="hidden" name="add_detail" id="voucher" value="add">
                        <input type="hidden" name="id_sess" id="id_sess" value="">
                        <div class="row">
                          <div class="col-6 mb-3">
                            <label for="">Kode Perkiraan</label>
                            <select name="kode_perkiraan" id="" class="form-control" required>
                              <option value="">--Pilih Kode Perkiraan--</option>
                              <?php
                              foreach ($allRekening as $key) {
                                echo "<option value='$key->kode_rekening'> $key->kode_rekening -- $key->nama </option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="">Lawan</label>
                            <select name="lawan" id="" class="form-control" required>
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

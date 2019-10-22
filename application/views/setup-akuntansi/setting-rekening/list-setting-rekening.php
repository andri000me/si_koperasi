<script>
    // $('#btnEdit').on('click', function () {
    //     edit(kode);
    // });
    function edit(kode) {
        // let kode_rek = kode.toString();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/setup-akuntansi/settingrekening/edit/'; ?>"+kode,
            type: "POST",
            // data: {
            //     kode: kode
            // },
            success: function(ajaxData) {
                $("#modaledit").html(ajaxData);
                console.log(ajaxData);
                $("#modaledit").modal('show', {
                    backdrop: 'true'
                });
            }
        });
        console.log(kode);
    }
    // function editPassword(id) {
    //     $.ajax({
    //         url: "<?php echo base_url() . 'index.php/user/editpassword'; ?>",
    //         type: "POST",
    //         data: {
    //             id: id
    //         },
    //         success: function(ajaxData) {
    //             $("#modaledit").html(ajaxData);
    //             $("#modaledit").modal('show', {
    //                 backdrop: 'true'
    //             });
    //         }
    //     });
    // }
</script>
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Setup Akuntansi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Setting Rekening</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Setting Rekening</h6>
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
            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-plus-circle"></i> Tambah</button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis Transaksi</th>
                            <th>Rekening Debet</th>
                            <th>Rekening Kredit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($setting as $key) {
                            // $kode = str_replace('.',',', $key->kode_rekening);
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo ucfirst($key->jenis_trx); ?></td>
                                <td><?php echo $key->rek_debet; ?></td>
                                <td><?php echo $key->rek_kredit; ?></td>
                                <td style="text-align:center;">
                                    <!-- <button type="button" class="btn btn-sm btn-success" onclick="edit(<?php echo $key->id; ?>)"><i class="icofont-ui-edit"></i></button> -->
                                    <button type="button" id="btnEdit" class="btn btn-sm btn-success" onclick="edit('<?="$key->id"?>')"><i class="icofont-ui-edit"></i></button>
                                    <a onclick="confirm('Apakah anda yakin?')" href="<?= base_url('index.php/setup-akuntansi/settingrekening/delete/'.$key->id) ?>">
                                      <button class="btn btn-danger btn-sm"><i class="icofont-ui-delete"></i></button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/setup-akuntansi/settingrekening/add">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Setting Rekening</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Jenis Transaksi</label><br>
                                <select name="jenis_trx" id="" class="form-control form-control-sm select2_" required>
                                    <option value="">--Pilih Jenis Transaksi--</option>
                                    <option value="simuda">Simuda</option>
                                    <option value="sijaka">Sijaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Rekening Debet</label>
                                <select name="rek_debet" id="" class="form-control form-control-sm select2_" required>
                                    <option value="">--Pilih Kode Rekening--</option>
                                    <?php
                                    foreach ($kodeRekening as $key) {
                                    ?>
                                        <option value="<?= $key->kode_rekening ?>"> <?= $key->kode_rekening . '&nbsp; -- &nbsp;' . $key->nama ?> </option>
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
                                    <option value="">--Pilih Kode Rekening--</option>
                                    <?php
                                    foreach ($kodeRekening as $key) {
                                    ?>
                                        <option value="<?= $key->kode_rekening ?>"> <?= $key->kode_rekening . '&nbsp; -- &nbsp;' . $key->nama ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
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
</div>
<div class="modal" id="modaledit">
</div>

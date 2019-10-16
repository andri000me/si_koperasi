<script>
    // $('#btnEdit').on('click', function () {
    //     edit(kode);
    // });
    function edit(kode) {
        // let kode_rek = kode.toString();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/setup-akuntansi/koderekening/edit/'; ?>"+kode,
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
    <li class="breadcrumb-item active" aria-current="page">Kode Rekening</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kode Rekening</h6>
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
                            <th>Kode Rekening</th>
                            <th>Nama</th>
                            <th>Inisial</th>
                            <th>Saldo Awal</th>
                            <th>Kode Induk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($kodeRekening as $key) {
                            $kode = str_replace('.',',', $key->kode_rekening);
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $key->kode_rekening; ?></td>
                                <td><?php echo $key->nama; ?></td>
                                <td><?php echo $key->inisial; ?></td>
                                <td><?php echo $key->saldo_awal; ?></td>
                                <td><?php echo $key->nama_induk; ?></td>
                                <td style="text-align:center;">
                                    <!-- <button type="button" class="btn btn-sm btn-success" onclick="edit(<?php echo $key->kode_rekening; ?>)"><i class="icofont-ui-edit"></i></button> -->
                                    <button type="button" id="btnEdit" class="btn btn-sm btn-success" onclick="edit('<?="$key->kode_rekening"?>')"><i class="icofont-ui-edit"></i></button>
                                    <a onclick="confirm('Apakah anda yakin?')" href="<?= base_url('index.php/setup-akuntansi/koderekening/delete/'.$key->kode_rekening) ?>">
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
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/setup-akuntansi/koderekening/add">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kode Rekening</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Kode Induk</label>
                                <select name="kode_induk" id="" class="form-control form-control-sm" required>
                                    <option value="">--Pilih Kode Induk--</option>
                                    <?php
                                    foreach ($kodeInduk as $key) {
                                    ?>
                                        <option value="<?= $key->kode_induk ?>"> <?= $key->kode_induk . '&nbsp; -- &nbsp;' . $key->nama ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Kode Rekening</label>
                                <input type="text" name="kode_rekening" class="form-control form-control-sm" placeholder="Masukan Kode Rekening" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Nama Kode Rekening</label>
                                <input type="text" name="nama" class="form-control form-control-sm" placeholder="Masukkan Nama Kode Rekening">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Inisial</label>
                                <input type="text" name="inisial" class="form-control form-control-sm" placeholder="Masukkan Inisial Kode Rekening">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Saldo Awal</label>
                                <input type="number" step=".01" name="saldo_awal" class="form-control form-control-sm" placeholder="Saldo Awal" value="0">
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
<!-- <script>
    function edit(id) {
        $.ajax({
            url: "",
            type: "POST",
            data: {
                id: id
            },
            success: function(ajaxData) {
                $("#modaledit").html(ajaxData);
                $("#modaledit").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    }
</script> -->
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Kredit / Pembiayaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Nominatif</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Nominatif</h6>
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
            <!-- <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;"><i class="icofont-plus-circle"></i> Tambah</button> -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No.Rek</th>
                            <th>Atas Nama</th>
                            <th>Jumlah Pembiayaan</th>
                            <th>Jangka Waktu</th>
                            <th>Pokok</th>
                            <th>Bahas</th>
                            <th>Berjalan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- php echo foreach -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;">
                                <a href="daftar_nominatif_kredit/detail_daftar_nominatif_kredit.php" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->
<!-- Buat Form Tambahnya-->
<!-- <div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">--
            <form name="tambah-pelanggan" method="POST" action="<?php echo base_url(); ?>index.php/Simpanan_wajib/add"> -->
<!-- Modal Header -->
<!-- <div class="modal-header">
                    <h4 class="modal-title">Tambah Simpanan Wajib</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div> -->
<!-- Modal body -->
<!-- <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">No. Anggota</label>
                                <input type="text" name="no_anggota" class="form-control form-control-sm" placeholder="Masukkan No anggota" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Tanggal Bayar</label>
                                <input type="date" name="tgl_pembayaran" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-inner">
                                <label for="" class="pull-left">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>

                Modal footer -->
<!-- <div class="modal-footer">
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modaledit">
</div> -->
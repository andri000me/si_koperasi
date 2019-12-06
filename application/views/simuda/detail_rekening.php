<!-- Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Simuda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Rekening</li>
    </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Rekening</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach($master_rekening_simuda as $i){ ?>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">No. Rekening Simuda</label>
                    <input type="text" name="no_rekening" id="no_rekening" class="form-control-plaintext" readonly value="<?php echo $i->no_rekening_simuda ?>">
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">No. Anggota</label>
                    <input type="text" name="no_anggota" id="no_anggota" class="form-control-plaintext" readonly value="<?php echo $i->no_anggota ?>">
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control-plaintext" readonly value="<?php echo $i->nama; ?>">
                </div>
                <?php } ?>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Datetime</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($detail_rekening_simuda as $p) {
                            ?>
                            <tr>
                                <td><?php echo $no++."."; ?></td>
                                <td><?php echo $p->datetime; ?></td>
                                <td style="text-align:right;"><?php echo number_format($p->debet,0,',','.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($p->kredit,0,',','.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($p->saldo,0,',','.'); ?></td>
                                <!-- <td style="text-align:center;"><button type="button" class="btn btn-sm btn-success">Edit</button></td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
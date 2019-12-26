
<!-- BreadCumb -->

<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Monitoring</a></li>
    <li class="breadcrumb-item active" aria-current="page">Log Activity </li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Log Activity</h6>
        </div>
        <br>
        <div class="row">
            <div class="col-5 ml-auto">
                <form action="" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                  <input type="date" name="tanggal" id="tanggal" class="form-control border-1 small" placeholder="Berdasarkan tanggal.." aria-label="Search" aria-describedby="basic-addon2" value="<?php echo !empty($_GET['tanggal']) ? $_GET['tanggal'] : '' ?>">
                  <select name="user" id="user" class="form-control select2_ bg-light border-1  small">
                    <option value="">Semua User</option>
                    <?php
                    foreach($user as $val){
                    ?>
                      <option value="<?php echo $val->id_user ?>" <?php echo !empty($_GET['user']) && $_GET['user'] == $val->id_user ? 'selected' : '' ?>> <?php echo $val->nama_terang ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search fa-sm"></i>
                  </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($activities as $value) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $value->nama_terang; ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($value->datetime)); ?></td>
                                <td><?php echo $value->keterangan; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modaledit">
</div>
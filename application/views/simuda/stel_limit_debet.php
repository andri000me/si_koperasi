<!-- Content -->
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard' ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Simuda</a></li>
    <li class="breadcrumb-item active" aria-current="page">Stel Limit Debet Simuda</li>
  </ol>
</nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stel Limit Debet Simuda</h6>
        </div>
        <div class="card-body">
            <?php
            echo $this->session->flashdata("update_success");
            echo $this->session->flashdata("update_failed");
            ?>
            <form method="POST" action="<?php echo base_url().'index.php/simuda/updateLimitDebet' ?>">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Nominal</label>
                        <input type="number" name="nominal" class="form-control" value="<?php foreach($limit_debet as $p){ echo $p->nominal; } ?>" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
                        <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
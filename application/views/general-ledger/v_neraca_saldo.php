<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">General Ledger</a></li>
            <li class="breadcrumb-item active" aria-current="page">Neraca Saldo</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Neraca Saldo</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control select2">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">S/d</label>
                        <input type="date" name="sampai_dengan" class="form-control select2">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Kode</label>
                        <select name="kode" id="kode" class="form-control select2_" required>
                            <option value="">--Semua Rekening--</option>
                            <option>211321323</option>
                            <option>432942843</option>
                            <option>945958935</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">S/d</label>
                        <select name="sampai_dengan" id="sampai_dengan" class="form-control select2_" required>
                            <option value="">--Semua Rekening--</option>
                            <option>211321323</option>
                            <option>432942843</option>
                            <option>945958935</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
                        <button type="reset" class="btn btn-sm btn-default btn-secondary">Batal</button>
                    </div>
                </div>
            </form>

         
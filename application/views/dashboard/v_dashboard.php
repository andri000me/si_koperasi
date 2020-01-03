<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <h5 class="h5">Selamat Datang Nama User</h5>
    <br>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Anggota</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $ttlAnggota[0]->ttlAnggota ?> </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Rekening Simuda</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $ttlRekSimuda[0]->ttlRekSimuda ?> </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Rekening Sijaka</div>
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> <?php echo $ttlRekSijaka[0]->ttlRekSijaka ?> </div>
                    </div>
                </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Rekening Kredit</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $ttlRekKredit[0]->ttlRekKredit ?> </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>
    
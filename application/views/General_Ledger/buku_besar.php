<script>
	function manageAjax() {
		var no_anggota_field = $("#no_anggota").val()
		$.ajax({
			url: "<?php echo base_url() . 'index.php/GeneralLedger/manageajaxgetdataanggota'; ?>",
			type: "POST",
			data: {
				id: no_anggota_field
			},
			success: function(ajaxData) {
				$('.data-ajax').html(ajaxData);
			}
		});
	}
</script>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/dashboard' ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">General Ledger</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku Besar</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buku Besar</h6>
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
            <form method="POST" action="<?php echo base_url() . 'index.php/GeneralLedger/simpanBukuBesar' ?>">
                <div class="row">
                    
                        <div class="form-group col-md-4">
                        <label for="">Kode Perkiraan</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($anggota as $a) { ?>
                                <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota . ' - ' . $a->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                        <div class="form-group col-md-4">
                        <label for="">S/d</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2_" onchange="manageAjax()" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($anggota as $a) { ?>
                                <option value="<?php echo $a->no_anggota; ?>"><?php echo $a->no_anggota . ' - ' . $a->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
             <div class="row">
          <div class="form-group col-md-4">
            <label for="inputTanggalPembayaran">Tanggal</label>
            <?php
            $tgl = date('Y-m-d');
            ?>
            <input type="date" class="form-control" id="tgl_pembayaran" value="<?php echo $tgl; ?>" name="tgl_pembayaran" placeholder="Tanggal Pembayaran">
           </div>
            <div class="form-group col-md-4">
            <label for="inputTanggalPembayaran">S/d</label>
            <?php
            $tgl = date('Y-m-d');
            ?>
            <input type="date" class="form-control" id="tgl_pembayaran" value="<?php echo $tgl; ?>" name="tgl_pembayaran" placeholder="Tanggal Pembayaran">
          </div>
            
                </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-primary mr-1">Simpan</button>
                        <button type="reset" class="btn btn-sm btn-default btn-danger">Reset</button>
                    </div>
                </div>
           
            </form>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('.select2_').select2({
            theme: 'bootstrap4',
        });
    });
</script>
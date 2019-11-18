<?php foreach ($kredit as $k) { ?>
    <div class="form-group col-md-4">
        <label for="nama">Atas Nama</label>
        <input type="text" name="no_anggota" class="form-control" id="no_anggota" value="<?php echo $k->no_anggota; ?>" placeholder="Masukan Nama Anda" autofocus>
    </div>
    <div class="col-md-4">
        <label for="inputJangkaWaktu">Jangka Waktu</label>
        <select name="jangka_waktu_bulan" id="jangka_waktu_bulan" class="form-control select2_" value="<?php echo $k->jangka_waktu_bulan; ?>" required>
            <option value="">--Pilih Jangka Waktu--</option>
            <option value=" 3">3 Bulan</option>
            <option value="6">6 Bulan</option>
            <option value="12">12 Bulan</option>
            <option value="18">18 Bulan</option>
            <option value="24">24 Bulan</option>
            <option value="30">30 Bulan</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="jumlah_pembiayaan">Jumlah Pembiayaan</label>
        <input type="number" name="jumlah_pembiayaan" class="form-control" value="<?php echo $k->jumlah_pembiayaan; ?>" id="jumlah_pembiayaan" placeholder="Masukan Jumlah Pembiayaan">
    </div>
    <div class="form-group col-md-4">
        <label for="inputAlamat">Pokok</label>
        <input type="text" class="form-control" value="<?php echo $k->jml_pokok_bulanan; ?>" id="jml_pokok_bulanan" name="jml_pokok_bulanan" placeholder="Pokok">
    </div>
    <div class="form-group col-md-4">
        <label for="inputAlamat">Bahas</label>
        <input type="number" class="form-control" id="jml_bahas_bulanan" value="<?php echo $k->jml_bahas_bulanan; ?>" name="jml_bahas_bulanan" placeholder="Bahas">


    <?php } ?>
    <div>
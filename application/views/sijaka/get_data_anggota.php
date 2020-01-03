<?php foreach($anggota as $a){ ?>
<div class="col-md-4">
    <label for="">Nama</label>
    <input type="text" name="nama" class="form-control" value="<?php echo $a->nama; ?>" required readonly>
</div>
<div class="col-md-4">
    <label for="">Alamat</label>
    <textarea name="alamat" class="form-control" style="height:40px;max-height:40px;" required readonly><?php echo $a->alamat; ?></textarea>
</div>
<?php } ?>
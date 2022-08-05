<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Edit data user</h4>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <?= form_open_multipart('updateUser'); ?>
            <div class="form-group">
              <label>Nama</label>
              <input type="hidden" name="id" value="<?= $p->user_id; ?>">
              <input type="text" name="nama" class="form-control" value="<?= $p->user_nama; ?>" required>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" value="<?= $p->user_username; ?>" readonly>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
            </div>
            <div class="form-group">
              <label>Nomor HP</label>
              <input type="number" name="noHP" class="form-control" value="<?= $p->user_noHP; ?>" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?= $p->user_email; ?>" required>
            </div>
            <img src="<?= base_url('vendor/img/user/'.$p->user_foto) ?>" alt="" height="150px" width="150px">
            <div class="form-group">
              <label>Foto</label>
              <input type="file" name="foto" class="form-control">
            </div>
            <a href="<?= base_url("katalogBuku") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
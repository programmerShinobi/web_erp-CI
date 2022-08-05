<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Edit profil</h4>

      <div class="card">
        <div class="card-body">
          <?= form_open_multipart('editProfile'); ?>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" value="<?= $user->user_nama; ?>" required>
              <input type="hidden" name="id" value="<?= $user->user_id; ?>">
              <?= form_error('nama','<small class="text-danger">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Kode <?php if ($user->user_role == 2){echo "Petugas";} else if ($user->user_role == 1){echo "Admin";}?> </label>
              <input type="text" name="noId" class="form-control" value="<?= $user->user_noId; ?>" disabled>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" value="<?= $user->user_username; ?>" disabled>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?= $user->user_email; ?>" required>
              <?= form_error('email','<small class="text-danger">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Nomor HP</label>
              <input type="number" name="noHP" class="form-control" value="<?= $user->user_noHP; ?>" required>
              <?= form_error('noHP','<small class="text-danger">','</small>'); ?>
            </div>
            <img src="<?= base_url('vendor/img/user/'.$user->user_foto); ?>" alt="" class="gbr-buku-admin">
            <div class="form-group">
              <label>Foto User</label>
              <input type="file" name="foto" class="form-control">
            </div>
            <input type="submit" value="Simpan" class="btn btn-success btn-sm">
          <?= form_close(); ?>
        </div>
      </div>
</div>
<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Profil Saya</h4>
      <div class="card">
        <div class="card-body">
          <table class="table">
            <tr>
            <th>Kode <?php if ($u->user_role == 2){echo "Petugas";} else if ($u->user_role == 1){echo "Admin";}?></th>
              <td>: <?= $u->user_noId; ?></td>
            </tr>
            <tr>
              <th>Nama</th>
              <td>: <?= $u->user_nama; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td>: <?= $u->user_email; ?></td>
            </tr>
            <tr>
              <th>Nomor HP</th>
              <td>: <?= $u->user_noHP; ?></td>
            </tr>
            <tr>
              <th>Username</th>
              <td>: <?= $u->user_username; ?></td>
            </tr>
            <tr>
              <th>Sebagai</th>
              <td>: <?php
                if($u->user_role == 1) {
                  echo 'Admin';
                } elseif($u->user_role == 2) {
                  echo 'Petugas';
                } elseif($u->user_role == 3) {
                  echo 'User';
                }
              ?></td>
            </tr>
            <tr>
          </table>
          <a href="<?= base_url('editProfile'); ?>" class="btn btn-info btn-sm">Edit</a>
          <a href="<?= base_url('cetakProfile'); ?>" target="_blank" class="btn btn-primary btn-sm">Cetak Kartu Anggota</a>
        </div>
      </div>
</div>
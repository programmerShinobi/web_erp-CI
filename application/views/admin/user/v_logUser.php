<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Log User</h4>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataVisibility">
          <thead>
            <tr>
              <th width="1%">#</th>
              <th>User</th>
              <th>Role</th>
              <th>Tanggal Login</th>
              <th>Jam Login</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach ($log_user as $item) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $item->user_nama; ?></td>
              <td>
                <?php
                  if($item->user_role == 1) {
                    echo "Admin";
                  } elseif($item->user_role == 2) {
                    echo "Petugas";
                  } elseif($item->user_role == 3) {
                    echo "Anggota";
                  } elseif($item->user_role == 4) {
                    echo "Petugas Sekolah";
                  } elseif($item->user_role > 4) {
                    echo "Petugas Pemda";
                  }
                ?>
                </td>
              <td><?= date("d M Y", strtotime($item->log_tanggal)); ?></td>
              <td><?= date("H:i:s", strtotime($item->log_time)); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
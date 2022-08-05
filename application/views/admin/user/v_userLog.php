<div class="container-fluid">
  <h4>User Login</h4>
  <div class="card">
    <div class="card-body">
      <table class="table-responsive table table-bordered table-hover" id="dataVisibility">
        <thead>
          <tr>
            <th width="1%">#</th>
            <th>User</th>
            <th>Tanggal Login</th>
            <th>Jam Login</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach($log as $l) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $l->user_nama; ?></td>
            <td><?= date('d M Y', strtotime($l->log_tanggal)); ?></td>
            <td><?= date('H:i:s', strtotime($l->log_time)); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
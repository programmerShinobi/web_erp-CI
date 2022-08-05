<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Sub Menu Management</h4>
  <div class="card">
    <div class="card-body">
      <a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Sub Menu</a>
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataVisibility">
          <thead>
            <tr>
              <th width="1%">#</th>
              <th>Sub Menu</th>
              <th>Judul</th>
              <th>Link</th>
              <th>Icon</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($list_sub as $item) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $item->menu_judul; ?></td>
              <td><?= $item->sub_judul; ?></td>
              <td><?= $item->sub_link; ?></td>
              <td><?= $item->sub_icon; ?></td>
              <td>
                <?php
                  if($item->sub_status == 1) {
                    echo '<div class="badge badge-success">Aktif</div>';
                  } elseif($item->sub_status == 2) {
                    echo '<div class="badge badge-danger">Tidak aktif</div>';
                  }
                ?>
              </td>
              <td>
              <div class="form-group card ">
                <a href="<?= base_url('view_edit_sub/'.$item->sub_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
              </div>
              <div class="form-group card ">
                <a href="<?= base_url('process_delete_sub/'.$item->sub_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-edit"></i> Hapus</a>
              </div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Tambah Menu</h5>
        <button type="button" data-dismiss="modal" class="close">&times;</button>
      </div>
      <div class="modal-body">
        <?= form_open('validation_sub_add'); ?>
        <div class="form-group">
          <label>Menu</label>
          <select name="menu_id" class="form-control" required>
            <option selected disabled>-- Pilih menu </option>
            <?php foreach($list_menu as $item) { ?>
            <option value="<?= $item->menu_id; ?>"><?= $item->menu_judul; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>Judul Submenu</label>
          <input type="text" name="sub_judul" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Link</label>
          <input type="text" name="sub_link" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Icon</label>
          <input type="text" name="sub_icon" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="sub_status" class="form-control" required>
            <option disabled selected>-- Pilih status --</option>
            <option value="1">Aktif</option>
            <option value="2">Tidak aktif</option>
          </select>
        </div>
        <input type="submit" value="Simpan" class="btn btn-success btn-sm">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button>
      </div>
    </div>
  </div>
</div>

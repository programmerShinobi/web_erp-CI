<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h5>Edit Sub Menu</h5>
  <div class="row">
    <div class="col-md">
      <div class="card">
        <div class="card-body">
          <?= form_open('validation_sub_edit'); ?>
            <div class="form-group">
              <label>Menu</label>
              <input type="hidden" name="sub_id" value="<?= $sub_item->sub_id; ?>">
              <select name="menu_id" class="form-control" required>
                <option selected disabled>-- Pilih menu </option>
                <?php foreach($list_menu as $item) { ?>
                <option <?php if($item->menu_id == $sub_item->menu_id) { echo "selected"; } ?> value="<?= $item->menu_id; ?>"><?= $item->menu_judul; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Judul Submenu</label>
              <input type="text" name="sub_judul" class="form-control" value="<?= $sub_item->sub_judul; ?>" required>
            </div>
            <div class="form-group">
              <label>Link</label>
              <input type="text" name="sub_link" class="form-control" value="<?= $sub_item->sub_link; ?>" required>
            </div>
            <div class="form-group">
              <label>Icon</label>
              <input type="text" name="sub_icon" class="form-control" value="<?= $sub_item->sub_icon; ?>" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="sub_status" class="form-control" required>
                <option disabled selected>-- Pilih status --</option>
                <option <?php if($sub_item->sub_status == 1) { echo "selected"; } ?> value="1">Aktif</option>
                <option <?php if($sub_item->sub_status == 2) { echo "selected"; } ?> value="2">Tidak aktif</option>
              </select>
            </div>
            <a href="<?= base_url("subMenu") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

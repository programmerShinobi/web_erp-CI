<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md">
      <div class="card">
        <div class="card-body">
          <?= form_open('process_menu_edit'); ?>
            <div class="form-group">
              <label>Menu judul</label>
              <input type="hidden" name="menu_id" value="<?= $menu_item->menu_id; ?>">
              <input type="text" name="menu_judul" class="form-control" value="<?= $menu_item->menu_judul; ?>" required>
              <?= form_error('menu','<small class="text-danger">','</small>') ?>              
            </div>
            <a href="<?= base_url("menu") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

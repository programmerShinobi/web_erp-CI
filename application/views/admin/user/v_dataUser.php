<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
  <h4>Data User</h4>
  <div class="card">
    <div class="card-body">
      <a href="" data-toggle="modal" data-target="#add" class="btn btn-primary btn-sm mb-3">Tambah User</a>
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataVisibility">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Klasifikasi</th>
              <th>Username</th>
              <th>Role</th>
              <th>Nomor HP</th>
              <th>Email</th>
              <?php if ($user->user_role == 1){?>
                <th width="250px">Aksi</th>
              <?php } else {?>
                <th width="150px">Aksi</th>
              <?php
              }?>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($list_user as $item) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $item->user_nama; ?></td>
              <td><?= $item->user_klasifikasi; ?></td>
              <td><?= $item->user_username; ?></td>
              <td>
                <?php
                  if($item->user_role == 1) {
                    echo "Admin";
                  } elseif($item->user_role == 2) {
                    echo "Petugas";
                  } elseif($item->user_role == 3) {
                    echo "User";
                  }
                ?>
              </td>
              <td><?= $item->user_noHP; ?></td>
              <td><?= $item->user_email; ?></td>
              <td>
              <div class="form-group card ">
                <a href="<?= base_url('cetakUser/'.$item->user_id); ?>" target="_blank" class="btn btn-success btn-sm">Cetak Kartu</a>
              </div>
              <div class="form-group card ">  
                <a href="<?= base_url('view_user_edit/'.$item->user_id); ?>" class="btn btn-info btn-sm">Edit</a><p></p>
              </div> 
                <?php if ($user->user_role == 1){?>
                  <div class="form-group card ">
                      <a href="<?= base_url('process_user_delete/'.$item->user_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')">Hapus</a>
                  </div>    
                      <?php
                    }?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
//koneksi
$databaseHost = 'localhost';
$databaseName = 'db_library';
$databaseUsername = 'root';
$databasePassword = ''; 
// $databaseHost = 'localhost';
// $databaseName = 'ewebid_perpus';
// $databaseUsername = 'ewebid_admin_perpus';
// $databasePassword = '@dm!n_perpus'; 

$con = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
$sql_="SELECT*FROM tb_user"; 
$kode=1;
        $tampil=mysqli_query($con,$sql_);
        while ($tampilkan=mysqli_fetch_array($tampil))
        { $kode++;

//Support KodeTambah
            if($kode<=9)
            {
                $kodeTambah="000";
            }

                else if($kode<=99)
            {
                $kodeTambah="00";
            }

                else if($kode<=1000)
            {
                $kodeTambah="0";
            }

                else if($kode<=10000)
            {
                $kodeTambah="";
            }  
        }
?>

<div class="modal fade" id="add">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Tambah User</h5>
        <button type="button" data-dismiss="modal" class="close">&times;</button>
      </div>
      <div class="modal-body">
        <?= form_open('validation_user_add'); ?>
        <div class="row">
          <div class="col-md-6">
            <h5>Data Pribadi</h5>
            <div class="form-group">
            <label>Kode User</label>
              <!-- <input type="text" class="form-control" value="<?php echo $kodeTambah.$kode;?>" disabled>  -->
              <input type="text" name="user_noId" class="form-control" value="<?php echo $kodeTambah.$kode;?>" >
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="user_nama" class="form-control" required autofocus>
            </div>
            <div class="form-group">
              <label>Tempat Lahir</label>
              <input type="text" name="user_tempatLahir" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Tanggal Lahir</label>
              <input type="date" name="user_tanggalLahir" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Klasifikasi</label>
              <select class="form-control" name="user_klasifikasi" required >
                <option disabled selected>-- Pilih Klasifikasi --</option>
                <option name="user_klasifikasi" value="TK" required>TK</option>
                <option name="user_klasifikasi" value="SD" required>SD</option>
                <option name="user_klasifikasi" value="SMP" required>SMP</option>
                <option name="user_klasifikasi" value="SMA" required>SMA</option>
                <option name="user_klasifikasi" value="Mahasiswa" required>Mahasiswa</option>
                <option name="user_klasifikasi" value="PNS" required>PNS</option>
                <option name="user_klasifikasi" value="Karyawan" required>Karyawan</option>
                <option name="user_klasifikasi" value="Umum" required>Umum</option>
              </select>             
            </div>
            <div class="form-group">
              <label>Nomor Induk KTP / Kartu Pelajar</label>
              <input type="text" name="user_ktp" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="user_username" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="user_password" class="form-control" required>
            </div>
              <div class="form-group">
                <label>Nomor HP</label>
                <input type="number" name="user_noHP" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="user_email" class="form-control" required>
              </div>
          </div>
          <div class="col-md-6">
            <h5>Data Orang Tua</h5>
            <div class="form-group">
              <label>Nama Orang Tua</label>
              <input type="text" name="orangtua_nama" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Nomor HP Orang Tua</label>
              <input type="number" name="orangtua_noHP" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Tempat Lahir Orang Tua</label>
              <input type="text" name="orangtua_tempatLahir" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Tanggal Lahir Orang Tua</label>
              <input type="date" name="orangtua_tanggalLahir" class="form-control" required>
            </div>
            <h5>Pertanyaan Keamanan</h5>
            <div class="form-group">
              <select name="pertanyaan" class="form-control" required>
                <option disabled selected>-- Pilih Pertanyaan --</option>
                <option value="Siapa nama peliharaan anda?">Siapa nama peliharaan anda?</option>
                <option value="Siapa nama kakek anda?">Siapa nama kakek anda?</option>
                <option value="Siapa nama saudara anda?">Siapa nama saudara anda?</option>
                <option value="Nama sekolah SD anda adalah?">Nama sekolah SD anda adalah?</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" name="jawaban" class="form-control" required>
            </div>
          </div>
        </div>
        <input type="submit" value="Simpan" class="btn btn-success btn-sm">
        <?= form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button>
      </div>
    </div>
  </div>
</div>

<!DOCTYPE html>
<html>
<head>
<title> <?php echo $title."&nbsp;"; if ($user->user_role == 2){echo "Petugas";} else {echo "Anggota";}  ?></title>
</head>
<body onload='window.print()' style="font-family: arial;font-size: 12px;position:absolute;margin-top: -30px;margin-left: -30px;">
    <?php 
        // $r=mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tb_user where kode_anggota='$_GET[user_id]'"));
        // $t = date("d - m - Y", strtotime($r['tanggal_lahir']));
    ?>                                                                                 
<div style="width: 370px;height: 243px;margin: 30px;background-image:url('<?= base_url('/vendor/img/Icon/bismillah_.png') ?>');">
    <img style="position: absolute;padding-left: 10px;padding-top: 10px;" class=""  src="<?= base_url('/vendor/img/Icon/Karawang.png') ?>" width="40px">
    <!--<img style="position: absolute;padding-left: 10px;padding-top: 10px;" class="img-responsive img" alt="Responsive image" src="<?= base_url('/vendor/img/icon/Student.png') ?>" width="45px">-->
    <!--<img style="position: absolute;padding-left: 330px;padding-top: 10px;" class="img-responsive img" alt="Responsive image" src="<?= base_url('/vendor/img/icon/Karawang.png') ?>" width="32px">-->
    <p style="position: absolute; font-family: arial; font-size: 11px; color: black; padding-left: 90px;text-transform: uppercase; text-align: center;">Dinas Perpustakaan dan Kearsipan<br>Daerah Kabupaten Karawang</p>
    <p style="padding-left: 145px;padding-top: 80px;font-size: 10px; "><b>KARTU <?php if ($user->user_role == 2){echo "PETUGAS";} else {echo "ANGGOTA";}  ?></b></p>
    <img style="border: 3px solid #000000;position: absolute;margin-left: 50px;margin-top: -20px;" src="<?= base_url('vendor/img/user/'.$user->user_foto) ?>" height="85px" width="75px">
        <table style="margin-top: -5px;padding-left: 143px; position: relative;font-family: arial;font-size: 10px;">
            <tr>
              <td>Kode <?php if ($user->user_role == 2){echo "Petugas";} else {echo "Anggota";}  ?></td>
              <td>: <?= $user->user_noId; ?></td>
            </tr><tr>
              <td>Nama</td>
              <td>: <?= $user->user_nama; ?></td>
            </tr><tr>
              <td>Klasifikasi</td>
              <td>: 
                <?php
                  if($user->user_klasifikasi == 1) {
                    echo "TK";
                  } elseif($user->user_klasifikasi == 2) {
                    echo "SD";
                  } elseif($user->user_klasifikasi == 3) {
                    echo "SMP";
                  } elseif($user->user_klasifikasi == 4) {
                    echo "SMA";
                  } elseif($user->user_klasifikasi == 5) {
                    echo "Mahasiswa";
                  } elseif($user->user_klasifikasi == 6) {
                    echo "PNS";
                  } elseif($user->user_klasifikasi == 7) {
                    echo "Karyawan";
                  } elseif($user->user_klasifikasi == 8) {
                    echo "Umum";
                  } else {
                    echo "-";
                  }
                ?>
              </td>
            </tr><tr>
              <td>No.HP</td>
              <td>: <?= $user->user_noHP; ?></td>
            </tr><tr>
              <td>Berlaku</td>
              <td>: Selama Menjadi <?php if ($user->user_role == 2){echo "Petugas";} else {echo "Anggota";}  ?></td>
            </tr>
        </table>
        <p style="padding-left: 9px;padding-top: 20px;font-size: 9px; font-family: arial;text-align: center; position: absolute;">Alamat: Jl. Jendral Ahmad Yani No. 10 Desa Karangpawitan Kec. Karawang Barat 41315<br> Email: eperpusipkrw@gmail.com | Telp. 081910788875 | Website: e-web.id</p>
        <div style="margin-top: 0px;padding-left:30px;padding-top: 0px;">
            <p style="margin-top:100px;padding-left: 90px;padding-top: 10px;font-size: 10px"><b>TATA TERTIB PERPUSTAKAAN</b><br>
            <ol style="margin-top: 0px;padding-left: 30px;color:black; font-family: arial;font-size: 10px;text-align: justify;padding-right: 10px">
                <li>Kartu ini diterbitkan oleh Perpustakaan Pemda Karawang.</li>
                <li>Segala penggunaan kartu ini diatur oleh perpustakaan sesuai
                <br>ketentuan dan syarat yang berlaku.</a></li>
                <li>Setiap <?php if ($user->user_role == 2){echo "petugas";} else {echo "anggota";}  ?> wajib membawa kartu ini jika ke perpustakaan.</li>
                <li>Kartu ini tidak boleh dialih pinjamkan.</li>
                <li>Bila menemukan kartu ini, mohon kembalikan ke Perpustaakaan
                <br>Pemda Karawang.</li>
            </ol>
            <ol style="margin-top: 0px;padding-left: 20px;padding-right: 10px">
                <img src="<?= base_url('vendor/img/qr/'.$user->user_qr) ?>" alt="" width="40%" height="100px" class="mt-1">
                <small>Scan QR Code ini</small>
            </ol>
            </p>
        </div>

</div>


</body>
</html>

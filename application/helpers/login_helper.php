<?php

  
  function protek_login()
  {
    $ci = get_instance();

    if(!$ci->session->userdata('status')) {
      $ci->session->set_flashdata('pesan', '<script>sweet("Gagal Masuk!","Wajib login terlebih dahulu!","error","Tutup");</script>');
      
      redirect('index');
    }
  }

  function get_pengunjung()
  {
    $ci = get_instance();
    $pengunjung = new stdClass();
    $pengunjung->browser = $_SERVER["HTTP_USER_AGENT"];
    $pengunjung->alamat_ip = $_SERVER["REMOTE_ADDR"];
    $data = [
      "browser" => $pengunjung->browser,
      "alamat_ip" => $pengunjung->alamat_ip,
      "waktu" => date("Y-m-d")
    ];
    $ci->db->insert("tb_pengunjung", $data);
  }

  function hariIndonesia()
  {
    $hariIni = date('D');
		if($hariIni == "Sun") {
		$hariIni='Minggu';
		} else if ($hariIni == "Mon") {
		$hariIni = 'Senin';
		} else if ($hariIni == "Tue") {
		$hariIni = 'Selasa';
		} else if ($hariIni == "Wed") {
		$hariIni = 'Rabu';
		} else if ($hariIni == "Thu") {
		$hariIni = 'Kamis';
		} else if ($hariIni == "Fri") {
		$hariIni = 'Jumat';
		} else if ($hariIni == "Sat") {
		$hariIni = 'Sabtu';
		}

  }

?>

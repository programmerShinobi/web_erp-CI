function sweet(capt, isi, ikon, tombol) {
  swal({
    title: capt,
    text: isi,
    icon: ikon,
    button: tombol,
  });
}


function valid(){
  var nama,email,user,pass,pass1;

  nama = $('#nama').val();
  email = $('#mail').val();
  noHp = $('#noHp').val();
  user = $('#user').val();
  pass = $('#pass').val();
  pass1 = $('#pas1').val();
  
  if(nama != "") {
    if(email != "") {
      if(noHp != "") {
        if(user != "") {
          if(pass != "") {
            if(pass1 != "") {
              return true
            } else {
              alert('Ulangi password harus di isi!');
            }
          } else {
            alert('Password harus di isi!');
          }
        } else {
          alert('Username harus di isi!');
        }
      } else {        
        alert('Nomor HP harus di isi!');
      }
    } else {
      alert('Email harus di isi!');
    }
  } else {
    alert('Masukan nama anda!');
  }
}
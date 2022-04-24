<?php
include "config/koneksi.php";
include "config/fungsi_indotgl.php";

// Bagian Home
if ($_GET[modul]=='beranda'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[namauser]</b>, selamat datang di halaman ";
  if ($_SESSION[leveluser] == 'admin') { echo "<b>Administrator</b>"; }
  else if ($_SESSION[leveluser] == 'kepsek') { echo "<b>Kepala Sekolah</b>"; }
  else if ($_SESSION[leveluser] == 'guru') { echo "<b>Guru</b>"; }
  else if ($_SESSION[leveluser] == 'siswa') { echo "<b>Siswa</b>"; } 
  echo "  SPK Pemilihan Tablet PC Menggunakan Metode Simple Additive Weighting (SAW).<br>
		   Silahkan klik menu pilihan yang berada 
          di sebelah kiri untuk mengelola content website. </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align=right>Login Hari ini: ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo "</p>";
}

elseif ($_GET[modul]=='pengguna'){
  include "modul_admin/mod_pengguna/pengguna.php";
}

// Bagian Modul
elseif ($_GET[modul]=='kriteria'){
  include "modul_admin/mod_kriteria/kriteria.php";
}

// Bagian Bobot Kriteria
elseif ($_GET[modul]=='bobot'){
  include "modul_admin/mod_bobot/matrik.php";
}

// Bagian Alternatif
elseif ($_GET[modul]=='alternatif'){
  include "modul_admin/mod_alternatif/alternatif.php";
}


// Bagian Evaluasi Karyawan
elseif ($_GET[modul]=='evaluasi'){
  include "modul_admin/mod_evaluasi/evaluasi.php";
}

// Bagian Laporan Evaluasi Karyawan
elseif ($_GET[modul]=='laporan'){
  include "modul_admin/mod_laporan/laporan.php";
}

// Bagian Bantuan
elseif ($_GET[modul]=='bantuan'){
  include "bantuan.php";
}

// Bagian Tentang
elseif ($_GET[modul]=='tentang'){
  include "tentang.php";
}

// Bagian Hasil User
elseif ($_GET[modul]=='hasil'){
  include "modul_admin/mod_laporan/laporan.php";
}

// Bagian Profil User
elseif ($_GET[modul]=='profil_siswa'){
  include "modul_user/profil.php";
}

elseif ($_GET[modul]=='profil_kepsek'){
  include "modul_kepsek/profil.php";
}

elseif ($_GET[modul]=='laporan_kepsek'){
  include "modul_kepsek/laporan.php";
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}


?>
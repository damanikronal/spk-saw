<?php
$aksi="modul_admin/mod_evaluasi/aksi_evaluasi.php";
// Jumlah Alternatif
$jlh_alt = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM alternatif"),0);

// Jumlah Kriteria
$jlh_cri = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0);

switch($_GET[act]){
  // Tampil Kelas
  default:
  	$tampil1=mysql_query("SELECT id_kriteria, bobot FROM bobot_kriteria ORDER BY id_kriteria");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>Pemilihan Tablet PC Menggunakan Metode SAW</h2>";
		echo "
			<table>
          <tr><th>kriteria</th><th>bobot</th></tr>"; 
		$tampil2=mysql_query("SELECT k.nama_kriteria, b.bobot
		 FROM bobot_kriteria b, kriteria k
		 WHERE b.id_kriteria=k.id_kriteria
		 ORDER BY b.id_kriteria");
		while ($r2=mysql_fetch_array($tampil2)){
		   echo "<tr>
		   		<td>$r2[nama_kriteria]</td>
				 <td>$r2[bobot]</td>
				 </tr>";
		}
		echo "</table>";
		echo "<a href=?modul=evaluasi&act=saw>Gunakan bobot kriteria dan Cari Tablet PC.</a>";
		echo "<br>";
		echo "Atau<br/>";
		echo "<a href=?modul=evaluasi&act=normalisasi>Hitung ulang bobot kriteria dan Cari Tablet PC.</a>";
	}
	else{
		echo "<a href=?modul=bobot&act=normalisasi>Hitung ulang bobot kriteria dan Cari Tablet PC.</a>";
	}
    break;
   
  case "saw":
    // FISRT STEP : NORMALISATION BOBOT SCALE
	for ($i=1;$i<=$jlh_alt;$i++){
		for ($j=1;$j<=$jlh_cri;$j++){
			// Kueri Ambil Tipe Kriteria
			$cek=mysql_query("SELECT tipe FROM kriteria WHERE id_kriteria='$j'");
			$ccek=mysql_fetch_array($cek);
			// Cek Tipe Kriteria
			if ($ccek[tipe]=="COST"){
				// Nilai Pembanding Untuk Kriteria Jenis COST / Biaya
				$val = mysql_result(mysql_query("SELECT min( nilai ) FROM matrik WHERE id_kriteria ='$j'"),0);
				// Ambil Bobot Alternatif
				$bobot = mysql_result(mysql_query("SELECT nilai FROM matrik WHERE id_alt='$i' AND id_kriteria ='$j'"),0);
				// Normalisasi
				$N[$i][$j]=round(($val / $bobot),2);
			}
			elseif ($ccek[tipe]=="BENEFIT"){
				// Nilai Pembanding Untuk Kriteria Jenis BENEFIT / Keuntungan
				$val = mysql_result(mysql_query("SELECT max( nilai ) FROM matrik WHERE id_kriteria ='$j'"),0);
				// Ambil Bobot Alternatif
				$bobot = mysql_result(mysql_query("SELECT nilai FROM matrik WHERE id_alt='$i' AND id_kriteria ='$j'"),0);
				// Normalisasi
				$N[$i][$j]=round(($bobot / $val),2);
			}
		}
	}
	for ($i=1;$i<=$jlh_alt;$i++){
		for ($j=1;$j<=$jlh_cri;$j++){
			// Bobot Kriteria
			$b_cri = mysql_result(mysql_query("SELECT bobot FROM bobot_kriteria WHERE id_kriteria ='$j'"),0);
			// Vektor Alternatif
			$V[$i][$j] = round(($N[$i][$j] * $b_cri),3);
		}
	}
	mysql_query("DELETE FROM hasil");
	for ($i=1;$i<=$jlh_alt;$i++){
		$tampil_alt=mysql_query("SELECT id_alt, nm_alt FROM alternatif WHERE id_alt='$i' ORDER BY id_alt");
		$r_alt=mysql_fetch_array($tampil_alt);
		$total=0;
		for ($j=1;$j<=$jlh_cri;$j++){
			$total=$total + $V[$i][$j];
		}
		$VV[$i]=$total;
		$k=$VV[$i];
		mysql_query("INSERT INTO hasil(id_alt,bobot_hasil) VALUES('$i', '$k')");
	}
	// Cari yang terbsesar
	echo "<h2>Pemilihan Tablet PC Menggunakan Metode SAW</h2>";
    echo "<table>
          <tr><th>alternatif</th><th>nilai (bobot kriteria)</th></tr>"; 
	$querialt=mysql_query("SELECT h.bobot_hasil, a.nm_alt FROM hasil h, alternatif a WHERE h.id_alt=a.id_alt ORDER BY h.bobot_hasil DESC");
    while ($alth=mysql_fetch_array($querialt)){
		echo "<tr><td>$alth[nm_alt]</td><td>$alth[bobot_hasil]</td></tr>";
	}
	$rialt=mysql_query("SELECT h.bobot_hasil, a.nm_alt FROM hasil h, alternatif a WHERE h.id_alt=a.id_alt ORDER BY h.bobot_hasil DESC");
	$ralt=mysql_fetch_array($rialt);
	echo "<tr><td colspan='2'>Rekomendasi Pilihan Tablet PC : $ralt[nm_alt] dengan Bobot $ralt[bobot_hasil]</td></tr>";
    echo "</table>";
	echo "<h2>Cetak Hasil Keputusan</h2>
          <form method='POST' action='config/cetak.php'>
          <table>
		  ";?> 
		  
	<?
	echo "
		  <tr><td colspan=2><input type=submit name=submit value=Cetak></td></tr>
          </table></form>"; 
	break;

}

?>

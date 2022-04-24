<?php

include "koneksi.php";

// Jumlah Alternatif
$jlh_alt = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM alternatif"),0);

// Jumlah Kriteria
$jlh_cri = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0);

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

for ($i=1;$i<=$jlh_alt;$i++){
	$total=0;
	for ($j=1;$j<=$jlh_cri;$j++){
		$total=$total + $V[$i][$j];
	}
	$VV[$i]=$total;
	$k=$VV[$i];
	echo "$k<br/>";
}


?>
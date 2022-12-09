<?php
include 'config.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date("Y-m-d");
$sql = "SELECT j.*, d.nama AS nama_dokter, p.nama AS nama_poli FROM jadwal_dok j INNER JOIN dokter d ON j.id_dokter = d.id_dokter INNER JOIN poli p ON j.id_poli = p.id_poli ORDER BY j.id ASC";
$x = mysqli_query($koneksi, $sql);
$i = 0;
$data = array();
while ($r = mysqli_fetch_array($x)) {
    $data[$i]['jadwal_dokter'] = $r['jadwal_dokter'];
    $data[$i]['nama_dokter'] = $r['nama_dokter'];
    $data[$i]['nama_poli'] = $r['nama_poli'];
    $i++;
}
echo json_encode($data);

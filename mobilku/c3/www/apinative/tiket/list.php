<?php
include '../config.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date("Y-m-d");
$sql = "SELECT a.*,a.no_antrian AS antrian, p.nama AS nama_poli, u.nama AS nama_user, u.nik AS nik FROM antrian a INNER JOIN poli p ON a.id_poli = p.id_poli INNER JOIN users u ON a.id_users = u.id WHERE waktu LIKE '$tgl%' ORDER BY a.id ASC";
$x = mysqli_query($koneksi, $sql);
$i = 0;
$data = array();
while ($r = mysqli_fetch_array($x)) {
    $data[$i]['nik'] = $r['nik'];
    $data[$i]['nama_poli'] = $r['nama_poli'];
    $data[$i]['nama_user'] = $r['nama_user'];
    $data[$i]['antrian'] = $r['antrian'];
    $data[$i]['status'] = $r['status'];
    $i++;
}
echo json_encode($data);

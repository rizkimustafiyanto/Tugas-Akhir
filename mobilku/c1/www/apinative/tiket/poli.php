<?php
include '../config.php';

function manipulasiTanggal($tgl, $jumlah = 1, $format = 'days')
{
    $currentDate = $tgl;
    return date('Y-m-d H:i:s', strtotime($jumlah . ' ' . $format, strtotime($currentDate)));
}

date_default_timezone_set('Asia/Jakarta');
$tgl = date("Y-m-d H:i:s");
$waktu = date("H:i:s");
echo $tgl;
echo "\n\n\n\n\n\n\t\t           ";
echo $waktu;
echo "\n\n\n\t\t\t      ";

$bookday = manipulasiTanggal($tgl, '2', 'days');
echo $bookday;


// $id_users = "4";
// $nik = "1232";
// $password = "11";
// $id_poli = "2";

// $result = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM users");
// $row = mysqli_fetch_assoc($result);
// $count = $row['jumlah'];
// $no = (int)$count + 1;

// $sql = "SELECT * FROM users WHERE nik = '$nik'";
// $q = mysqli_query($koneksi, $sql);
// $data = mysqli_num_rows($q);
// if ($data == 1) {
//     echo "apa";
// } else {
//     echo "salah";
// }





// while ($r = mysqli_fetch_array($q)) {
//     $data[] = $r;
// }
// echo json_encode($data);

// echo json_encode($q);
// if (mysqli_num_rows($q) == 0) {
//     $sql = "INSERT INTO antrian ( no_antrian, waktu, status, id_poli, id_users) VALUES ('$no_antrianpoli', '$waktu', '$status', '$id_poli', '$id_users')";
//     $ff = mysqli_query($koneksi, $sql);
//     if ($ff) {
//         echo base64_encode("1|Berhasil Mendaftar");
//     } else {
//         echo base64_encode("2|Gagal Mendaftar");
//     }
// } else {
//     echo base64_encode("3|Anda Telah Teraftar Antrian");
// }



// $sql = "SELECT a.*,a.no_antrian AS antrian, p.nama AS nama_poli, u.nama AS nama_user, u.nik AS nik FROM antrian a INNER JOIN poli p ON a.id_poli = p.id_poli INNER JOIN users u ON a.id_users = u.id WHERE a.id_users = '$id_users' ORDER BY a.id ASC";
// $x = mysqli_query($koneksi, $sql);
// $i = 0;
// while ($r = mysqli_fetch_array($x)) {
//     $data[$i]['nik'] = $r['nik'];
//     $data[$i]['nama_poli'] = $r['nama_poli'];
//     $data[$i]['nama_user'] = $r['nama_user'];
//     $data[$i]['antrian'] = $r['antrian'];
//     $i++;
// }
// echo json_encode($data);

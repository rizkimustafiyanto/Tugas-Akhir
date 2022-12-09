<?php
include 'config.php';
if (isset($_REQUEST["data"])) {
    $fungsi = $_REQUEST["data"];
    if ($fungsi == "dokter") {
        $sql = "SELECT * FROM dokter ";
    } else if ($fungsi == "antrian") {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d");
        $sql = "SELECT * FROM antrian WHERE waktu LIKE '$tgl%'";
    } else if ($fungsi == "lihatantri") {
        if (!isset($_REQUEST["nik"])) {
            echo base64_encode("0|Format Lihat Data Salah");
            exit;
        }
        $nik = $_REQUEST["nik"];
        $t = mysqli_query($koneksi, "SELECT * FROM users WHERE nik = '$nik'");
        if (mysqli_num_rows($t) > 0) {
            while ($row = mysqli_fetch_assoc($t)) {
                $tiket = $row["id"];
            }
        } else {
            echo "Kata Sandi Salah";
        }
        $sql = "SELECT * FROM antrian WHERE id_users = '$tiket' ORDER BY waktu ASC";
    } else {
        echo base64_encode("90|data Tidak Terdeteksi");
    }
    $x = mysqli_query($koneksi, $sql);
    $data = array();
    while ($r = mysqli_fetch_object($x)) {
        $data[] = $r;
    }
    echo json_encode($data);
} else {
    echo base64_encode("0|Format Salah");
}

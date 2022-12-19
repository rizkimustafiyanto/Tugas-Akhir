<?php
include 'config.php';
if (isset($_REQUEST["data"])) {
    $fungsi = $_REQUEST["data"];
    if ($fungsi == "filterdata") {
        if (!isset($_REQUEST["id_antrian"])) {
            echo base64_encode("0|Format Filter Data Salah");
            exit;
        }
        $id_antrian = $_REQUEST["id_antrian"];
        $sql = "SELECT a.*,a.no_antrian AS antrian, p.nama AS nama_poli, u.nama AS nama_user, u.nik AS nik FROM antrian a INNER JOIN poli p ON a.id_poli = p.id_poli INNER JOIN users u ON a.id_users = u.id WHERE a.id = '$id_antrian' ORDER BY a.id ASC";
        $x = mysqli_query($koneksi, $sql);
        $data = array();
        while ($r = mysqli_fetch_object($x)) {
            $data[] = $r;
        }
        echo json_encode($data);
    } else if ($fungsi == "bacadata") {
        $sql = "SELECT * FROM poli ORDER BY loket ASC";
        $x = mysqli_query($koneksi, $sql);
        $data = array();
        while ($r = mysqli_fetch_object($x)) {
            $data[] = $r;
        }
        echo json_encode($data);
    } else if ($fungsi == "lihatdata") {
        $nik = $_REQUEST["nik"];
        $password = $_REQUEST["password"];
        // Mengambil ID User dan Password
        $queryu = mysqli_query($koneksi, "SELECT * FROM users WHERE nik = '$nik'");
        if (mysqli_num_rows($queryu) == 0) {
            echo base64_encode("0|NIK Salah atau Belum Terdaftar");
            exit;
        }
        $datauser = mysqli_fetch_array($queryu);
        $id_users = $datauser['id'];
        $nik_users = $datauser['nik'];
        $password_users = $datauser['password'];
        if ($password != $password_users) {
            echo "Password Salah";
            echo base64_encode("0|Password Salah");
            exit;
        }
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d");
        $status = "Belum";
        //Eksekusi Tiket
        $sql = "SELECT * FROM antrian WHERE id_users = '$id_users' AND waktu LIKE '$tgl%'";
        $x = mysqli_query($koneksi, $sql);
        while ($r = mysqli_fetch_array($x)) {
            $data[] = $r;
        }
        echo json_encode($data);
    } else if ($fungsi == "hapusdata") {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d");

        if (!isset($_REQUEST["nik"])) {
            echo base64_encode("0|Format Hapus Data Salah");
            exit;
        }
        $nik = $_REQUEST["nik"];

        $antrian = "SELECT max(no_antrian) as no_antrianTerbesar FROM antrian WHERE no_antrian LIKE '$huruf%' AND waktu LIKE '$tgl%'";

        $sql = "SELECT * FROM users WHERE nik = '$nik'";
        $q = mysqli_query($koneksi, $sql);
        if (mysqli_num_rows($q) > 0) {
            $sql = "DELETE FROM users WHERE nik = '$nik'";
            $ff = mysqli_query($koneksi, $sql);
            if ($ff) {
                echo base64_encode("1|Berhasil Dihapus");
            } else {
                echo base64_encode("2|Gagal Dihapus");
            }
        } else {
            echo base64_encode("3|NIK Tidak Teraftar");
        }
    } else {
        echo base64_encode("90|Fungsi Tidak Terdeteksi");
    }
} else {
    echo base64_encode("0|Format Salah");
}

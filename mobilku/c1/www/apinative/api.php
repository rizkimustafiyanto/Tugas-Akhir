<?php
include 'config.php';
if (isset($_REQUEST["fungsi"])) {
    $fungsi = $_REQUEST["fungsi"];
    if ($fungsi == "tambahdata") {
        $nik = $_REQUEST["nik"];
        $nama = $_REQUEST["nama"];
        $jk = $_REQUEST["jk"];
        $password = $_REQUEST["password"];
        $result = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM users");
        $row = mysqli_fetch_assoc($result);
        $count = $row['jumlah'];
        $no = (int)$count + 1;
        $sql = "SELECT * FROM users WHERE nik = '$nik'";
        $q = mysqli_query($koneksi, $sql);
        if (mysqli_num_rows($q) == 0) {
            $sql = "INSERT INTO users (id, nik, nama, jenis_kelamin, password, level) VALUES ('$no', '$nik', '$nama', '$jk', '$password', '0')";
            $ff = mysqli_query($koneksi, $sql);
            if ($ff) {
                echo base64_encode("1|Berhasil Ditambahkan");
            } else {
                echo base64_encode("2|Gagal Ditambahkan");
            }
        } else {
            echo base64_encode("3|NIK Telah Teraftar");
        }
    } else if ($fungsi == "filterdata") {
        if (!isset($_REQUEST["nik"])) {
            echo base64_encode("0|Format Filter Data Salah");
            exit;
        }
        $nik = $_REQUEST["nik"];
        $sql = "SELECT * FROM users WHERE nik = '$nik'";
        $x = mysqli_query($koneksi, $sql);
        $data = array();
        while ($r = mysqli_fetch_object($x)) {
            $data[] = $r;
        }
        echo json_encode($data);
    } else if ($fungsi == "bacadata") {
        $sql = "SELECT * FROM users ORDER BY id ASC";
        $x = mysqli_query($koneksi, $sql);
        $data = array();
        while ($r = mysqli_fetch_object($x)) {
            $data[] = $r;
        }
        echo json_encode($data);
    } else if ($fungsi == "ubahdata") {
        if (!isset($_REQUEST["nik"]) || !isset($_REQUEST["nama"]) || !isset($_REQUEST["jk"])) {
            echo base64_encode("0|Format Ubah Data Salah");
            exit;
        }
        $nik = $_REQUEST["nik"];
        $nama = $_REQUEST["nama"];
        $jk = $_REQUEST["jk"];
        $password = $_REQUEST["password"];
        $sql = "SELECT * FROM users WHERE nik = '$nik'";
        $q = mysqli_query($koneksi, $sql);
        if (mysqli_num_rows($q) > 0) {
            $sql = "UPDATE users SET nama='$nama', jenis_kelamin='$jk', password='$password' WHERE nik = '$nik'";
            $ff = mysqli_query($koneksi, $sql);
            if ($ff) {
                echo base64_encode("1|Berhasil Diupdate");
            } else {
                echo base64_encode("2|Gagal Diupdate");
            }
        } else {
            echo base64_encode("3|NIK Tidak Teraftar");
        }
    } else if ($fungsi == "hapusdata") {
        if (!isset($_REQUEST["nik"])) {
            echo base64_encode("0|Data NIK Salah");
            exit;
        }
        $nik = $_REQUEST["nik"];
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

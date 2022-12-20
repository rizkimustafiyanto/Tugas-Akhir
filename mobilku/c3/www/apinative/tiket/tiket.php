<?php
include '../config.php';
if (isset($_REQUEST["fungsi"])) {
    $fungsi = $_REQUEST["fungsi"];
    if ($fungsi == "filterdata") {
        if (!isset($_REQUEST["id_poli"])) {
            echo base64_encode("0|Format Filter Data Salah");
            exit;
        }
        $id_poli = $_REQUEST["id_poli"];
        $sql = "SELECT * FROM poli WHERE id_poli = '$id_poli'";
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
    } else if ($fungsi == "ubahdata") {
        $nik = $_REQUEST["nik"];
        $password = $_REQUEST["password"];
        $id_poli = $_REQUEST["id_poli"];


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
            echo base64_encode("0|Password Salah");
            exit;
        }
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d");
        function manipulasiTanggal($waktu, $jumlah = 1, $format = 'days')
        {
            $currentDate = $waktu;
            return date('Y-m-d H:i:s', strtotime($jumlah . ' ' . $format, strtotime($currentDate)));
        }
        function manipulasiWaktu($wak, $jumlah = 1, $format = 'days')
        {
            $currentDate = $wak;
            return date('Y-m-d', strtotime($jumlah . ' ' . $format, strtotime($currentDate)));
        }
        $waktu = date("Y-m-d H:i:s");
        $wak = date("Y-m-d");
        $bookday = manipulasiTanggal($waktu, '1', 'days');
        $lineday = manipulasiWaktu($wak, '1', 'days');
        $status = "Belum";

        $batasjam = date("H:i:s");
        //Untuk Batas Ambil Tiket
        $btiket = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM antrian WHERE id_users != 0 AND waktu LIKE '$lineday%'");
        $rowtiket = mysqli_fetch_assoc($btiket);
        $batastiket = $rowtiket['jumlah'];

        if ($batastiket >= 3 && ($batasjam >= 00.00 && $batasjam <= 23.20)) {
            echo base64_encode("0|Tiket Habis Atau Sudah Tutup Silahkan Pilih Poli Lain");
            exit;
        }

        $poli = mysqli_query($koneksi, "SELECT loket,nama AS nam_pol FROM poli WHERE id_poli = '$id_poli'");
        if (mysqli_num_rows($poli) > 0) {
            while ($row = mysqli_fetch_assoc($poli)) {
                $huruf = $row["loket"];
                $nam_pol = $row["nam_pol"];
            }
        } else {
            echo "0 results";
        }
        $queryp = mysqli_query($koneksi, "SELECT max(no_antrian) as no_antrianTerbesar FROM antrian WHERE no_antrian LIKE '$huruf%' AND waktu LIKE '$lineday%'");
        $datapoli = mysqli_fetch_array($queryp);
        $no_antrianpoli = $datapoli['no_antrianTerbesar'];
        // mengambil angka dari no_antrian barang terbesar, menggunakan fungsi substr
        // dan diubah ke integer dengan (int)
        $urutan = (int) substr($no_antrianpoli, 1, 3);
        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
        $urutan++;

        // membentuk no_antrian barang baru
        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan no_antrian huruf yang kita inginkan, misalnya BRG 
        // Final Nomer Tiket
        $no_antrianpoli = $huruf . sprintf("%03s", $urutan);
        //ambil tanggal sekarang + 1

        //Eksekusi Tiket
        $sql = "SELECT * FROM antrian WHERE id_users = '$id_users' AND waktu LIKE '$lineday%'";
        $q = mysqli_query($koneksi, $sql);
        if (mysqli_num_rows($q) == 0) {
            $sql = "INSERT INTO antrian ( no_antrian, waktu, status, id_poli, id_users) VALUES ('$no_antrianpoli', '$bookday', '$status', '$id_poli', '$id_users')";
            $ff = mysqli_query($koneksi, $sql);
            if ($ff) {
                echo base64_encode("1|Berhasil Mendaftar");
            } else {
                echo base64_encode("2|Gagal Mendaftar");
            }
        } else {
            echo base64_encode("3|Anda Telah Teraftar Antrian");
        }
    } else if ($fungsi == "hapusdata") {
    } else {
        echo base64_encode("90|Fungsi Tidak Terdeteksi");
    }
} else {
    echo base64_encode("0|Format Salah");
}

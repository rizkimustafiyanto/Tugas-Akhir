<?php
session_start();
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT COUNT(*) as jumlah FROM jadwal_dok");
$row = mysqli_fetch_assoc($result);
$count = $row['jumlah'];
$no = (int)$count + 1;

$jadwal_dokter = $_POST['jadwal_dokter'];
$id_dokter = $_POST['id_dokter'];
$id_poli = $_POST['id_poli'];

$query = mysqli_query($connection, "INSERT INTO jadwal_dok(id, jadwal_dokter, id_dokter, id_poli) value('$no', '$jadwal_dokter', '$id_dokter', '$id_poli')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}

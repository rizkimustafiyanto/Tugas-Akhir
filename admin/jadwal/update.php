<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id'];
$jadwal_dokter = $_POST['jadwal_dokter'];
$id_dokter = $_POST['id_dokter'];
$id_poli = $_POST['id_poli'];

$query = mysqli_query($connection, "UPDATE jadwal_dok SET jadwal_dokter = '$jadwal_dokter', id_dokter = '$id_dokter', id_poli = '$id_poli' WHERE id = '$id'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}

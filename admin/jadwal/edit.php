<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM jadwal_dok WHERE id='$id'");
$dokter = mysqli_query($connection, "SELECT * FROM dokter");
$poli = mysqli_query($connection, "SELECT * FROM poli");
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Data Jadwal</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- // Form -->
                    <form action="./update.php" method="post">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <table cellpadding="8" class="w-100">
                                <tr>
                                    <td>Jadwal</td>
                                    <td><input class="form-control" type="date" name="jadwal_dok" size="20" onkeypress="InputWord(event)" required value="<?= $row['jadwal_dok'] ?>"></td>
                                </tr>
                                <tr>
                                    <td>Dokter</td>
                                    <td>
                                        <select class="form-control" name="id_dokter" id="id_dokter" required>
                                            <option value="">--Pilih Dokter--</option>
                                            <?php
                                            while ($r = mysqli_fetch_array($dokter)) :
                                            ?>
                                                <option value="<?= $r['id_dokter'] ?>"><?= $r['nama'] ?></option>
                                            <?php
                                            endwhile;
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poli</td>
                                    <td>
                                        <select class="form-control" name="id_poli" id="id_poli" required>
                                            <option value="">--Pilih Poli--</option>
                                            <?php
                                            while ($r = mysqli_fetch_array($poli)) :
                                            ?>
                                                <option value="<?= $r['id_poli'] ?>"><?= $r['nama'] ?></option>
                                            <?php
                                            endwhile;
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                                        <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                                    <td>
                                </tr>
                            </table>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
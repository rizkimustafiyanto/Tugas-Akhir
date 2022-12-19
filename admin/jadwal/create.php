<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah Jadwal Dokter</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- // Form -->
                    <form action="./store.php" method="POST">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td>Nama Dokter</td>
                                <td><input class="form-control" type="date" name="jadwal_dokter" size="20" onkeypress="InputWord(event)" required></td>
                            </tr>
                            <tr>
                                <td>Nama Dokter</td>
                                <td>
                                    <select class="form-control" name="id_dokter" id="id_dokter" required>
                                        <option value="<?= $row['id_dokter'] ?>">Jika tidak diubah biarkan</option>
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
                                <td>Nama Poli</td>
                                <td>
                                    <select class="form-control" name="id_poli" id="id_poli" required>
                                        <option value="<?= $row['id_poli'] ?>">Jika tidak diubah biarkan</option>
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
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                                    <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
                                </td>
                            </tr>


                        </table>
                    </form>
                </div>
            </div>
        </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
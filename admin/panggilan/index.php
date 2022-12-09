<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
$query = mysqli_query($connection, 'SELECT * FROM poli ORDER BY loket ASC');
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Antrian Poli</h1>
    </div>

    <!-- Daftar Poli -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($data = mysqli_fetch_array($query)) {
            $poli = $data['nama'];
            $loket = $data['loket'];
            $id_poli = $data['id_poli'];
        ?>
            <div class="col text-center">
                <div class="card text-center" style="max-width: 18rem;max-height:15rem;">
                    <a href="panggilan.php?id=<?= $id_poli ?>&poli=<?= $poli; ?>&loket=<?= $loket; ?>" style="text-decoration:none;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: black;">Loket <?= $loket; ?></h5>
                            <h6 class="card-text" style="color: black;"><?= $poli; ?></h6>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<!-- akhir layout -->
<?php require_once '../layout/_bottom.php'; ?>
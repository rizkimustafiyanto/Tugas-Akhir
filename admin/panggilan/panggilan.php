<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
$id_poli = $_GET['id'];
$poli = $_GET['poli'];
$loket = $_GET['loket'];

$sql = "SELECT *, MIN(no_antrian) AS antrian, COUNT(no_antrian) AS sisa_antrian FROM antrian WHERE STATUS = 'Belum' AND no_antrian 
                LIKE '%$loket%' AND id_poli = '$id_poli' LIMIT 1";
$query = mysqli_query($connection, $sql);
$data = mysqli_fetch_array($query);
$antrian_belum = $data['antrian'];

$sql2 = "SELECT no_antrian, status, MIN(no_antrian) AS antrian_panggil FROM antrian WHERE STATUS = 'Dilayani' AND id_poli = '$id_poli' LIMIT 1";
$query2 = mysqli_query($connection, $sql2);
$data2 = mysqli_fetch_array($query2);
$antrian_dilayani = $data2['antrian_panggil'];

?>

<section class="section" data-id="<?= $id_poli ?>" data-loket="<?= $loket ?>" data-poli="<?= $poli; ?>" data-nomor_belum="<?= $antrian_belum; ?>">
    <div class="section-header d-flex justify-content-between">
        <input type="hidden" name="id_poli" id="id_poli" value="<?= $id_poli ?>">
        <h2 id="poli" data-poli="<?= $poli ?>"><?= $poli ?></h2>
        <div style="margin: 0 auto;">
            <button class="btn btn-success mr-5" onclick="bukaPoli()">Buka</button>
            <button class="btn btn-danger" onclick="tutupPoli()">Tutup</button>
        </div>
        <a href="index.php" class="btn btn-danger">Kembali</a>
    </div>
    <div class="container-fluid">
        <div style="display: none;">
            <input type="text" id="tmpe">
        </div>
        <div class="jam" id="jam" style="display: none;"></div>
        <div class="row">
            <div class="col-6">
                <div class="container-antrian-selanjutnya shadow p-3 mb-5 rounded">
                    <div class="bg-title-selanjutnya">
                        <h1>Antrian Selanjutnya</h1>
                    </div>
                    <div class="box-nomor-selanjutnya">
                        <h2 id="nomor-antrian-selanjutnya"></h2>
                    </div>
                    <div class="bg-sisa-antrian">
                        <h2 id="sisa"></h2>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="container-panggil-antrian shadow p-3 mb-5 rounded">
                    <div class="bg-title-panggilan">
                        <h1>PANGGILAN</h1>
                    </div>
                    <div class="box-nomor ">
                        <h2 id="nomor-panggilan"></h2>
                    </div>
                    <div class="button-panggilan">
                        <div class="button-panggilan1"></div>
                        <div class="button-panggilan2" id="lewah"></div>
                        <div class="button-panggilan3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal untuk pop up -->
<div id="myModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Peringatan !!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Waktu tunggu telah habis silahkan klik lewati</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="modalcl()">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- akhir pop up -->

<!-- audio -->
<audio id="bel">
    <source src="audio/bel.mp3" type="audio/mpeg">
</audio>

<audio id="perhatian">
    <source src="audio/Perhatian.m4a" type="audio/x-m4a">
</audio>

<audio id="huruf">
    <source src="audio/<?= substr($antrian_dilayani, 0, 1); ?>.m4a" type="audio/x-m4a">
</audio>

<audio id="audio1">
    <source src="audio/<?= substr($antrian_dilayani, 1, 1); ?>.m4a" type="audio/x-m4a">
</audio>
<audio id="audio2">
    <source src="audio/<?= substr($antrian_dilayani, 2, 1); ?>.m4a" type="audio/x-m4a">
</audio>
<audio id="audio3">
    <source src="audio/<?= substr($antrian_dilayani, 3, 1); ?>.m4a" type="audio/x-m4a">
</audio>

<audio id="tujuan">
    <source src="audio/Tujuan.m4a" type="audio/x-m4a">
</audio>

<audio id="loket">
    <source src="audio/<?= $loket ?>.m4a" type="audio/x-m4a">
</audio>

<audio id="Pdua">
    <source src="audio/Pdua.mp3" type="audio/mpeg">
</audio>

<audio id="Ptiga">
    <source src="audio/Ptiga.mp3" type="audio/mpeg">
</audio>

<script src="../../assets/js/jquery-3.6.0.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-database.js"></script>
<script src="sweetalert/sweetalert2.min.js"></script>
<script>
    // atribut
    var id = $('section').data('id');
    var loket = $('section').data('loket');
    var poli = $('section').data('poli');
    var nomor_selanjutnya = $('section').data('nomor_belum');

    // nomor antrian yg belum
    function getJson() {
        let url = 'http://localhost/antrian/admin/panggilan/getJson.php?id=' + id + '&loket=' + loket;
        $.getJSON(url, function(hasil) {
            let data = hasil.data;
            let nomor_belum = '';
            let sisa_antrian_belum = '';
            data.forEach(kolom => {
                let antrian_belum = kolom.antrian;
                let sisa_belum = kolom.sisa_antrian;
                nomor_belum += antrian_belum;
                sisa_antrian_belum = sisa_belum;
            });

            $('#nomor-antrian-selanjutnya').html(nomor_belum);
            $('#sisa').html("Sisa Antrian : " + sisa_antrian_belum);
        });
    }
    setInterval(getJson(), 1000);

    function getJson2() {
        url = 'http://localhost/antrian/admin/panggilan/getJson2.php?id=' + id;
        $.getJSON(url, function(hasil) {
            let data = hasil.data
            data.forEach(kolom => {
                var nomor_dilayani = kolom.nomor_dilayani;
                var status_poli = kolom.status_poli;
                $('#nomor-panggilan').html(nomor_dilayani);
                if (status_poli == 2) {
                    $('.button-panggilan1').html("<button class='btn btn-warning disabled' onclick='tutupPoli()'>Panggil</button>");
                    $('.button-panggilan2').html("<button class='disabled' onclick='tutupPoli()'>Lewati</button>");
                    $('.button-panggilan3').html("<button class='disabled' onclick='tutupPoli()'>Selesai</button>");
                } else {
                    $('.button-panggilan1').html("<button class='btn btn-warning' onclick='panggil()'>Panggil</button>");
                    $('.button-panggilan2').html("<button data-nomor='" + nomor_dilayani + "' onclick='lewati(this)'>Lewati</button>");
                    $('.button-panggilan3').html("<button class='' data-nomor='" + nomor_dilayani + "' onclick='selesai(this)'>Selesai</button>");
                }
            });
        });
    }
    setInterval(getJson2(), 1000);

    function dilayani() {
        let nomor_belum = $('section').data('nomor_belum');
        $.ajax({
            url: 'dilayani.php',
            type: 'POST',
            data: {
                nomor: nomor_belum
            },
            cache: false,
            success: (data) => {
                console.log(data);
            }
        })
    }

    function lewati(el) {
        let nomor_dilayani = $(el).data('nomor');
        $.ajax({
            url: 'lewati.php',
            type: 'POST',
            data: {
                nomor: nomor_dilayani
            },
            cache: false,
            success: (data) => {
                location.reload(true);
                console.log(data);
            },
        });

        dilayani();
    }

    function hapususer(el) {
        let nomor_dilayani = $(el).data('nomor');
        $.ajax({
            url: 'hapususer.php',
            type: 'POST',
            data: {
                nomor: nomor_dilayani
            },
            cache: false,
            success: (data) => {
                location.reload(true);
                console.log(data);
            },
        });

        dilayani();
    }

    function selesai(el) {
        dilayani()
        let nomor_dilayani = $(el).data('nomor');
        $.ajax({
            url: 'selesai.php',
            type: 'POST',
            data: {
                nomor: nomor_dilayani
            },
            cache: false,
            success: (data) => {
                location.reload(true);
            }
        });
    }


    function bukaPoli() {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'POLI ' + poli + ' DIBUKA!',
            showConfirmButton: false,
            timer: 1000
        });

        $.ajax({
            url: 'bukapoli.php',
            type: 'POST',
            data: {
                id_poli: id,
            },
            cache: false,
            success: (data) => {
                setTimeout(() => {
                    location.reload(true)
                }, 1100);
            }
        });

        db.ref('antrian_dilayani/' + id).set({
            loket: loket,
            nama_poli: poli,
            nomor_dilayani: '---',
            status: 'Sedang Beroperasi'
        });
    }


    function tutupPoli() {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'POLI ' + poli + ' DITUTUP!',
            showConfirmButton: false,
            timer: 1000
        });

        $.ajax({
            url: 'editoperate.php',
            type: 'POST',
            data: {
                id_poli: id,
            },
            cache: false,
            success: (data) => {
                setTimeout(() => {
                    location.reload(true)
                }, 1100);
            }
        });

        db.ref('antrian_dilayani/' + id).set({
            loket: loket,
            nama_poli: poli,
            nomor_dilayani: '---',
            status: 'Tidak Beroperasi'
        });
    }

    /*
        menghubungkan firebase untuk menampilkan informasi 
        antrian dilayani saat ini LCD sama Mobile
    */
    const firebaseConfig = {
        apiKey: "AIzaSyD7ZByCdIRx7B_lIwYGcX4J9NG9_PkxxL0",
        authDomain: "siantri.firebaseapp.com",
        databaseURL: "https://siantri-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "siantri",
        storageBucket: "siantri.appspot.com",
        messagingSenderId: "106626247639",
        appId: "1:106626247639:web:e873bd63c82515d794f992",
        measurementId: "G-0KYBJYRPEQ"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    var db = firebase.database();

    // set data realtime firebase
    function sendData() {
        // waktu
        let d = new Date();
        let h = d.getHours();
        let m = d.getMinutes();
        let menit = m > 9 ? m : '0' + m;
        let jam = h > 9 ? h : '0' + h;
        let waktu = jam + ' : ' + menit;

        let nomor_dilayani = $('.button-panggilan2 button').data('nomor');

        db.ref('antrian_dilayani/' + id).set({
            loket: loket,
            nama_poli: poli,
            nomor_dilayani: nomor_dilayani,
            waktu_dilayani: waktu,
            nomor_selanjutnya: nomor_selanjutnya,
            status: 'Sedang Melayani'
        });
    }


    function panggil() {
        //suara panggilan
        let bel = document.getElementById('bel');
        let perhatian = document.getElementById('perhatian');
        let audio_huruf = document.getElementById('huruf');
        let audio_1 = document.getElementById('audio1');
        let audio_2 = document.getElementById('audio2');
        let audio_3 = document.getElementById('audio3');
        let audio_tujuan = document.getElementById('tujuan');
        let audio_loket = document.getElementById('loket');
        let Pdua = document.getElementById('Pdua');
        let Ptiga = document.getElementById('Ptiga');

        // bel.play();
        // setTimeout(() => {
        //     perhatian.play()
        // }, 8100);
        // setTimeout(() => {
        //     audio_huruf.play()
        // }, 10000);
        // setTimeout(() => {
        //     audio_1.play()
        // }, 11000);
        // setTimeout(() => {
        //     audio_2.play()
        // }, 11900);
        // setTimeout(() => {
        //     audio_3.play()
        // }, 12900);
        // setTimeout(() => {
        //     audio_tujuan.play()
        // }, 13500);
        // setTimeout(() => {
        //     audio_loket.play()
        // }, 15500);

        //buat jumlah klik
        var n, b;
        n = document.getElementById("tmpe");
        b = n.value;
        if (b == "1") {
            n.setAttribute('value', "2");
            bel.play();
            setTimeout(() => {
                Pdua.play()
            }, 8100);
            setTimeout(() => {
                perhatian.play()
            }, 10100);
            setTimeout(() => {
                audio_huruf.play()
            }, 12000);
            setTimeout(() => {
                audio_1.play()
            }, 13900);
            setTimeout(() => {
                audio_2.play()
            }, 14900);
            setTimeout(() => {
                audio_3.play()
            }, 15500);
            setTimeout(() => {
                audio_tujuan.play()
            }, 16500);
            setTimeout(() => {
                audio_loket.play()
            }, 18500);
            sendData();
            showPanggilan();
        } else if (b == "2") {
            bel.play();
            setTimeout(() => {
                Ptiga.play()
            }, 8100);
            setTimeout(() => {
                perhatian.play()
            }, 10100);
            setTimeout(() => {
                audio_huruf.play()
            }, 12000);
            setTimeout(() => {
                audio_1.play()
            }, 13900);
            setTimeout(() => {
                audio_2.play()
            }, 14900);
            setTimeout(() => {
                audio_3.play()
            }, 15500);
            setTimeout(() => {
                audio_tujuan.play()
            }, 16500);
            setTimeout(() => {
                audio_loket.play()
            }, 18500);
            sendData();
            showPanggilan();
            n.setAttribute('value', "3");
            jamkel();
            startTimer();
        } else {
            bel.play();
            setTimeout(() => {
                perhatian.play()
            }, 8100);
            setTimeout(() => {
                audio_huruf.play()
            }, 10000);
            setTimeout(() => {
                audio_1.play()
            }, 11000);
            setTimeout(() => {
                audio_2.play()
            }, 11900);
            setTimeout(() => {
                audio_3.play()
            }, 12900);
            setTimeout(() => {
                audio_tujuan.play()
            }, 13500);
            setTimeout(() => {
                audio_loket.play()
            }, 15500);
            sendData();
            showPanggilan();
            n.setAttribute('value', "1");
        }
    }

    function showPanggilan() {
        let nomor_dilayani = $('.button-panggilan2 button').data('nomor');
        db.ref('panggilan').set({
            loket: loket,
            nomor: nomor_dilayani,
            poli: poli,
            status: 'Sedang Melayani'
        })
    }
    //untuk pop up modal
    function modalcl() {
        $(document).ready(function() {
            $("#myModal").modal('toggle');
        });
        jammas();
    }

    //untuk format jam
    function jamkel() {
        $(document).ready(function() {
            $("#jam").show();
        });
    }

    function jammas() {
        $(document).ready(function() {
            $("#jam").hide();
        });
    }
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 10;
    const ALERT_THRESHOLD = 5;

    const COLOR_CODES = {
        info: {
            color: "green"
        },
        warning: {
            color: "orange",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "red",
            threshold: ALERT_THRESHOLD
        }
    };

    const TIME_LIMIT = 10;
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;

    document.getElementById("jam").innerHTML = '<div class="base-timer"><svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><g class="base-timer__circle"> <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle> <path id="base-timer-path-remaining" stroke-dasharray="283" class="base-timer__path-remaining ${remainingPathColor}" d="M 50, 50 m -45, 0 a 45,45 0 1,0 90,0 a 45,45 0 1,0 -90,0"></path></g></svg><span id="base-timer-label" class="base-timer__label">${formatTime(timeLeft)}</span></div>';


    function onTimesUp() {
        clearInterval(timerInterval);
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            document.getElementById("base-timer-label").innerHTML = formatTime(
                timeLeft
            );
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            if (timeLeft === 0) {
                onTimesUp();
                $(document).ready(function() {
                    $("#myModal").modal('show');
                });
            }
        }, 1000);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        return `${minutes}:${seconds}`;
    }

    function setRemainingPathColor(timeLeft) {
        const {
            alert,
            warning,
            info
        } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(warning.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(alert.color);
        } else if (timeLeft <= warning.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(info.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(warning.color);
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY).toFixed(0)} 283`;
        document.getElementById("base-timer-path-remaining").setAttribute("stroke-dasharray", circleDasharray);
    }

    //Auto hidden value tiket
</script>

<!-- akhir layout -->
<?php require_once '../layout/_bottom.php'; ?>
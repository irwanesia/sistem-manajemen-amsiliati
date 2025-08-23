<!-- table kriteria -->
<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-between">
            <div class="col-3 text-center">
                <img src="assets/images/logo.png" width="150" alt="">
            </div>
            <div class="col-9 text-center">
                <h3>UPTD SDN MEKARJAYA 17 <br>KELURAHAN ABADI JAYA <br>
                <b>KOTA DEPOK</b></h3>
                <p>Alamat : Jl. Kahayan Raya Ujung No. 01, Depok II Timur, Kelurahan Abadi Jaya, Kecamatan Sukmajaya, Kota Depok, Jawa Barat, 16417</p>
            </div>
        </div>
    </div>
    <hr style="border: 2px solid #333;">
</div>

<div class="row">
    <div class="col-md-12 mt-2">
        <!-- --------------- konten -------------  -->
        <h5 class="text-center ">Kriteria Penilaian Siswa</h5>
        <!-- </p> -->
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th> No </th>
                        <th> Kode </th>
                        <th> Kriteria </th>
                        <th> Type </th>
                        <th> Bobot </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ranking = 1;
                    foreach (get_kriteria() as $row): ?>
                        <tr>
                            <td class=" text-center"><?= $no++ ?></td>
                            <td class=" text-center"><?= $row['kode'] ?></td>
                            <td class=" text-center"><?= $row['nama_kriteria'] ?></td>
                            <td class=" text-center"><?= $row['type'] ?></td>
                            <td class=" text-center"><?= $row['bobot'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row float-end mt-3" style="width: 300px;">
    <div class="col-md-12 text-center">
        <p>Kepala UPTD SDN Mekarjaya 17</p>
        <p>Depok, <?= date("d F Y") ?></p>
        <p style="margin-bottom: -5px; margin-top: 150px"><u>Retno Damayanti, M.Pd.</u></p>
        <p>NIP. 197711182009022001</p>
    </div>
</div>

<script>
    window.onload = function() {
        window.print(); // Memanggil dialog print
        window.onafterprint = function() {
            window.history.back(); // Kembali ke halaman sebelumnya setelah print
        }
    }
</script>
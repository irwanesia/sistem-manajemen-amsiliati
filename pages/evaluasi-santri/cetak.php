<!-- table kriteria -->
<div class="row">
    <div class="col-md-12 mt-2">
        <!-- --------------- konten -------------  -->
        <h4 class="text-center ">Hasil perangkingan berdasarkan perhitungan <br>Sistem Pendukung Keputusan (SPK) menggunakan metode Simple Additive Weight (SAW)</h4>
        </p>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th> NO </th>
                        <th> Nama Alternatif </th>
                        <th> Nilai Preferensi </th>
                        <th> Rangking </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ranking = 1;
                    foreach (get_rangking() as $rank): ?>
                        <tr>
                            <td class=" text-center"><?= $no++ ?></td>
                            <td class=" text-center"><?= $rank['nama_alternatif'] ?></td>
                            <td class=" text-center"><?= format_decimal($rank['nilai_preferensi']) ?></td>
                            <td class=" text-center"><?= $ranking++ ?></td>
                            <td class=" text-center">
                                <?= ($rank['nilai_preferensi'] <= 0.95) ? 'Tidak Terpilih' : 'Terpilih' ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-5 ">
        <p>Jakarta, <?= date("d-M-Y") ?></p>
        <br>
        <p class="mt-5"><u>Nama Anda</u></p>
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
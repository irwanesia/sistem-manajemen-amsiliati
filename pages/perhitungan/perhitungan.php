<!-- table kriteria -->
<!-- bobot -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Bobot kriteria (W)</h4>
        </p>
        <div class="table-responsive">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> # </th>
                <?php foreach (get_kriteria() as $kode) : ?>
                  <th> <?= $kode['kode'] ?> </th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Bobot</td>
                <?php foreach (get_kriteria() as $bobot) : ?>
                  <td> <?= $bobot['bobot'] ?> </td>
                <?php endforeach ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- matrik keputusan -->
<div class="row mt-1">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Matrik Keputusan (X)</h4>
        </p>
        <div class="table-responsive">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama Alternatif </th>
                <?php foreach (get_kriteria() as $kode) : ?>
                  <th> <?= $kode['kode'] ?> </th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_alternatif() as $alternatif) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $alternatif['nama_alternatif'] ?></td>
                  <?php foreach (get_kriteria() as $kriteria) : ?>
                    <td><?= get_nilai_matriks($alternatif['id'], $kriteria['id']) ?></td>
                  <?php endforeach ?>
                </tr>
              <?php endforeach ?>
              <tr>
                <td colspan="2" align="center"><i>Nilai Max</i></td>
                <?php foreach (get_kriteria() as $max) : ?>
                  <td><b><?= get_max($max['id']) ?></b></td>
                <?php endforeach ?>
              </tr>
              <tr>
                <td colspan="2" align="center"><i>Nilai Min</i></td>
                <?php foreach (get_kriteria() as $min) : ?>
                  <td><b><?= get_min($min['id']) ?></b></td>
                <?php endforeach ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- matrik normalisasi -->
<div class="row mt-1">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Matrik Normalisasi (R)</h4>
        </p>
        <div class="table-responsive">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th rowspan="2"> No </th>
                <th rowspan="2"> Nama Alternatif </th>
                <?php
                $no = 1;
                foreach (get_kriteria() as $r) : ?>
                  <th> R<?= $no++ ?> </th>
                <?php endforeach ?>
              </tr>
              <tr>
                <?php foreach (get_kriteria() as $type) :
                  $tp = ($type['type'] == 'Benefit') ? 'Benefit' : 'Cost';
                  $txt = ($type['type'] == 'Benefit') ? 'text-warning' : 'text-info';
                ?>
                  <th class="<?= $txt ?>"><small><i><?= $tp ?></i></small> </th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_alternatif() as $alternatif) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $alternatif['nama_alternatif'] ?></td>
                  <?php foreach (get_kriteria() as $kriteria) : ?>
                    <td><?= format_decimal(get_normalisasi($alternatif['id'], $kriteria['id'])) ?></td>
                  <?php endforeach ?>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- menghitung nilai preferensi -->
<div class="row mt-1">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nilai Preferensi (V)</h4>
        </p>
        <div class="table-responsive">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama Alternatif </th>
                <?php
                $no = 1;
                foreach (get_kriteria() as $r) : ?>
                  <th> V<?= $no++ ?> </th>
                <?php endforeach ?>
                <td class="font-bold">Nilai</td>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_alternatif() as $alternatif) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $alternatif['nama_alternatif'] ?></td>
                  <?php
                  foreach (get_kriteria() as $kriteria) :
                    if (get_normalisasi($alternatif['id'], $kriteria['id']) != "-") : ?>
                      <td><?= format_decimal(get_normalisasi($alternatif['id'], $kriteria['id']) * $kriteria['bobot']) ?></td>
                    <?php else : ?>
                      <td>-</td>
                    <?php endif ?>
                  <?php endforeach ?>
                  <td class="font-bold">
                    <?= format_decimal(get_nilai_preferensi($alternatif['id'])) ?>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
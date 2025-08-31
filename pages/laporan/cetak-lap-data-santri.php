<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Peserta ASPI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .container {
                width: 100%;
                max-width: none;
            }
            .no-print {
                display: none !important;
            }
            .header-section {
                border-bottom: 2px solid #000;
                padding-bottom: 15px;
                margin-bottom: 20px;
            }
        }
        @media screen {
            .container {
                max-width: 1200px;
            }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 10px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #0062cc 0%, #0095ff 100%);
            color: white;
            border-radius: 10px;
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .header-subtitle {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header-address {
            font-size: 16px;
        }
        .document-title {
            text-align: center;
            font-weight: bold;
            margin: 25px 0;
            font-size: 20px;
            color: #0062cc;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
        }
        .table th {
            background-color: #0062cc;
            color: white;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tr:hover {
            background-color: #e9ecef;
        }
        .signature-section {
            margin-top: 50px;
            text-align: right;
        }
        .signature-date {
            margin-bottom: 50px;
        }
        .btn-print {
            margin-bottom: 20px;
            margin-right: 10px;
        }
        .alert-box {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            animation: fadeIn 0.5s, fadeOut 0.5s 2.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Tombol Kembali (hanya tampil di layar) -->
        <div class="no-print text-end mb-3">
            <button onclick="goBack()" class="btn btn-secondary btn-print">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </button>
            <button onclick="window.print()" class="btn btn-primary btn-print">
                <i class="bi bi-printer"></i> Cetak Dokumen
            </button>
            <button onclick="showAlert('Fitur download akan segera tersedia')" class="btn btn-success btn-print">
                <i class="bi bi-download"></i> Download PDF
            </button>
        </div>

        <!-- Kop Surat -->
        <div class="header-section">
            <div class="header-title">MA'HAD ALY PONDOK PESANTREN SALAFIAH SYAFI'IYAH SUKOREJO SITUBONDO</div>
            <div class="header-subtitle">Manajemen Amsiliati</div>
            <div class="header-address">Jl. KHR. Syamsul Arifin Sukorejo, Sumberejo, Banyuputih, Situbondo | Telp: (0338) 562666</div>
        </div>

        <!-- Judul Dokumen -->
        <div class="document-title">
            DATA SANTRI
        </div>

        <!-- Tabel Hasil -->
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                    <th> No </th>
                    <th> NIS </th>
                    <th> Nama Lengkap </th>
                    <th> Jenis Kelamin </th>
                    <th> Tanggal Lahir </th>
                    <th> Alamat </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach (get_santri() as $row) : ?>
                    <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nis'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    <td><?= $row['tanggal_lahir'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- Bagian Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-date">Situbondo, <?= tanggalIndonesia(date("d F Y")) ?></div>
            <div style="margin-top: -50px;">Panitia Audisi Santri Berprestasi (ASPI),</div>
            <br><br><br><br>
            <div><u>Sukandi Arifin M.H.I.,</u></div>
            <div>NIP. 19701231 xxxxx x xxx</div>
        </div>
    </div>

    <script>
        // Fungsi untuk kembali ke halaman sebelumnya
        function goBack() {
            window.history.back();
        }

        // Fungsi untuk menampilkan alert
        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-info alert-box';
            alertDiv.innerHTML = `
                <i class="bi bi-info-circle"></i> ${message}
            `;
            document.body.appendChild(alertDiv);
            
            // Hapus alert setelah 3 detik
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Mencetak otomatis saat halaman dimuat dan kembali setelah mencetak
        window.onload = function() {
            // Jika parameter print ada di URL, lakukan pencetakan
            if (window.location.search.includes('print=true')) {
                window.print();
            }
        };

        // Setelah mencetak, kembali ke halaman sebelumnya
        window.onafterprint = function() {
            // Kembali ke halaman sebelumnya setelah mencetak
            setTimeout(function() {
                window.history.back();
            }, 500);
        };
    </script>
</body>
</html>

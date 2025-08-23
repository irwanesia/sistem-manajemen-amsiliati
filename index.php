<?php
session_start(); // Pastikan session selalu dimulai di bagian paling awal

// Cek apakah session user_id sudah di-set atau belum
if (!isset($_SESSION["logged_in"])) {
  // Jika user belum login, redirect ke halaman login
  header("Location: login.php?message=Silakan login terlebih dahulu");
  exit;
}

require_once "helpers/functions_helper.php";
// $user_role = get_role();

// Ambil halaman dari query string atau default ke dashboard
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Cek apakah ada action, jika tidak ada, set default ke halaman index dari page
$action = isset($_GET['action']) ? $_GET['action'] : $page;

// set sub title
$subtitle = switch_case($page, $action);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $subtitle ?></title>

  <link rel="stylesheet" href="assets/css/main/app.css">
  <link rel="stylesheet" href="assets/css/main/app-dark.css">
  <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
  
  <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
  <link rel="stylesheet" href="assets/css/pages/simple-datatables.css">
  <link rel="stylesheet" href="assets/css/shared/iconly.css">
</head>

<?php if ($action == 'cetak') : ?>

  <body onload="window.print();">
    <?php
    // Bangun path file PHP yang sesuai berdasarkan nilai page dan action
    $pagePath = 'pages/hasil/cetak.php';

    // Cek apakah file tersebut ada, jika tidak ada, tampilkan halaman error atau default
    if (file_exists($pagePath)) {
      include($pagePath);
    } else {
      include('pages/error404.php'); // Buat file 404.php sebagai fallback
    }
    ?>

  </body>

</html>
<?php else : ?>

  <body>
    <div id="app">
      <!-- === sidebar === -->
      <?php include('partials/_sidebar.php'); ?>

      <div id="main">
        <!-- === header === -->
        <!-- partial:partials/_header.html -->
        <?php include('partials/_header.php') ?>

        <div class="page-content">
          <!-- === main content === -->
          <?php
          // Bangun path file PHP yang sesuai berdasarkan nilai page dan action
          $pagePath = 'pages/' . $page . '/' . $action . '.php';

          // Cek apakah file tersebut ada, jika tidak ada, tampilkan halaman error atau default
          if (file_exists($pagePath)) {
            include($pagePath);
          } else {
            include('pages/error404.php'); // Buat file 404.php sebagai fallback
          }
          ?>
        </div>
      </div>

    </div>

    <!-- Load jQuery terlebih dahulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="assets/extensions/chart.js/Chart.min.js"></script>
    <script src="assets/js/pages/ui-chartjs.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <!-- datatable -->
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/js/pages/simple-datatables.js"></script>

    <script>
      $(document).on('submit', '#import_excel_form', function(e) {
        e.preventDefault();

        let form = $(this); // ✅ Inilah definisi variabel form

        $.ajax({
          url: "import_santri.php",
          method: "POST",
          data: new FormData(this), // atau `form[0]`
          contentType: false,
          cache: false,
          processData: false,
          // dataType: 'json',
          beforeSend: function() {
            form.find('#import').attr('disabled', true).val('Importing...');
            form.find('#message').html('');
          },
          success: function(response) {
            form.find('#import').attr('disabled', false).val('Import');
            let res = JSON.parse(response);
            if (res.status === 'success') {
              form.find('#message').html('<div class="alert alert-success">' + res.message + '</div>');
              form[0].reset();
              $('#input').modal('hide');
              alert('Import berhasil!');
            } else {
              form.find('#message').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
          },
          error: function(xhr, status, error) {
            form.find('#message').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            form.find('#import').attr('disabled', false).val('Import');
          }
        });
      });
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const asramaSelect = document.getElementById('asrama');
          const kamarSelect = document.getElementById('kamar');
          const loadingElement = document.getElementById('loadingKamar');
          
          // Event listener untuk perubahan select asrama
          asramaSelect.addEventListener('change', function() {
              const selectedAsramaId = this.value;
              
              // Reset dan disable kamar select sementara
              kamarSelect.innerHTML = '<option value="" selected disabled>-- Pilih Kamar --</option>';
              kamarSelect.disabled = true;
              
              // Tampilkan loading
              if (loadingElement) loadingElement.style.display = 'block';
              
              // AJAX call untuk mengambil data kamar berdasarkan asrama
              fetch('./controllers/get_kamar.php?id_asrama=' + selectedAsramaId)
                  .then(response => {
                      // Cek status response
                      if (!response.ok) {
                          throw new Error('Network response was not ok');
                      }
                      return response.json();
                  })
                  .then(data => {
                      console.log('Data received:', data); // Debugging
                      
                      // Kosongkan dropdown kamar
                      kamarSelect.innerHTML = '<option value="" selected disabled>-- Pilih Kamar --</option>';
                      
                      // Periksa apakah response sukses dan ada data
                      if (data.success && data.data && data.data.length > 0) {
                          // Iterasi melalui setiap kamar dan tambahkan ke dropdown
                          data.data.forEach(function(kamar) {
                              const option = document.createElement('option');
                              option.value = kamar.id_kamar;
                              option.textContent = kamar.nama_kamar;
                              kamarSelect.appendChild(option);
                          });
                          
                          kamarSelect.disabled = false;
                      } else {
                          // Tambahkan opsi jika tidak ada kamar
                          const option = document.createElement('option');
                          option.value = "";
                          option.textContent = data.message || "-- Tidak ada kamar tersedia --";
                          kamarSelect.appendChild(option);
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      // Tambahkan opsi error
                      const option = document.createElement('option');
                      option.value = "";
                      option.textContent = "-- Error memuat data --";
                      kamarSelect.appendChild(option);
                  })
                  .finally(() => {
                      // Sembunyikan loading
                      if (loadingElement) loadingElement.style.display = 'none';
                  });
          });
      });
    </script>

    <script>
      // Fungsi untuk menambahkan kelas 'active' pada item menu yang sedang aktif
      function setActiveMenu() {
        // Ambil URL halaman saat ini
        const currentUrl = window.location.href;

        // Dapatkan semua elemen menu yang memiliki kelas 'sidebar-item'
        const menuItems = document.querySelectorAll('.sidebar-item');

        menuItems.forEach((item) => {
          // Ambil link dari elemen menu
          const link = item.querySelector('a');
          if (link && currentUrl.includes(link.getAttribute('href'))) {
            // Jika URL halaman saat ini sesuai dengan href dari link, tambahkan kelas 'active'
            item.classList.add('active');
          } else {
            // Jika tidak, hapus kelas 'active'
            item.classList.remove('active');
          }
        });
      }

      // Jalankan fungsi ketika halaman dimuat
      window.onload = setActiveMenu;
    </script>

    <script>
      // Grafik Progress Jilid (Menggunakan ApexCharts)
      var jilidProgressChart = new ApexCharts(
          document.querySelector("#jilid-progress-chart"),
          {
              series: [{
                  name: 'Kelulusan',
                  data: [85, 72, 90, 65, 82, 78]
              }],
              chart: {
                  type: 'bar',
                  height: 300
              },
              colors: ['#5c6bc0'],
              plotOptions: {
                  bar: {
                      borderRadius: 4,
                      horizontal: true,
                  }
              },
              dataLabels: {
                  enabled: false
              },
              xaxis: {
                  categories: ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6'],
                  title: { text: 'Persentase Kelulusan' }
              },
              tooltip: {
                  y: { formatter: function(val) { return val + '%' } }
              }
          }
      );
      jilidProgressChart.render();

      // Grafik Distribusi Santri per Asrama
      // Grafik Distribusi Asrama
      var asramaDistributionChart = new ApexCharts(
          document.querySelector("#asrama-distribution-chart"),
          {
              series: [25, 18, 15, 12, 10, 8, 7, 5],
              chart: {
                  type: 'donut',
                  height: 300
              },
              labels: ['Al-Farabi', 'Ibnu Sina', 'Ar-Razi', 'Al-Kindi', 'Al-Ghazali', 'Ibnu Rusyd', 'Al-Khawarizmi', 'Al-Biruni'],
              colors: ['#5c6bc0', '#66bb6a', '#ffa726', '#42a5f5', '#7e57c2', '#ef5350', '#26c6da', '#d4e157'],
              legend: { position: 'bottom' },
              responsive: [{
                  breakpoint: 480,
                  options: { chart: { width: 200 } }
              }]
          }
      );
      asramaDistributionChart.render();
    </script>

    <script>
          // scripts.js
          document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan elemen alert
            var alertElement = document.getElementById('alert-message');

            if (alertElement) {
              // Set timer untuk menyembunyikan alert setelah 5 detik (5000 milidetik)
              setTimeout(function() {
                alertElement.classList.add('d-none');
              }, 5000);
            }
          });
        </script>
  </body>

  </html>
<?php endif; ?>
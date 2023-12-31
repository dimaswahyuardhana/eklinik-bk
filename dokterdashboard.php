<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("koneksi.php");
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="icon" type="image/png" href="images/DB_16х16.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EKlinik</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">


    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">


    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/lib/getmdl-select.min.css">
    <link rel="stylesheet" href="css/lib/nv.d3.min.css">
    <link rel="stylesheet" href="css/application.min.css">
    <!-- endinject -->

</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header is-small-screen">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <div class="mdl-layout-spacer"></div>
            <?php
                if (isset($_SESSION['nip'])) {
                    // Jika pengguna sudah login, tampilkan tombol "Logout"
            ?>
            <div class="avatar-dropdown" id="icon">
                <span><?php echo $_SESSION['nip'] ?></span>
                <img src="images/Icon_header.png">
            </div>
            <!-- Account dropdawn-->
            <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown"
                for="icon">
                <li class="mdl-list__item mdl-list__item--two-line">
                    <span class="mdl-list__item-primary-content">
                        <span class="material-icons mdl-list__item-avatar"></span>
                        <span><?php echo $_SESSION['nip'] ?></span>
                    </span>
                </li>
                <a href="logoutdocter.php">
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                            Log out
                        </span>
                    </li>
                </a>
            </ul>
            <?php
            } else {
              // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
            ?>
            <div class="avatar-dropdown" id="icon">
                <a href="index.php?page=loginUser"><span>LOGIN</span></a>
                <img src="images/Icon_header.png">
            </div>
            <div class="avatar-dropdown" id="icon">
                <a href="index.php?page=registerUser"><span>REGISTER</span></a>
                <img src="images/Icon_header.png">
            </div>
            <?php
              }
            ?>
        </div>
    </header>

    <div class="mdl-layout__drawer">
        <header><img src="images/logo.png" width="50px" alt=""></header>
        <div class="scroll__wrapper" id="scroll__wrapper">
            <div class="scroller" id="scroller">
                <div class="scroll__container" id="scroll__container">
                    <nav class="mdl-navigation">
                        <a class="mdl-navigation__link mdl-navigation__link--current" href="dokterdashboard.php">
                            <i class="material-icons" role="presentation">dashboard</i>
                            Pendaftaran Pasien
                        </a>
                        <a class="mdl-navigation__link" href="dokterdashboard.php?page=periksa">
                            <i class="material-icons">developer_board</i>
                            Periksa
                        </a>
                        <a class="mdl-navigation__link" href="dokterdashboard.php?page=periksa">
                            <i class="material-icons" role="presentation">person</i>
                            Riwayat Pasien
                        </a>
                    </nav>
                </div>
            </div>
            <div class='scroller__bar' id="scroller__bar"></div>
        </div>
    </div>

    <main class="mdl-layout__content">

        <div class="mdl-grid mdl-grid--no-spacing dashboard">

            <div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
                <h2>
                    <?php
                    if (isset($_GET['page'])) {
                        echo ucwords($_GET['page']);
                    } else {
                        echo "Dashboard";
                    }
                    ?>
                </h2>
            </div>
            <main class="mdl-layout__content ">

        <div class="mdl-grid ui-tables">

            <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
                <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <h1 class="mdl-card__title-text">Data Pasien Saya</h1>
                    </div>
                    <div class="mdl-card__supporting-text no-padding">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">No</th>
                                    <th class="mdl-data-table__cell--non-numeric">Nama Pasien</th>
                                    <th class="mdl-data-table__cell--non-numeric">No. Antrian</th>
                                    <th class="mdl-data-table__cell--non-numeric">KeluhanRD</th>
                                    <th class="mdl-data-table__cell--non-numeric">Hari</th>
                                    <th class="mdl-data-table__cell--non-numeric">WaktuP</th>
                                    <th class="mdl-data-table__cell--non-numeric">Aksi</th>
                            </thead>
                            <tbody>
                            <?php
                                    $id_dokter = $_SESSION['id'];
                                    $result = mysqli_query($mysqli, "
                                    SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                                    FROM daftar_poli
                                    JOIN (
                                        SELECT id_pasien, MAX(tanggal) as max_tanggal
                                        FROM daftar_poli
                                        GROUP BY id_pasien
                                    ) as latest_poli ON daftar_poli.id_pasien = latest_poli.id_pasien AND daftar_poli.tanggal = latest_poli.max_tanggal
                                    JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                                    JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                    LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                                    WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NULL
                                    ");
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($result)) :
                                    ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['no_antrian'] ?></td>
                                    <td><?php echo $data['keluhan'] ?></td>
                                    <td><?php echo $data['hari'] ?></td>
                                    <td><?php echo $data['jam_mulai'] . " - " . $data['jam_selesai'] ?></td>
                                    <td>
                                            <li class="mdl-list__item">
                                                <a href="dokterdashboard.php?periksa=obat&id=<?php echo $data['id'] ?>">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-teal">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                </a>
                                                <a href="dokterdashboard.php?periksa=obat&id=<?php echo $data['id'] ?>&aksi=hapus">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </a>
                                            </li>
                                        
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
        </div>

    </main>

</div>

<!-- inject:js -->
<script src="js/d3.min.js"></script>
<script src="js/getmdl-select.min.js"></script>
<script src="js/material.min.js"></script>
<script src="js/nv.d3.min.js"></script>
<script src="js/layout/layout.min.js"></script>
<script src="js/scroll/scroll.min.js"></script>
<script src="js/widgets/charts/discreteBarChart.min.js"></script>
<script src="js/widgets/charts/linePlusBarChart.min.js"></script>
<script src="js/widgets/charts/stackedBarChart.min.js"></script>
<script src="js/widgets/employer-form/employer-form.min.js"></script>
<script src="js/widgets/line-chart/line-charts-nvd3.min.js"></script>
<script src="js/widgets/map/maps.min.js"></script>
<script src="js/widgets/pie-chart/pie-charts-nvd3.min.js"></script>
<script src="js/widgets/table/table.min.js"></script>
<script src="js/widgets/todo/todo.min.js"></script>
<!-- endinject -->

</body>
</html>
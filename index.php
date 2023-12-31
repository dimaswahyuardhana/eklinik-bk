<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("koneksi.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <title>Ardhana Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-primary bg-info">
        <div class="container-fluid">
            <a href="index.php"><img src="images/logo.png" width="30px" alt=""></a>
            <a class="navbar-brand mx-1" href="index.php">Ardhana Hospital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php?page=pasienbaru">Pasien Baru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php?page=pasienlama">Pasien Lama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php?page=pasiendaftar">Daftar Poliklinik</a>
                    </li>
                    <?php
                    if (isset($_SESSION['username'])) {
                        // Jika admin sudah login, tampilkan menu "Dashboard Admin"
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard Admin</a>
                        </li>
                    <?php
                    }
                    ?>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Data Master</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php?page=obat">Obat</a>
                            </li>
                        </ul>
                    </li> -->
                </ul>
                <?php
                if (isset($_SESSION['username'])) {
                    // Jika pengguna sudah login, tampilkan tombol "Logout"
                ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-light" href="logoutadmin.php">Logout (<?php echo $_SESSION['username'] ?>)</a>
                        </li>
                    </ul>
                <?php
                } else {
                    // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                ?>
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="index.php?page=registerUser">Register</a>
                        </li> -->
                        <li class="nav-item mx-1">
                            <a class="btn btn-light" aria-current="page" href="dokterloginsession.php">Login Dokter</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="index.php?page=loginUser">Login</a>
                        </li>
                    </ul>
                <?php
                }
                ?>

            </div>
        </div>
    </nav>
    

    <main role="main" class="container">
        <?php

        if (isset($_GET['page'])) {
            include($_GET['page'] . ".php");
        } else {
            echo "<br><h2>Selamat Datang di Ardhana Hospital";

            if (isset($_SESSION['username'])) {
                //jika sudah login tampilkan username
                echo ", " . $_SESSION['username'] . "</h2><hr>";
            } else {
                echo "</h2><hr>Daftar poli mudah, ya hanya di Ardhana Hospital</hr></h2>";
            }
        }
        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
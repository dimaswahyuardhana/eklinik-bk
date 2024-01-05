<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
      $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                            nama_poli = '" . $_POST['nama_poli'] . "',
                                            keterangan = '" . $_POST['keterangan'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO poli (nama_poli, keterangan) 
                                            VALUES (
                                                '" . $_POST['nama_poli'] . "',
                                                '" . $_POST['keterangan'] . "'
                                            )");
    }
    echo "<script> 
                document.location='dashboard.php?page=poli';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='dashboard.php?page=poli';
                </script>";
}
?>
    <div class="mdl-grid mdl-cell mdl-cell--6-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone mdl-cell--top">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phonee">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h5 class="mdl-card__title-text text-color--white">Tambah Data Poli</h5>
                </div>
                <div class="mdl-card__supporting-text">
                    <form class="form form--basic" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <?php
                    $nama_poli = '';
                    $keterangan = '';
                    $harga = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($mysqli, "SELECT * FROM poli 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama_poli = $row['nama_poli'];
                            $keterangan = $row['keterangan'];
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone form__article">
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="inputPoli" name="nama_poli"  value="<?php echo $nama_poli ?>">
                                    <label class="mdl-textfield__label" for="inputPoli">NAMA POLI</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="inputKeterangan" name="keterangan" value="<?php echo $keterangan ?>">
                                    <label class="mdl-textfield__label" for="inputKeterangan">KETERANGAN</label>
                                </div>
                                <li class="mdl-list__item">
                                    <button type="submit" name="simpan" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">
                                        Simpan
                                    </button>
                                </li>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mdl-grid ui-tables">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Tabel Poli</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
                    <table class="mdl-data-table mdl-js-data-table">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">NO</th>
                                <th class="mdl-data-table__cell--non-numeric">NAMA POLI</th>
                                <th class="mdl-data-table__cell--non-numeric">KETERANGAN</th>
                                <th class="mdl-data-table__cell--non-numeric">AKSI</th>
                        </thead>
                        <tbody>
                        <?php
                        $result = mysqli_query($mysqli, "SELECT * FROM poli");
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td><?php echo $data['keterangan'] ?></td>
                                <td>
                                        <li class="mdl-list__item">
                                            <a href="dashboard.php?page=poli&id=<?php echo $data['id'] ?>">
                                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </a>
                                            <a href="dashboard.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus">
                                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-red">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </a>
                                        </li>
                                    
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
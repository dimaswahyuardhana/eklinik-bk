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
        $ubah = mysqli_query($mysqli, "UPDATE obat SET 
                                            nama_obat = '" . $_POST['nama_obat'] . "',
                                            kemasan = '" . $_POST['kemasan'] . "',
                                            harga = '" . $_POST['harga'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO obat (nama_obat, kemasan, harga) 
                                            VALUES (
                                                '" . $_POST['nama_obat'] . "',
                                                '" . $_POST['kemasan'] . "',
                                                '" . $_POST['harga'] . "'
                                            )");
    }
    echo "<script> 
                document.location='dashboard.php?page=obat';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='dashboard.php?page=obat';
                </script>";
}
?>
<main class="mdl-layout__content ui-form-components">

<div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

    <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--7-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h5 class="mdl-card__title-text text-color--white">Tambah Data Obat</h5>
            </div>
            <div class="mdl-card__supporting-text">
                <form class="form form--basic" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <?php
                $nama_obat = '';
                $kemasan = '';
                $harga = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($mysqli, "SELECT * FROM obat 
                            WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama_obat = $row['nama_obat'];
                        $kemasan = $row['kemasan'];
                        $harga = $row['harga'];
                    }
                ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php
                }
                ?>
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone form__article">
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="text" id="inputObat" name="nama_obat" value="<?php echo $nama_obat ?>">
                                <label class="mdl-textfield__label" for="inputObat">NAMA OBAT</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="text" id="inputKemasan" name="kemasan" value="<?php echo $kemasan ?>">
                                <label class="mdl-textfield__label" for="inputKemasan">KEMASAN</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="text" id="inputHarga" name="harga" value="<?php echo $harga ?>">
                                <label class="mdl-textfield__label" for="inputHarga">HARGA</label>
                            </div>
                            <li class="mdl-list__item">
                                <button type="submit" name="simpan" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">
                                    Tambah
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
                        <h1 class="mdl-card__title-text">Tabel Obat</h1>
                    </div>
                    <div class="mdl-card__supporting-text no-padding">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">NO</th>
                                    <th class="mdl-data-table__cell--non-numeric">NAMA OBAT</th>
                                    <th class="mdl-data-table__cell--non-numeric">KEMASAN</th>
                                    <th class="mdl-data-table__cell--non-numeric">HARGA</th>
                                    <th class="mdl-data-table__cell--non-numeric">AKSI</th>
                            </thead>
                            <tbody>
                            <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM obat");
                                $no = 1;
                                while ($data = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $data['nama_obat'] ?></td>
                                    <td><?php echo $data['kemasan'] ?></td>
                                    <td><?php echo $data['harga'] ?></td>
                                    <td>
                                            <li class="mdl-list__item">
                                                <a href="dashboard.php?page=obat&id=<?php echo $data['id'] ?>">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </a>
                                                <a href="dashboard.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-red">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </a>
                                            </li>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

</main>
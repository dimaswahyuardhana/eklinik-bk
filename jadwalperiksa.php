<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: dashboard.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_dokter = $_POST['id_dokter'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE jadwal_periksa SET id_dokter='$id_dokter', hari='$hari', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id = '" . $_POST['id'] . "'";
        $edit = mysqli_query($mysqli, $sql);

        echo "
                <script> 
                    alert('Berhasil mengubah data.');
                    document.location='dashboard.php?page=jadwalperiksa';
                </script>
            ";
    } else {
        $sql = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
        $tambah = mysqli_query($mysqli, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='dashboard.php?page=jadwalperiksa';
                </script>
            ";
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");

        if ($hapus) {
            echo "
                    <script> 
                        alert('Berhasil menghapus data.');
                        document.location='dashboard.php?page=jadwalperiksa';
                    </script>
                ";
        } else {
            echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($mysqli) . "');
                        document.location='dashboard.php?page=jadwalperiksa';
                    </script>
                ";
        }
    }
}
?>
<main class="mdl-layout__content ui-form-components">

<div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

    <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--7-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h5 class="mdl-card__title-text text-color--white">Tambah Data Jadwal Periksa</h5>
            </div>
            <div class="mdl-card__supporting-text">
                <form class="form form--basic" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <?php
                    $id_dokter = '';
                    $hari = '';
                    $jam_mulai = '';
                    $jam_selesai = '';
                    if (isset($_GET['id'])) {
                        $get = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($get)) {
                            $id_dokter = $row['id_dokter'];
                            $hari = $row['hari'];
                            $jam_mulai = $row['jam_mulai'];
                            $jam_selesai = $row['jam_selesai'];
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone form__article">
                            <div class="mdl-textfield mdl-js-textfield full-size">
                            <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_dokter" aria-label="id_dokter">
                                <option value="" selected>Pilih Dokter...</option>
                                <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM dokter");

                                while ($data = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $data['id'] . "'>" . $data['nama'] . "</option>";
                                }
                                ?>

                            </select>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <label for="hari">Hari <span class="text-danger">*</span></label>
                                <select class="form-select" name="hari" aria-label="hari">
                                <option value="" selected>Pilih Hari...</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jum'at</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="time" id="inputHarga" name="jam_mulai" value="<?php echo $jam_mulai ?>">
                                <label class="mdl-textfield__label" for="inputHarga">JAM MULAI</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="time" id="inputHarga" name="jam_selesai" value="<?php echo $jam_selesai ?>">
                                <label class="mdl-textfield__label" for="inputHarga">JAM SELESAI</label>
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
                        <h1 class="mdl-card__title-text">Tabel Jadwal Periksa</h1>
                    </div>
                    <div class="mdl-card__supporting-text no-padding">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">NO</th>
                                    <th class="mdl-data-table__cell--non-numeric">HARI</th>
                                    <th class="mdl-data-table__cell--non-numeric">JAM MULAI</th>
                                    <th class="mdl-data-table__cell--non-numeric">JAM SELESAI</th>
                                    <th class="mdl-data-table__cell--non-numeric">AKSI</th>
                            </thead>
                            <tbody>
                            <?php
                            $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['hari'] ?></td>
                                    <td><?php echo $data['jam_mulai'] ?> WIB</td>
                                    <td><?php echo $data['jam_selesai'] ?> WIB</td>
                                    <td>
                                            <li class="mdl-list__item">
                                                <a href="dashboard.php?page=jadwalperiksa&id=<?php echo $data['id'] ?>">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </a>
                                                <a href="dashboard.php?page=jadwalperiksa&id=<?php echo $data['id'] ?>&aksi=hapus"">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-red">
                                                        <i class="material-icons">delete</i>
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
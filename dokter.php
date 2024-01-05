<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $id_poli = $_POST['id_poli'];
    $nip = $_POST['nip'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                          nama = '$nama',
                                          alamat = '$alamat',
                                          no_hp = '$no_hp',
                                          id_poli = '$id_poli',
                                          nip = '$nip',
                                          password = '$password'
                                          WHERE
                                          id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp, id_poli, nip, password) 
                                          VALUES (
                                              '$nama',
                                              '$alamat',
                                              '$no_hp',
                                              '$id_poli',
                                              '$nip',
                                              '$password'
                                          )");
    }
    echo "<script> 
              document.location='dashboard.php?page=dokter';
              </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='dashboard.php?page=dokter';
              </script>";
}
?>
    <div class="mdl-grid mdl-cell mdl-cell--6-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone mdl-cell--top">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h5 class="mdl-card__title-text text-color--white">Tambah Data Dokter</h5>
                </div>
                <div class="mdl-card__supporting-text">
                    <form class="form form--basic" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <?php
                    $nama = '';
                    $alamat = '';
                    $no_hp = '';
                    $id_poli = '';
                    $nip = '';
                    $password = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_hp = $row['no_hp'];
                            $id_poli = $row['id_poli'];
                            $nip = $row['nip'];
                            $password = $row['password'];
                        }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                        }
                    ?>
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone form__article">
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="inputNama" name="nama"  value="<?php echo $nama ?>">
                                    <label class="mdl-textfield__label" for="inputNama">NAMA DOKTER</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="inputAlamat" name="alamat" value="<?php echo $alamat ?>">
                                    <label class="mdl-textfield__label" for="inputAlamat">ALAMAT</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="number" id="inputNohp" name="no_hp" value="<?php echo $no_hp ?>">
                                    <label class="mdl-textfield__label" for="inputNohp">NOMOR HP</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <select class="form-select" id="inputPoli" name="id_poli" aria-label="Default select example">
                                        <option selected>-- PILIH POLI --</option>
                                        <?php
                                            $poli_result = mysqli_query($mysqli, "SELECT * FROM poli");
                                            while ($poli_data = mysqli_fetch_array($poli_result)) {
                                                $selected = ($poli_data['id'] == $id_poli) ? 'selected' : '';
                                                echo "<option value='" . $poli_data['id'] . "' $selected>" . $poli_data['nama_poli'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="inputNip" name="nip" value="<?php echo $nip ?>">
                                    <label class="mdl-textfield__label" for="inputNip">NIP</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="password" id="inputPassword" name="password" value="<?php echo $password ?>">
                                    <label class="mdl-textfield__label" for="inputPassword">Password</label>
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
                    <h1 class="mdl-card__title-text">Tabel Dokter</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
                    <table class="mdl-data-table mdl-js-data-table">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">NO</th>
                                <th class="mdl-data-table__cell--non-numeric">NAMA</th>
                                <th class="mdl-data-table__cell--non-numeric">ALAMAT</th>
                                <th class="mdl-data-table__cell--non-numeric">NOMOR HP</th>
                                <th class="mdl-data-table__cell--non-numeric">POLI</th>
                                <th class="mdl-data-table__cell--non-numeric">NIP</th>
                                <th class="mdl-data-table__cell--non-numeric">AKSI</th>
                        </thead>
                        <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "SELECT dokter.*, poli.nama_poli AS nama_poli FROM dokter JOIN poli ON dokter.id_poli = poli.id");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td><?php echo $data['nip'] ?></td>
                                <td>
                                        <li class="mdl-list__item">
                                            <a href="dashboard.php?page=dokter&id=<?php echo $data['id'] ?>">
                                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </a>
                                            <a href="dashboard.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">
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

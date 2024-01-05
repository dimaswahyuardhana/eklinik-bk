<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='dashboard.php?page=pasienadmin';
              </script>";
}
?>

<div class="mdl-grid ui-tables">

    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h1 class="mdl-card__title-text">Tabel Pasien</h1>
            </div>
            <div class="mdl-card__supporting-text no-padding">
                <table class="mdl-data-table mdl-js-data-table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Nomor KTP</th>
                            <th scope="col">Nomor Handphone</th>
                            <th scope="col">Nomor Rekam Medis</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "SELECT * FROM pasien");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_ktp'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td><?php echo $data['no_rm'] ?></td>
                            <td>
                                    <li class="mdl-list__item">
                                        <a href="dashboard.php?page=pasienadmin&id=<?php echo $data['id'] ?>&aksi=hapus">
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
<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['simpanData'])) {
    $id_daftar_poli = $_GET['id']; // Get the id from the URL
    $id_obat = $_POST['id_obat']; // Get the id_obat value from the form
    $base_biaya_periksa = 150000;
    $tgl_periksa = date('Y-m-d H:i:s'); // Get the current datetime
    $catatan = $_POST['catatan']; // Get the catatan value from the form

    // Query the obat table to get the harga for the selected id_obat
    $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$id_obat'");
    $data = mysqli_fetch_assoc($result);
    $harga_obat = $data['harga'];

    // Calculate the total biaya_periksa
    $biaya_periksa = $base_biaya_periksa + $harga_obat;

    $sql = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$biaya_periksa')";
    $tambah = mysqli_query($mysqli, $sql);

    // Get the id_periksa of the record just inserted
    $id_periksa = mysqli_insert_id($mysqli);

    // Insert into detail_periksa table
    $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
    $tambah = mysqli_query($mysqli, $sql);

    echo "
            <script> 
                alert('Berhasil menambah data.');
                window.location.href='dokterdashboard.php?page=riwayatPasien';
            </script>
        ";
    exit();
}
?>
<main class="mdl-layout__content ui-form-components">

<div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

    <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--7-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h5 class="mdl-card__title-text text-color--white">Tambah Data Periksa</h5>
            </div>
            <div class="mdl-card__supporting-text">
                <form class="form form--basic" method="POST" action="">
                <?php
                    $id_pasien = '';
                    $id_dokter = $_SESSION['id'];
                    $nama_dokter = $_SESSION['nama'];
                    $tgl_periksa = '';
                    $catatan = '';
                    $nama_pasien = '';
                    $no_antrian = '';
                    $keluhan = '';
                    if (isset($_GET['id'])) {
                        $get = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama
                                FROM daftar_poli
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                WHERE daftar_poli.id='" . $_GET['id'] . "'
                            ");
                        while ($row = mysqli_fetch_array($get)) {
                            $id_pasien = $row['id_pasien'];
                            $nama_pasien = $row['nama'];
                            $no_antrian = $row['no_antrian'];
                            $keluhan = $row['keluhan'];
                        }
                    }
                    ?>
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone form__article">
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input style="color:black;" type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input style="color:black;" type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input style="color:black;" type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">Nomor Antrian
                                <input style="color:black;" disabled type="text" name="no_antrian" class="form-control" required value="<?php echo $no_antrian ?>">
                                
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">Nama Pasien
                                <input style="color:black;" disabled type="text" name="id_pasien" class="form-control" required value="<?php echo $nama_pasien ?>">
                                
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">Nama Dokter
                                <input disabled style="color:black;" type="text" name="id_dokter" class="form-control" required value="<?php echo $nama_dokter ?>">
                                
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">Catatan Dokter
                                <input style="color:black;" type="text" name="catatan" class="form-control" required value="<?php echo $catatan ?>">
                                <label class="mdl-textfield__label" for="inputCatatan"></label>
                            </div>
                            <div class="dropdown mb-3 w-25">
                                <label for="id_obat">Obat <span class="text-danger">*</span></label>
                                <select class="form-select" name="id_obat" aria-label="id_obat">
                                    <option value="" selected>Pilih Obat...</option>
                                    <?php
                                    $result = mysqli_query($mysqli, "SELECT * FROM obat");

                                    while ($data = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $data['id'] . "'>" . $data['nama_obat'] . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                            <li class="mdl-list__item">
                                <button type="submit" name="simpanData" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">
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
                        <h1 class="mdl-card__title-text">Tabel Data Periksa</h1>
                    </div>
                    <div class="mdl-card__supporting-text no-padding">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">NO</th>
                                    <th class="mdl-data-table__cell--non-numeric">NAMA PASIEN</th>
                                    <th class="mdl-data-table__cell--non-numeric">NOMOR ANTRIAN</th>
                                    <th class="mdl-data-table__cell--non-numeric">KELUHAN</th>
                                    <th class="mdl-data-table__cell--non-numeric">AKSI</th>
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
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['no_antrian'] ?></td>
                                    <td><?php echo $data['keluhan'] ?></td>
                                    <td>
                                            <li class="mdl-list__item">
                                                <a href="dokterdashboard.php?page=periksa&id=<?php echo $data['id'] ?>">
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
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>
<main class="mdl-layout__content ">

<div class="mdl-grid ui-tables">

    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h1 class="mdl-card__title-text">Tabel Riwayat Periksa</h1>
            </div>
            <div class="mdl-card__supporting-text no-padding">
                <table class="mdl-data-table mdl-js-data-table">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric">NO</th>
                            <th class="mdl-data-table__cell--non-numeric">NAMA PASIEN</th>
                            <th class="mdl-data-table__cell--non-numeric">NOMOR ANTRIAN</th>
                            <th class="mdl-data-table__cell--non-numeric">KELUHAN</th>
                            <th class="mdl-data-table__cell--non-numeric">HARI</th>
                            <th class="mdl-data-table__cell--non-numeric">TANGGAL DIPERIKSA</th>
                            <th class="mdl-data-table__cell--non-numeric">CATATAN</th>
                            <th class="mdl-data-table__cell--non-numeric">BIAYA PERIKSA</th>
                            <th class="mdl-data-table__cell--non-numeric">NAMA OBAT</th>
                    </thead>
                    <tbody>
                        <?php
                        $id_dokter = $_SESSION['id'];
                        $result = mysqli_query($mysqli, "
                        SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, periksa.tgl_periksa, periksa.catatan, periksa.biaya_periksa, obat.nama_obat AS nama_obat
                        FROM daftar_poli
                        JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                        JOIN pasien ON daftar_poli.id_pasien = pasien.id
                        LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                        LEFT JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa
                        LEFT JOIN obat ON detail_periksa.id_obat = obat.id
                        WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NOT NULL
                        ");
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) :
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['no_antrian'] ?></td>
                            <td><?php echo $data['keluhan'] ?></td>
                            <td><?php echo $data['hari'] ?></td>
                            <td><?php echo $data['tgl_periksa'] ?></td>
                            <td><?php echo $data['catatan'] ?></td>
                            <td><?php echo $data['biaya_periksa'] ?></td>
                            <td><?php echo $data['nama_obat'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</main>

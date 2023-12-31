<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE user SET 
                                          nama = '$nama',
                                          username = '$username',
                                          password = '$password'
                                          WHERE
                                          id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO user (nama, username, password) 
                                          VALUES (
                                              '$nama',
                                              '$username',
                                              '$password'
                                          )");
    }
    echo "<script> 
              document.location='dashboard.php?page=registerUser';
              </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM user WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='dashboard.php?page=registerUser';
              </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = $mysqli->query($query);

        if ($result === false) {
            die("Query error: " . $mysqli->error);
        }

        if ($result->num_rows == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($mysqli, $insert_query)) {
                echo "<script>
                alert('Pendaftaran Berhasil'); 
                document.location='dashboard.php?page=registerUser';
                </script>";
            } else {
                $error = "Pendaftaran gagal";
            }
        } else {
            $error = "Username sudah digunakan";
        }
    } else {
        $error = "Password tidak cocok";
    }
}
?>
<main class="mdl-layout__content ui-form-components">

<div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

    <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--7-col-tablet mdl-cell--4-col-phone">
        <div class="mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h5 class="mdl-card__title-text text-color--white">Tambah Data Admin</h5>
            </div>
            <div class="mdl-card__supporting-text">
                <form class="form form--basic" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <?php
                $nama = '';
                $username = '';
                $password = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($mysqli, "SELECT * FROM user 
                            WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama = $row['nama'];
                        $username = $row['username'];
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
                                <input class="mdl-textfield__input" type="text" id="inputObat" name="nama" value="<?php echo $nama ?>">
                                <label class="mdl-textfield__label" for="inputObat">NAMA</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="text" id="inputKemasan" name="username" value="<?php echo $username ?>">
                                <label class="mdl-textfield__label" for="inputKemasan">USERNAME</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield full-size">
                                <input class="mdl-textfield__input" type="password" id="inputHarga" name="password" value="<?php echo $password ?>">
                                <label class="mdl-textfield__label" for="inputHarga">PASSWORD</label>
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
                                    <th class="mdl-data-table__cell--non-numeric">NAMA</th>
                                    <th class="mdl-data-table__cell--non-numeric">USERNAME</th>
                                    <th class="mdl-data-table__cell--non-numeric">AKSI</th>
                            </thead>
                            <tbody>
                            <?php
                            $result = mysqli_query($mysqli, "SELECT * FROM user");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                <th scope="row"><?php echo $no++ ?></th>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['username'] ?></td>
                                    <td>
                                            <li class="mdl-list__item">
                                                <a href="dashboard.php?page=registerUser&id=<?php echo $data['id'] ?>">
                                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-orange">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </a>
                                                <a href="dashboard.php?page=registerUser&id=<?php echo $data['id'] ?>&aksi=hapus">
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
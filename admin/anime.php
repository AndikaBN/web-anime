<?php
require "../function.php";
checkLogin();
$dataAdmin = dataUser();

// Query untuk mendapatkan data anime beserta genre
$animein = mysqli_query($conn, "
  SELECT
    animes.anime_id,
    animes.title,
    animes.kategori,
    animes.description,
    animes.rating,
    animes.release_date,
    animes.cover_image,
    animes.status,
    animes.jadwal_hari,
    genres.name AS genre
  FROM
    animes
  INNER JOIN
    genres ON animes.genre_id = genres.genre_id;
");

// Mendapatkan data anime tanpa menggunakan genre
$anime = Query("SELECT * FROM animes");

// Mendapatkan data genre
$genre = mysqli_query($conn, "SELECT * FROM genres");

if (isset($_POST["submit"])) {
    if (TambahAnime($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil di tambahkan uwu >_<');
            window.location.href = 'anime.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal di tambahkan T_T');
            window.location.href = 'anime.php';
        </script>
        ";
    }
}

if (isset($_POST["btnUbahAnime"])) {
    if (UbahAnime($_POST) > 0) {
        echo "
        <script>
        confirm('Beneran mau diubah ?');
        alert('Uwu berhasil diubah >_<');
            window.location.href = 'anime.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Gagal mengubah XD');
            window.location.href = 'anime.php';
        </script>
        ";
    }
}

if (isset($_POST["btnTambahEpisode"])) {
    if (tambahEpisode($_POST, $_FILES['episode']) > 0) {
        echo "
        <script>
            alert('Episode berhasil ditambahkan');
            window.location.href = 'anime.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Gagal menambahkan episode');
            window.location.href = 'anime.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anime SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .img-profile {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">GodSlayerFlix</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="user-panel mt-3 d-flex" style="margin-left: 20px; align-items: center;">
                            <div class="image">
                                <img style="width: 45px; " src="assets/img/<?= $dataAdmin['photo_profile']; ?>"
                                    class="rounded-circle elevation-2 img-profile" alt="User Image">
                            </div>
                            <div class="info ms-2">
                                <a href="admin.php" class="d-block" style="text-decoration: none; color: white;">
                                    <?= $dataAdmin['username']; ?>
                                </a>
                            </div>
                        </div>
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Data Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="genreAnime.php">Genre Anime</a>
                                <a class="nav-link" href="anime.php">Anime</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    AnbinDev
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mt-4">List Anime</h1>
                        </div>

                        <div style="margin-top: 30px;" class="col-md-6 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i class="fas fa-fw fa-plus"></i> Tambah Anime </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" enctype="multipart/form-data" action="">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Anime</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="form-group text-center">
                                                    <a href="assets/img/default.png" class="enlarge"
                                                        id="check_enlarge_photo">
                                                        <img src="assets/img/default.png" class="img-profile rounded"
                                                            id="check_photo" alt="cover film">
                                                    </a>
                                                    <div class="form-group">
                                                        <label for="photo">Cover Anime</label>
                                                        <input type="file" name="cover_anime" id="photo"
                                                            class="btn btn-sm btn-primary form-control form-control-file"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_anime">Judul Anime</label>
                                                    <input type="text" name="nama_anime" required class="form-control"
                                                        id="nama_anime">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kategori_anime">Kategori Anime</label>
                                                    <select name="kategori_anime" required class="form-control"
                                                        id="kategori_anime">
                                                        <option value="Series">Series</option>
                                                        <option value="Movie">Movie</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="tanggal_rilis">Tanggal Rilis</label>
                                                    <input type="date" name="tanggal_rilis" required
                                                        class="form-control" id="tanggal_rilis">
                                                </div>
                                                <div class="form-group">
                                                    <label for="sinopsis">Sinopsis</label>
                                                    <input type="text" name="sinopsis" required class="form-control"
                                                        id="sinopsis">
                                                </div>
                                                <div class="form-group">
                                                    <label for="rating_anime">Rating</label>
                                                    <input type="number" step="0.01" name="rating_anime" required
                                                        class="form-control" id="rating_anime">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <input type="text" name="status" required class="form-control"
                                                        id="status" placeholder="tulis onGoing atau End">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jadwalphari">Jadwal per Hari</label>
                                                    <input type="text" name="jadwalphari" required class="form-control"
                                                        id="jadwalphari" placeholder="Ketik Hari..">
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_genre">Nama Genre</label>
                                                    <select name="id_genre" id="id_genre" class="form-control">
                                                        <?php foreach ($genre as $dg): ?>
                                                            <option value="<?= $dg['genre_id']; ?>">
                                                                <?= ucwords($dg['name']); ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Cover Anime</th>
                                <th>Judul Anime</th>
                                <th>Kategori</th>
                                <th>Tanggal Rilis</th>
                                <th>Sinopsis</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Jadwal per Hari</th>
                                <th>Genre</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($animein as $row): ?>
                                <tr>
                                    <td>
                                        <?= $i++; ?>
                                    </td>
                                    <td><img src="../uploads/<?= $row['cover_image']; ?>" alt="Cover Film"
                                            style="max-width: 100px;"></td>
                                    <td>
                                        <?= $row['title']; ?>
                                    </td>
                                    <td>
                                        <?= $row['kategori']; ?>
                                    </td>
                                    <td>
                                        <?= $row['release_date']; ?>
                                    </td>
                                    <td>
                                        <?= $row['description']; ?>
                                    </td>
                                    <td>
                                        <?= $row['rating']; ?>
                                    </td>
                                    <td>
                                        <?= $row['status']; ?>
                                    </td>
                                    <td>
                                        <?= $row['jadwal_hari']; ?>
                                    </td>
                                    <td>
                                        <?= $row['genre']; ?>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Beneran mau dihapus T_T..???')"
                                            href="hapusAnime.php?id=<?= $row["anime_id"] ?>"
                                            class="btn btn-secondary">Hapus</a>
                                        <a class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#UbahAnime<?= $row["anime_id"] ?>">
                                            Ubah
                                        </a>
                                        <div class="modal fade" id="UbahAnime<?= $row["anime_id"] ?>" tabindex="-1"
                                            aria-labelledby="UbahAnimeLabel<?= $row["anime_id"] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?= $row["anime_id"] ?>">
                                                    <input type="hidden" name="coverLama"
                                                        value="<?= $row["cover_image"] ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="UbahAnimeLabel<?= $row["anime_id"] ?>">Ubah Anime</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group text-center">
                                                                <a href="../uploads/<?= $row["cover_image"] ?>"
                                                                    class="enlarge" id="check_enlarge_photo">
                                                                    <img src="../uploads/<?= $row["cover_image"] ?>"
                                                                        class="img-profile rounded" id="check_photo"
                                                                        alt="cover film">
                                                                </a>
                                                                <div class="form-group">
                                                                    <label for="photo">Cover Anime</label>
                                                                    <input type="file" name="cover_anime" id="photo"
                                                                        class="btn btn-sm btn-primary form-control form-control-file"
                                                                        accept="image/*">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_anime<?= $row["anime_id"] ?>">Judul
                                                                    Anime</label>
                                                                <input type="text" name="nama_anime" required
                                                                    value="<?= $row["title"] ?>" class="form-control"
                                                                    id="nama_anime<?= $row["anime_id"] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_anime<?= $row["anime_id"] ?>">Judul
                                                                    Anime</label>
                                                                <select name="kategori_anime" required class="form-control"
                                                                    id="kategori_anime<?= $row["anime_id"] ?>">
                                                                    <option value="Series" <?= ($row["kategori"] == "Series") ? "selected" : "" ?>>Series</option>
                                                                    <option value="Movie" <?= ($row["kategori"] == "Movie") ? "selected" : "" ?>>Movie</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal_rilis<?= $row["anime_id"] ?>">Tanggal
                                                                    Rilis</label>
                                                                <input type="date" name="tanggal_rilis" required
                                                                    value="<?= $row["release_date"] ?>" class="form-control"
                                                                    id="tanggal_rilis<?= $row["anime_id"] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="sinopsis<?= $row["anime_id"] ?>">Sinopsis</label>
                                                                <input type="text" name="sinopsis" required
                                                                    value="<?= $row["description"] ?>" class="form-control"
                                                                    id="sinopsis<?= $row["anime_id"] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="rating_anime<?= $row["anime_id"] ?>">Rating</label>
                                                                <input type="number" step="0.01" name="rating_anime"
                                                                    value="<?= $row["rating"] ?>" required
                                                                    class="form-control"
                                                                    id="rating_anime<?= $row["anime_id"] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="status<?= $row["anime_id"] ?>">Status</label>
                                                                <input type="text" name="status" required
                                                                    value="<?= $row["status"] ?>" class="form-control"
                                                                    id="status<?= $row["anime_id"] ?>"
                                                                    placeholder="tulis onGoing atau End">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jadwalphari<?= $row["anime_id"] ?>">Jadwal per
                                                                    Hari</label>
                                                                <input type="text" name="jadwalphari" required
                                                                    value="<?= $row["jadwal_hari"] ?>" class="form-control"
                                                                    id="jadwalphari<?= $row["anime_id"] ?>"
                                                                    placeholder="Ketik Hari..">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="id_genre<?= $row["anime_id"] ?>">Nama
                                                                    Genre</label>
                                                                <select name="id_genre" id="id_genre<?= $row["anime_id"] ?>"
                                                                    class="form-control">
                                                                    <option value="<?= $dg['genre_id']; ?>">
                                                                        <?= ucwords($dg['name']); ?>
                                                                    </option>
                                                                    <option disabled>---------</option>
                                                                    <?php foreach ($genre as $dg): ?>
                                                                        <option value="<?= $dg['genre_id']; ?>">
                                                                            <?= ucwords($dg['name']); ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">batal</button>
                                                            <button type="submit" name="btnUbahAnime"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="episodeAnime.php?id=<?= $row["anime_id"] ?>" class="btn btn-secondary">
                                            <i class="fas fa-fw fa-list"></i> Lihat Episode
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.2.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
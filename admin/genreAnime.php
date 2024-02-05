<?php
require "../function.php";
checkLogin();
$dataAdmin = dataUser();

if (isset($_POST["btnTambahGenre"])) {
    if (TambahGenre($_POST) > 0) {
        echo "
        <script>
            alert('genre berhasil di tambahkan uwu >_<');
            window.location.href = 'genreAnime.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('genre gagal di tambahkan T_T');
            window.location.href = 'genreAnime.php';
        </script>
        ";
    }
}

if (isset($_POST["btnUbahGenre"])) {
    if (UbahGenre($_POST) > 0) {
        echo "
        <script>
            window.location.href = 'genreAnime.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal di ubah T_T');
            window.location.href = 'genreAnime.php';
        </script>
        ";
    }
}

$genre = Query("SELECT * FROM genres");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>GodSlayerFlix - Genre Film</title>
    <link href="css/styles.css" rel="stylesheet" />
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
                    <li><a class="dropdown-item" href="admin.php">Profile</a></li>
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
                    SDN 1 Sembung
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main style="padding: 30px;">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm">
                                <h1 class="m-0 text-dark">Genre Film</h1>
                            </div><!-- /.col -->
                            <div class="col-sm text-right">
                                <button type="button" id="tambahGenreButton" class="btn btn-primary"><i
                                        class="fas fa-fw fa-plus"></i> Tambah Genre</button>
                                <!-- Modal -->
                                <div class="modal fade text-left" id="tambahGenreModal" tabindex="-1" role="dialog"
                                    aria-labelledby="tambahGenreModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form method="post">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tambahGenreModalLabel">Tambah Genre</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nama_genre">Nama Genre</label>
                                                        <input type="text" name="nama_genre" required
                                                            class="form-control" id="nama_genre">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                            class="fas fa-fw fa-times"></i> Batal</button>
                                                    <button type="submit" name="btnTambahGenre"
                                                        class="btn btn-primary"><i class="fas fa-fw fa-save"></i>
                                                        Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($genre as $rows): ?>
                            <tr>
                                <th scope="row">
                                    <?= $no ?>
                                </th>
                                <td>
                                    <?= $rows["name"] ?>
                                </td>
                                <td>
                                    <a onclick="return confirm('beneran mau dihapus? T_T')" href="hapusGen.php?id=<?= $rows["genre_id"] ?>" class="btn btn-secondary">Hapus</a>
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#UbahGenreModal<?= $rows["genre_id"] ?>">Ubah</a>
                                    <div class="modal fade" id="UbahGenreModal<?= $rows["genre_id"] ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabel<?= $rows["genre_id"] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?= $rows["genre_id"] ?>">
                                                <!-- Ganti action ke genreAnime.php -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="exampleModalLabel<?= $rows["genre_id"] ?>">Ubah Genre</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama_genre<?= $rows["genre_id"] ?>">Nama
                                                                Genre</label>
                                                            <input type="text" name="nama_genre" required
                                                                class="form-control" id="nama_genre<?= $rows["genre_id"] ?>"
                                                                value="<?= $rows["name"] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="btnUbahGenre">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
    <script>
        document.getElementById('tambahGenreButton').addEventListener('click', function () {
            var tambahGenreModal = new bootstrap.Modal(document.getElementById('tambahGenreModal'));
            tambahGenreModal.show();
        });
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>
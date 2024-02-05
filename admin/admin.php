<?php
require "../function.php";
checkLogin();
$dataAdmin = dataUser();

if (isset($_POST['btnUbahProfile'])) {
    $data = [
        'username' => $_POST['username'],
        'nama_lengkap' => $_POST['nama_lengkap'],
        'photo_lama' => $_POST['photo_lama']
    ];
    $result = ubahProfile($data);
    if ($result) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Gagal mengubah profile.";
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
    <title>GodSlayerFlix Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

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
                    <li><a class="dropdown-item" href="admin.php">profile</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
                <center>
                    <div class="container" style="margin-top: 100px;">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-7">
                                <div class="card p-3 py-4">
                                    <div class="text-center">
                                        <a href="assets/img/<?= $dataAdmin['photo_profile']; ?>" class="enlarge"
                                            data-lightbox="profile-image">
                                            <img src="assets/img/<?= $dataAdmin['photo_profile']; ?>" width="100"
                                                class="rounded-circle" class="img-profile rounded-pill">
                                        </a>
                                    </div>
                                    <div class="text-center mt-3">
                                        <span class="bg-secondary p-1 px-4 rounded text-white">Admin
                                            GodSlayerFlix</span>
                                        <h5 class="mt-2 mb-0">
                                            <?= $dataAdmin['username']; ?>
                                        </h5>
                                        <span>
                                            <?= $dataAdmin['nama_lengkap']; ?>
                                        </span>
                                        <div class="buttons">
                                            <button class="btn btn-outline-primary px-4" data-bs-toggle="modal"
                                                data-bs-target="#ubahProfileModal">Ubah</button>
                                            <button class="btn btn-primary px-4 ms-3" data-bs-toggle="modal"
                                                data-bs-target="#ubahPasswordModal">Ubah Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </center>
            </main>
            <!-- Modal Ubah -->
            <div class="modal fade" id="ubahProfileModal" tabindex="-1" role="dialog"
                aria-labelledby="ubahProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="photo_lama" value="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ubahProfileModalLabel"><i
                                        class="fas fa-fw fa-user-edit"></i> Ubah Profile</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-center">
                                    <a href="" class="enlarge" id="check_enlarge_photo">
                                        <img style="height: 200px; width: 200px;" src=""
                                            class="img-profile rounded-circle" id="check_photo" alt="">
                                    </a>
                                    <div class="form-group">
                                        <label for="photo">Photo Profile</label>
                                        <input type="file" name="photo_profile" id="photo"
                                            class="btn btn-sm btn-primary form-control form-control-file"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" value="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input required type="text" name="nama_lengkap" id="nama_lengkap" value=""
                                        class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fas fa-fw fa-times"></i> Batal </button>
                                <button type="submit" name="btnUbahProfile" class="btn btn-primary"><i
                                        class="fas fa-fw fa-save"></i> Simpan </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Ubah Password -->
            <div class="modal fade" id="ubahPasswordModal" tabindex="-1" role="dialog"
                aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ubahPasswordModalLabel"><i
                                        class="fas fa-fw fa-user-edit"></i> Ubah Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="password_lama">Password Lama</label>
                                    <input required type="password" name="password_lama" id="password_lama"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_baru">Password Baru</label>
                                    <input required type="password" minlength="6" name="password_baru"
                                        id="password_baru" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="verifikasi_password_baru">Verifikasi Password Baru</label>
                                    <input required type="password" minlength="6" name="verifikasi_password_baru"
                                        id="verifikasi_password_baru" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fas fa-fw fa-times"></i> Batal </button>
                                <button type="submit" name="btnUbahPassword" class="btn btn-primary"><i
                                        class="fas fa-fw fa-save"></i> Simpan </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.1/dist/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.1/dist/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
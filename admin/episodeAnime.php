<?php
require "../function.php";
checkLogin();

$anime_id = isset($_GET['id']) ? $_GET['id'] : null;

$queryAnime = Query("SELECT animes.*, genres.name AS genre_name FROM animes 
                    INNER JOIN genres ON animes.genre_id = genres.genre_id
                    WHERE anime_id = $anime_id")[0];

$queryEpisode = Query("SELECT * FROM episodes WHERE anime_id = $anime_id");

if (isset($_POST["btnTambahEpisode"])) {
  if (tambahEpisode($_POST, $_FILES['episode']) > 0) {
    echo "
      <script>
          alert('Episode berhasil ditambahkan');
          window.location.href = 'episodeAnime.php?id=$anime_id';
      </script>
      ";
  } else {
    echo "
      <script>
          alert('Gagal menambahkan episode');
          window.location.href = 'episodeAnime.php';
      </script>
      ";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Episode Anime Admin</title>
  <link rel="stylesheet" href="css/eps.css">
</head>

<body>
  <div class="content-detail" style="  margin: 20px 280px;
  padding: 20px;
  background-color: rgb(43, 42, 42);
  position: relative;">
    <h3 style="display: flex; justify-content: space-between;">
      <?= $queryAnime['title']; ?>
      <a href="anime.php">
        <i class="fas fa-arrow-left"></i>
        Kembali
      </a>

    </h3>
    <hr>
    <div class="streaming-col">
      <p>Streaming
        <?= $queryAnime['title']; ?>
      </p>
    </div>
    <div class="title-stream">
      <div class="image-stream"><img src="../uploads/<?= $queryAnime['cover_image']; ?>" alt="" width="200px"></div>
      <div class="detail-stream">
        <table>
          <tr>
            <td>Judul</td>
            <td>:
              <?= $queryAnime['title']; ?>
            </td>
          </tr>
          <tr>
            <td>Kategori</td>
            <td>:
              <?= $queryAnime['kategori']; ?>
            </td>
          </tr>
          <tr>
            <td>Tanggal Rilis</td>
            <td>:
              <?= $queryAnime['release_date']; ?>
            </td>
          </tr>
          <tr>
            <td>Rate</td>
            <td>:
              <?= $queryAnime['rating']; ?>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>:
              <?= $queryAnime['status']; ?>
            </td>
          </tr>
          <tr>
            <td>Genre</td>
            <td>:
              <?= isset($queryAnime['genre_name']) ? $queryAnime['genre_name'] : 'N/A'; ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <figcaption>
      <?= $queryAnime['description']; ?>
    </figcaption>

    <div class="list-eps">
      <div class="list-head" style="display: flex; justify-content: space-between;">
        <h3 style="margin: 20px; padding: 10px; margin-bottom: 10px;">List Episode</h3>
        <button class="btn btn-danger" type="submit" data-bs-toggle="modal"
          style="margin: 20px; padding: 10px; margin-bottom: 10px;" data-bs-target="#TambahEpisode">+
          Tambahkan Episode</button>
        <div class="modal fade" id="TambahEpisode" tabindex="-1" aria-labelledby="TambahEpisodeLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="anime_id" value="<?= $anime_id ?>">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="TambahEpisodeLabel" style="color: black;">Tambah
                    Episode</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="episode_number" style="color: black" ;>Nomor Episode</label>
                    <input type="number" name="episode_number" required class="form-control" id="episode_number">
                  </div>
                  <div class="form-group">
                    <label for="title" style="color: black;">Judul Episode</label>
                    <input type="text" name="title" required class="form-control" id="title">
                  </div>
                  <div class="form-group">
                    <label for="episode">Path Video</label>
                    <input type="file" name="episode" required class="form-control" id="episode" accept="video/*">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="btnTambahEpisode" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <ul>
        <?php foreach ($queryEpisode as $index => $episode): ?>
          <li>
            <video controls>
              <source src="../uploads/episodes/<?= $episode['video_path']; ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <p>Episode:
              <?= $episode["episode_number"] ?>
            </p>
            <p class="episode-title">
              <?= $episode['title']; ?>
            </p>
            <!-- Tombol Edit dan Hapus -->
            <div class="btn-group" role="group" aria-label="Basic example">
              <a href="hapusEpisode.php?id=<?= $anime_id ?>&episode_id=<?= $episode['episode_id']; ?>"
                class="btn btn-danger"
                onclick="return confirm('Apakah Anda yakin ingin menghapus episode ini?')">Hapus</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
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
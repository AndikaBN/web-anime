<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'anime_database');


function checkLogin() {
	if (!isset($_SESSION['id_admin'])) {
		header('Location: login.php');
	} 
}

function checkLoginAtLogin() {
	if (isset($_SESSION['id_admin'])) {
		header('Location: index.php');
	}
}

function dataUser() {
	global $conn;
	if (isset($_SESSION['id_admin'])) {
		$id_admin = $_SESSION['id_admin'];
		return mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = '$id_admin'"));
	} else {
		echo "
		  <script>
		    document.location.href='logout.php'
		  </script>
		";
	}
}
function TambahGenre($data)
{
    global $conn;
    $genre = htmlspecialchars($data["nama_genre"]);
    $query = "INSERT INTO genres (name) VALUES ('$genre')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function HapusGenre($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM episodes WHERE anime_id IN (SELECT anime_id FROM animes WHERE genre_id = $id)");
    mysqli_query($conn, "DELETE FROM animes WHERE genre_id = $id");
    mysqli_query($conn, "DELETE FROM genres WHERE genre_id = $id");
    return mysqli_affected_rows($conn);
}

function Query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query error: " . mysqli_error($conn) . " for query: " . $query);
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


function UbahGenre($data)
{
    global $conn;
    $id = $data["id"];
    $genre = htmlspecialchars($data["nama_genre"]);
    $query = "UPDATE genres SET name = '$genre' WHERE genre_id='$id'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function TambahAnime($data)
{
    global $conn;
    $judul = htmlspecialchars(ucwords($data["nama_anime"]));
    $kategori = htmlspecialchars($data["kategori_anime"]);
    $rilis = htmlspecialchars($data["tanggal_rilis"]);
    $sinopsis = htmlspecialchars($data["sinopsis"]);
    $status = htmlspecialchars($data["status"]);
    $jadwalphari = htmlspecialchars($data["jadwalphari"]);
    $rating = htmlspecialchars($data["rating_anime"]);
    $cover = uploadAnime();

    // Menangkap nilai genre yang dipilih
    $id_genre = htmlspecialchars($data["id_genre"]);

    if (!$cover) {
        return false;
    }

    // Simpan data ke dalam tabel animes
    $query = "INSERT INTO animes (title, kategori, description, rating, release_date, status, jadwal_hari, cover_image, genre_id) VALUES ('$judul','$kategori', '$sinopsis', '$rating','$rilis', '$status', '$jadwalphari', '$cover', '$id_genre')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function uploadAnime()
{
    $nama_cover = $_FILES['cover_anime']['name'];
    $ukuran_cover = $_FILES['cover_anime']['size'];
    $error = $_FILES['cover_anime']['error'];
    $tmp_name = $_FILES['cover_anime']['tmp_name'];

    // cek aoakah mengupload cover
    if ($error === 4) {
        echo "<script>
           alert('pilih gambar dengan benar');
        </script>";
        return false;
    }

    // cek ekstensi cover
    $ekstensi_cover_valid = ['jpg', 'jpeg', 'png', 'gif', "webp"];
    $ekstensi_cover = explode('.', $nama_cover);
    $ekstensi_cover = strtolower(end($ekstensi_cover));
    if (!in_array($ekstensi_cover, $ekstensi_cover_valid)) {
        echo "<script>
           alert('yang anda upload bukan gambar');
        </script>";
        return false;
    }

    // cek ukuran cover
    if ($ukuran_cover > 1000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar');
     </script>";
        return false;
    }

    // generate random nama
    $nama_cover_baru = uniqid();
    $nama_cover_baru .= '.';
    $nama_cover_baru .= $ekstensi_cover;

    move_uploaded_file($tmp_name, '../uploads/' . $nama_cover_baru);
    return $nama_cover_baru;
}

function HapusAnime($id)
{
    global $conn;
    // Hapus terlebih dahulu data dari tabel episodes yang terkait dengan anime yang akan dihapus
    mysqli_query($conn, "DELETE FROM episodes WHERE anime_id = $id");
    // Setelah itu baru hapus data dari tabel animes
    mysqli_query($conn, "DELETE FROM animes WHERE anime_id = $id");
    return mysqli_affected_rows($conn);
}


function UbahAnime($data)
{
    global $conn;
    $id = $data["id"];
    $judul = htmlspecialchars(ucwords($data["nama_anime"]));
    $kategori = htmlspecialchars($data["kategori_anime"]);
    $rilis = htmlspecialchars($data["tanggal_rilis"]);
    $sinopsis = htmlspecialchars($data["sinopsis"]);
    $status = htmlspecialchars($data["status"]);
    $jadwalphari = htmlspecialchars($data["jadwalphari"]);
    $coverLama = htmlspecialchars($data["coverLama"]);
    $rating = htmlspecialchars($data["rating_anime"]);
    $genre = htmlspecialchars($data["id_genre"]);

    if ($_FILES["cover_anime"]["error"] === 4) {
        $cover = $coverLama;
    } else {
        $cover = uploadAnime();
    }

    $query = "UPDATE animes SET
                title = '$judul',
                kategori = '$kategori',
                description = '$sinopsis',
                rating = '$rating',
                release_date = '$rilis',
                status = '$status',
                jadwal_hari = '$jadwalphari',
                cover_image = '$cover',
                genre_id = '$genre'
                WHERE anime_id = '$id'
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambahEpisode($data, $file)
{
    global $conn;

    $anime_id = $data["anime_id"];
    $episode_number = htmlspecialchars($data["episode_number"]);
    $title = htmlspecialchars($data["title"]);

    // Upload video
    $video_path = uploadVideo($file);

    if (!$video_path) {
        return false;
    }

    $query = "INSERT INTO episodes (anime_id, episode_number, title, video_path) VALUES ('$anime_id', '$episode_number', '$title', '$video_path')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function uploadVideo($file)
{
    $nama_video = $file['name'];
    $ukuran_video = $file['size'];
    $error = $file['error'];
    $tmp_name = $file['tmp_name'];

    // Cek apakah mengupload video
    if ($error === 4) {
        echo "<script>
           alert('Pilih video dengan benar');
        </script>";
        return false;
    }

    // Cek ekstensi video
    $ekstensi_video_valid = ['mp4', 'mkv', 'avi', 'mov'];
    $ekstensi_video = explode('.', $nama_video);
    $ekstensi_video = strtolower(end($ekstensi_video));
    if (!in_array($ekstensi_video, $ekstensi_video_valid)) {
        echo "<script>
           alert('Yang Anda upload bukan video');
        </script>";
        return false;
    }

    // Cek ukuran video
    $max_size = 1.5 * 1024 * 1024 * 1024; // 1.5 GB dalam byte
    if ($ukuran_video > $max_size) {
        echo "<script>
        alert('Ukuran video terlalu besar. Maksimal 1.5 GB');
     </script>";
        return false;
    }

    // Generate random nama
    $nama_video_baru = uniqid();
    $nama_video_baru .= '.';
    $nama_video_baru .= $ekstensi_video;

    move_uploaded_file($tmp_name, '../uploads/episodes/' . $nama_video_baru);
    return $nama_video_baru;
}

function hapusEpisode($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM episodes WHERE episode_id=$id");
    return mysqli_affected_rows($conn);
}
function ubahProfile($data) {
    global $conn;
    $id_admin = $_SESSION['id_admin'];
    $username = htmlspecialchars($data['username']);
    $nama_lengkap = htmlspecialchars(addslashes($data['nama_lengkap']));
    $photo_lama = htmlspecialchars($data['photo_lama']);
    
    if ($_FILES['photo_profile']['error'] === 4) {
        $photo_profile = $photo_lama;
    } else {
        $photo_profile = upload();
    }
    mysqli_query($conn, "UPDATE admin SET username = '$username', nama_lengkap = '$nama_lengkap', photo_profile = '$photo_profile' WHERE id_admin = '$id_admin'");

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["photo_profile"]["name"];
    $ukuranFile = $_FILES["photo_profile"]["size"];
    $error = $_FILES["photo_profile"]["error"];
    $tmpName = $_FILES["photo_profile"]["tmp_name"];

    // cek apakah tidak ada gambar yang di upload
    if ($error === 4) {
        echo "<script>
           alert('Pilih gambar dengan benar');
        </script>";
        return false;
    }
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
    $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);
    if (!in_array(strtolower($ekstensiGambar), $ekstensiGambarValid)) {
        echo "<script>
           alert('Yang Anda upload bukan gambar');
        </script>";
        return false;
    }
    if ($ukuranFile > 1000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar');
     </script>";
     return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

?>
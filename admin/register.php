<?php  
require "../function.php";

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

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
    $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);

    if (!in_array(strtolower($ekstensiGambar), $ekstensiGambarValid)) {
        echo "<script>
           alert('Yang Anda upload bukan gambar');
        </script>";
        return false;
    }

    // cek jika ukuran terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar');
     </script>";
     return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $nama_lengkap = mysqli_real_escape_string($conn, $data["nama_lengkap"]);

    // Upload foto profile
    $photo_profile = upload();

    if (!$photo_profile) {
        return false;
    }

    // Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah ada');
              </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('Konfirmasi password tidak sesuai');
        </script>";
        return false;
    }

    // Enkripsi password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    $query = "INSERT INTO admin (username, password, nama_lengkap, photo_profile) 
              VALUES ('$username', '$password_hashed', '$nama_lengkap', '$photo_profile')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (registrasi($_POST)) {
        echo "<script>
                alert('Registrasi berhasil');
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </li>
            <li>
                <label for="password2">Konfirmasi Password</label>
                <input type="password" name="password2" required>
            </li>
            <li>
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required>
            </li>
            <li>
                <label for="photo_profile">Foto Profile</label>
                <input type="file" name="photo_profile" required>
            </li>
            <li>
                <button type="submit">Registrasi</button>
            </li>
        </ul>
    </form>
</body>
</html>

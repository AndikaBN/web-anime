<?php  
require '../function.php';
checkLogin();

$id = $_GET["id"];

if (HapusGenre($id) > 0) {
    header("Location:genreAnime.php");
} else {
    echo "
    <script>
        alert('huhuhu gagal menghapus XD');
        window.location.href = 'genreAnime.php';
    </script>
    ";
}
?>
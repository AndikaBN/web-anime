<?php  
require "../function.php";
checkLogin();

$idEpisode = $_GET["episode_id"];
$idAnime = $_GET["id"];

if (hapusEpisode($idEpisode) > 0) {
    echo "
    <script>
        alert('beneran mau di hapus T_T');
        window.location.href = 'episodeAnime.php?id=$idAnime';
    </script>
    ";
}else {
    echo "
    <script>
        alert('huhuhu gagal menghapus XD');
        window.location.href = 'episodeAnime.php';
    </script>
    ";
}

?>
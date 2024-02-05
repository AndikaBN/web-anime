<?php
require "../function.php";
checkLogin();

$id = $_GET["id"];

if (HapusAnime($id) > 0) {
    header("Location:anime.php");
} else {
    echo "
    Gagal menghapus XD    
    ";
}
?>
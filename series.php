<?php
require "function.php";

$seriesAnimeHead = Query("SELECT * FROM animes WHERE kategori = 'Series' ORDER BY rating DESC LIMIT 3");
$seriesAnime = Query("SELECT * FROM animes WHERE kategori = 'Series'");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin/css/styleus.css">
    <style>
          .status-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #E50914;
            color: #ffffff;
            /* Warna latar belakang label */
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .rating-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #E50914;
            color: #ffffff;
            /* Warna latar belakang label */
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .content p {
            max-height: 4.5em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }

        .anime-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .anime-item {
            display: flex;
            flex-direction: column;
        }

        .box {
            height: 200px;
            /* Sesuaikan dengan tinggi yang diinginkan */
            position: relative;
        }

        .status-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px;
        }

        .content {
            padding: 10px;
        }

        /* Gaya tambahan sesuai kebutuhan */
    </style>
</head>

<body>
    <header>
        <a href="#" class="logo"><i class="fas fa-infinity"></i>GodSlayerFlix.</a>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="series.php" class="link active">series</a>
            <a href="movie.php">movie</a>
        </nav>
        <div class="icons">
            <i class="fas fa-bars" id="menu-bars"></i>
            <i class="fas fa-search" id="search-icon"></i>
            <a href="#" class="fas fa-heart"></a>
        </div>
    </header>
    <section class="home" id="home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper">
                <?php foreach ($seriesAnimeHead as $row): ?>
                    <div class="swiper-slide">
                        <div class="box " style="background: url(uploads/<?= $row["cover_image"] ?>) no-repeat; ">
                            <div class="content">
                                <h3 style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                                    <?= $row["title"] ?>
                                </h3>
                                <p>
                                    <?= $row["description"] ?>
                                </p>
                                <a href="#" class="btn">
                                    <i class="fas fa-play"></i> Tonton Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="anime" id="anime">
        <h1 class="heading">Popular on Anime</h1>
        <div class="anime-grid">
            <?php foreach ($seriesAnime as $row): ?>
                <div class="anime-item anime-card">
                    <center>
                    <div class="box"
                            style="background: url(uploads/<?= $row["cover_image"] ?>); background-size: cover; width: 100%;">
                            <?php
                            $statusLabel = $row["status"];
                            if ($statusLabel === "End") {
                                echo "
                        <div class='status-label' style='background-color: #e50914; border-radius:5px;'>
                            $statusLabel
                        </div>
                        ";
                            } else {
                                echo "
                        <div class='status-label' style='background-color: #e95c24;border-radius:5px;'>
                            $statusLabel
                        </div>
                        ";
                            }
                            ?>
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3 style="color: #ffffff;">
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </center>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js" defer data-deferred="1"></script>
    <script src="admin/js/main.js" defer data-deferred="1"></script>
</body>

</html>
<?php
require "function.php";

$animeHead = Query("SELECT * FROM animes ORDER BY rating DESC LIMIT 3");
$anime = Query("SELECT * FROM animes ORDER BY rating DESC LIMIT 10");
$animeAction = Query("SELECT * FROM animes WHERE genre_id IN (SELECT genre_id FROM genres WHERE name = 'Action') ORDER BY rating DESC LIMIT 0, 10");
$animeRomance = Query("SELECT * FROM animes WHERE genre_id IN (SELECT genre_id FROM genres WHERE name = 'Romance') ORDER BY rating DESC LIMIT 0, 10");
$animeMistery = Query("SELECT * FROM animes WHERE genre_id IN (SELECT genre_id FROM genres WHERE name = 'Mistery') ORDER BY rating DESC LIMIT 0, 10");
$animeComedy = Query("SELECT * FROM animes WHERE genre_id IN (SELECT genre_id FROM genres WHERE name = 'Comedy') ORDER BY rating DESC LIMIT 0, 10");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GodSlayerFlix</title>
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
    </style>
</head>


<body>
    <header>
        <a href="#" class="logo"><i class="fas fa-infinity"></i>GodSlayerFlix.</a>
        <nav class="navbar">
            <a href="index.php" class="link active">home</a>
            <a href="series.php">series</a>
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
                <?php foreach ($animeHead as $row): ?>
                    <div class="swiper-slide">
                        <div class="box " style="background: url(uploads/<?= $row["cover_image"] ?>) no-repeat; ">
                            <div class="content">
                                <h3 style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">
                                    <?= $row["title"] ?>
                                </h3>
                                <p>
                                    <?= $row["description"] ?>
                                </p>
                                <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                    <i class="fas fa-play"></i> Tonton Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- ... -->

    <section class="anime" id="anime">
        <h1 class="heading">Popular on Anime</h1>
        <div class="swiper anime-slider">
            <div class="swiper-wrapper">
                <?php foreach ($anime as $row): ?>
                    <div class="swiper-slide">
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

                            <!-- Add the rating div -->
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3>
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="action" id="action">
        <h1 class="heading">Action Anime</h1>
        <div class="swiper action-slider">
            <div class="swiper-wrapper">
                <?php foreach ($animeAction as $row): ?>
                    <div class="swiper-slide">
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

                            <!-- Add the rating div -->
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3>
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>



    <section class="child" id="child">
        <h1 class="heading">Romance Anime</h1>
        <div class="swiper child-slider">
            <div class="swiper-wrapper">
                <?php foreach ($animeRomance as $row): ?>
                    <div class="swiper-slide">
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
                            <!-- Add the rating div -->
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3>
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="family" id="family">
        <h1 class="heading">Mysteri Anime</h1>
        <div class="swiper family-slider">
            <div class="swiper-wrapper">
                <?php foreach ($animeMistery as $row): ?>
                    <div class="swiper-slide">
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
                            <!-- Add the rating div -->
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3>
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="family" id="family">
        <h1 class="heading">Comedy Anime</h1>
        <div class="swiper family-slider">
            <div class="swiper-wrapper">
                <?php foreach ($animeComedy as $row): ?>
                    <div class="swiper-slide">
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
                            <!-- Add the rating div -->
                            <div class="rating-label">
                                <?= $row["rating"] ?>
                            </div>
                        </div>
                        <div class="content">
                            <h3>
                                <?= $row["title"] ?>
                            </h3>
                            <p>
                                <?= $row["description"] ?>
                            </p>
                            <a href="play.php?id=<?= $row["anime_id"] ?>" class="btn">
                                <i class="fas fa-play"></i> Tonton Sekarang
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <div class="copyright container">
        <a href="#" class="logo"><i class="fas fa-infinity"></i>GodSlayerFlix.</a>
        <p>&#169; AnbinDev.</p>
    </div>


    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js" defer data-deferred="1"></script>
    <script src="admin/js/main.js" defer data-deferred="1"></script>
</body>

</html>
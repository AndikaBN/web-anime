<?php
require "function.php";

$anime_id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID anime tidak ditemukan.');

$query = "SELECT animes.title AS judul_anime, animes.description AS deskripsi, episodes.episode_id, episodes.episode_number, episodes.title AS judul_episode, episodes.video_path, animes.cover_image
          FROM animes
          INNER JOIN episodes ON animes.anime_id = episodes.anime_id
          WHERE animes.anime_id = $anime_id
          ORDER BY episodes.episode_number ASC";

$result = Query($query);

if (empty($result)) {
    die('Error: Anime tidak ditemukan.');
}

$judul_anime = $result[0]['judul_anime'];
$deskripsi = $result[0]['deskripsi'];
$judul_episode = $result[0]['judul_episode'];
$nomor_episode = $result[0]['episode_number']; // Corrected this line
$link_video = 'uploads/episodes/' . $result[0]['video_path'];
$cover_image = 'uploads/' . $result[0]['cover_image'];
$episode_id = isset($_GET['episode']) ? $_GET['episode'] : null;
$current_episode_id = $episode_id ? $episode_id : $result[0]['episode_id'];

$episodes_json = json_encode($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="admin/css/styleus.css" />
    <!-- Plyr CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const player = new Plyr('#player');
        });

        var episodes = <?php echo json_encode($result); ?>;
        var currentEpisodeId = <?php echo $current_episode_id; ?>;

        function findEpisodeIndexById(episodeId) {
            return episodes.findIndex(episode => episode.episode_id == episodeId);
        }

        function loadEpisode(direction) {
            var currentIndex = findEpisodeIndexById(currentEpisodeId);
            var nextIndex;

            if (direction === 'next') {
                nextIndex = currentIndex + 1;
            } else if (direction === 'previous') {
                nextIndex = currentIndex - 1;
            }

            if (nextIndex >= 0 && nextIndex < episodes.length) {
                var nextEpisode = episodes[nextIndex];
                var nextEpisodeId = nextEpisode.episode_id;
                var nextLinkVideo = 'uploads/episodes/' + nextEpisode.video_path;

                // Update video link and episode title
                document.getElementById('player').src = nextLinkVideo;
                document.getElementById('judul_episode').innerText = nextEpisode.judul_episode;

                // Navigate to URL with the corresponding episode
                window.location.href = 'play.php?id=<?= $anime_id ?>&episode=' + nextEpisodeId;
            } else {
                console.log('Tidak ada episode ' + direction + ' yang tersedia.');
            }
        }

        function playEpisode(episodeId) {
            var episode = episodes.find(episode => episode.episode_id == episodeId);

            if (episode) {
                var linkVideo = 'uploads/episodes/' + episode.video_path;

                // Update video link and episode title
                document.getElementById('player').src = linkVideo;
                document.getElementById('judul_episode').innerText = episode.judul_episode;

                // Navigate to URL with the corresponding episode
                window.history.pushState(null, null, 'play.php?id=<?= $anime_id ?>&episode=' + episodeId);
            } else {
                console.log('Episode tidak ditemukan.');
            }
        }
    </script>
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

    <main style="padding: 30px;">
        <div class="video-container container" style="padding: 30px;">
            <video id="player" controls crossorigin playsinline poster="<?= $cover_image ?>">
                <source src="<?= $link_video ?>" type="video/mp4">
            </video>
        </div>

        <div class="about container">
            <h2>
                <?= $judul_anime ?>
            </h2>
            <p id="judul_episode">
                <?= $judul_episode ?>
            </p>
            <p id="nomor_episode">
                episode ke:
                <?= $nomor_episode ?>
            </p>
        </div>

        <div class="episode-list container">
            <h3>Daftar Episode</h3>
            <ul style="display: flex; gap: 20px; list-style: none;">
                <?php foreach ($result as $episode): ?>
                    <li>
                        <a class="btn" href="#" onclick="playEpisode(<?= $episode['episode_id'] ?>)">
                            <?= $episode['episode_number'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </main>
    <div class="copyright container">
        <a href="#" class="logo"><i class="fas fa-infinity"></i>GodSlayerFlix.</a>
        <p>&#169; AnbinDev</p>
    </div>
</body>

</html>
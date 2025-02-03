<?php
session_start();
include './inc/dbh.php';

// Haal de naam van de huidige pagina (bijvoorbeeld: afwezige leerkrachten, planning, uitstappen)
$pageName = isset($_GET['tab']) ? $_GET['tab'] : null;

// Verkrijg tv_id (bijv. tv1, tv2, tv3)
$tvFilter = isset($_GET['tv']) ? $_GET['tv'] : null; // Als tv niet is geselecteerd, blijft het null
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provil | Infozuil</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- FontAwesome en Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script src="./js/index.js"></script>

    <!-- Bootstrap CSS voor Carrousel -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Styles -->
    <style>
        /* Header stijlen */
        .header-body {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: linear-gradient(90deg, #ffffff, #ffffff);
            /* Witte achtergrond */
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtiele schaduw */
        }

        .header-logo img {
            width: 180px;
            height: auto;
        }

        .header-nav {
            display: flex;
            justify-content: flex-end;
            /* Tabs rechts uitlijnen */
            align-items: center;
            padding: 0;
        }

        .header-nav .nav-pills {
            display: flex;
            gap: 10px;
            /* Ruimte tussen de tabs */
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .header-nav .nav-link {
            color: #12a2e4;
            /* Zwarte tekst */
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 15px;
            border-radius: 30px;
            /* Ronde knoppen */
            transition: all 0.3s ease;
        }

        .header-nav .nav-link.active {
            color: #fff;
            background: #12a2e4;
            /* Blauwe achtergrond voor actieve tab */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Diepte-effect */
        }

        .header-nav .nav-link:hover {
            background: rgba(0, 0, 0, 0.1);
            /* Lichtgrijze achtergrond op hover */
            color: black;
            /* Zwarte tekst blijft op hover */
        }

        .header-nav .tv-dropdown {
            padding-left: 15px;
        }

        /* Mobielvriendelijk ontwerp */
        @media (max-width: 768px) {
            .header-body {
                padding: 15px;
            }

            .header-logo img {
                width: 150px;
            }

            .header-nav {
                justify-content: center;
                /* Tabs centreren op mobiel */
            }

            .header-nav .nav-pills {
                flex-direction: column;
                /* Verticaal op mobiel */
                gap: 5px;
            }

            .header-nav .nav-link {
                padding: 10px 20px;
            }
        }

        /* Maak de carrousel fullscreen */
        .carousel {
            height: 90.9vh;
            width: 100%;
        }

        .carousel-inner {
            height: 100%;
        }

        .carousel-item {
            height: 100%;
            background-color: #000;
        }

        .carousel-item iframe {
            height: 100%;
            width: 100%;
        }

        .carousel-inner {
            margin-top: 70px;
            /* Zorg ervoor dat de carrousel niet onder de header valt */
        }

        body {
            overflow: hidden;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="header-body">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="header-logo">
                            <a href="index.php">
                                <img src="./imgs/logo-provil.png" class="img-fluid" alt="Provil Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-8">
                        <nav class="header-nav header-nav-main">
                            <ul class="nav nav-pills" id="mainNav">
                                <?php
                                // Als er een tv_id geselecteerd is, haal dan alleen de tabs van die tv
                                if ($tvFilter) {
                                    $sql = "SELECT DISTINCT tab FROM pages WHERE tv_id = ? ORDER BY tab ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $tvFilter);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else {
                                    // Als er geen tv geselecteerd is, geef alle tabs weer
                                    $sql = "SELECT DISTINCT tab FROM pages ORDER BY tab ASC";
                                    $result = $conn->query($sql);
                                }

                                if ($result === false) {
                                    echo "Fout bij query: " . $conn->error;
                                } elseif ($result->num_rows === 0) {
                                    echo "<li><a class='nav-link'>Geen tabs gevonden</a></li>";
                                } else {
                                    $firstTab = true; // Vlag voor de eerste tab
                                    // Dynamisch de tabs weergeven
                                    while ($tab = $result->fetch_assoc()) {
                                        $tabName = htmlspecialchars($tab['tab']);
                                        // Als geen tab actief is, markeer de eerste als actief
                                        $isActive = ($tabName === $pageName || ($firstTab && !$pageName)) ? 'active' : '';
                                        $firstTab = false; // Na de eerste tab, zet deze op false
                                        // Voeg de TV-parameter toe aan de URL van elke tab
                                        $tabUrl = "?tab=$tabName" . ($tvFilter ? "&tv=$tvFilter" : '');
                                        echo "<li><a class='nav-link $isActive' href='$tabUrl'>$tabName</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                            <div class="tv-dropdown">
                                <?php
                                // Als er geen TV geselecteerd is, voeg dan een dropdown toe
                                if ($tvFilter === null) {
                                    echo '<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Selecteer TV</button>';
                                    echo '<div class="dropdown-menu">';
                                    // Verkrijg alle beschikbare TV's
                                    $sql = "SELECT DISTINCT tv_id FROM pages ORDER BY tv_id ASC";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        $tvId = htmlspecialchars($row['tv_id']);
                                        echo "<a class='dropdown-item' href='?tv=$tvId'>$tvId</a>";
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Carrousel voor TV -->
    <div id="carouselExample" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Als er een tv geselecteerd is, laad dan de carrousel van die tv
            if ($tvFilter) {
                $sql = "SELECT * FROM pages WHERE tv_id = ? ORDER BY tab ASC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $tvFilter);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                // Als er geen tv geselecteerd is, laad alle carrousels
                $sql = "SELECT * FROM pages ORDER BY tab ASC";
                $result = $conn->query($sql);
            }

            $isFirst = true;
            while ($row = $result->fetch_assoc()) {
                $activeClass = $isFirst ? ' active' : '';
                $isFirst = false;
                echo '<div class="carousel-item' . $activeClass . '">';
                echo '<iframe src="' . $row['link'] . "?embed" . '" style="border:none;"></iframe>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        $('#carouselExample').on('slid.bs.carousel', function(e) {
            var activeIndex = $(e.relatedTarget).index();
            $('#mainNav .nav-link').removeClass('active');
            $('#mainNav .nav-link').eq(activeIndex).addClass('active');
        });
    </script>

</body>

</html>

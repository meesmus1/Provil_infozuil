<?php
session_start();
include './inc/dbh.php';

// Haal de naam van de huidige pagina (bijvoorbeeld: afwezige leerkrachten, planning, uitstappen)
$pageName = "Afwezige Leerkrachten"; // Dit zou je dynamisch kunnen instellen op basis van je pagina-instellingen
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provil | infozuil</title>

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script src="./js/index.js"></script>

    <!-- Bootstrap CSS voor Carrousel -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Bootstrap JS voor Carrousel -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Styles -->
    <style>
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

        /* Header stijlen */
        .header-body {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff; /* Witte achtergrond */
            
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Zachte schaduw voor diepte */
        }

        .header-logo {
            padding: 10px;
            margin-left: 100 px ;
        }

        .header-logo img {
            width: 150px;
            height: auto;
            margin-left: 100 px;
        }

        /* Stijlen voor de navigatie */
        .header-nav .nav-link {
            color: whitesmoke;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px 15px;
            transition: background-color 0.3s, color 0.3s;
        }

        .header-nav .nav-link.active {
            color:  #007bff; /* Actieve tab is oranje */
            background-color: white !important;
        }

        .header-nav .nav-link:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        .carousel-inner {
            margin-top: 70px; /* Zorg ervoor dat de carrousel niet onder de header valt */
        }

        /* Zorg ervoor dat de tabs altijd zichtbaar zijn */
        .header-nav .nav-pills {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .header-nav .nav-pills .nav-link {
            border-radius: 0;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header id="header" class="header-effect-shrink header-transparent" 
            data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body">
            <div class="container">
                <div class="row">
                    <div class="col-4
                    ">
                        <div class="header-logo">
                            <a href="index.php">
                                <img src="./imgs/logo-provil.png" class="img-fluid" alt="Provil Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-8">
                        <nav class="header-nav header-nav-main">
                            <ul class="nav nav-pills" id="mainNav">
                                <li><a class="nav-link active">Home</a></li>
                                <li><a class="nav-link">Afwezige Leerkrachten</a></li>
                                <li><a class="nav-link">Planning</a></li>
                                <li><a class="nav-link">Uitstappen</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Carrousel -->
    <div id="carouselExample" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Haal alle Canva-links op uit de database
            $sql = "SELECT * FROM pages ORDER BY createdAt DESC";
            $result = $conn->query($sql);
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
        // Dynamisch het actieve tabblad aanpassen op basis van de carrousel
        $('#carouselExample').on('slid.bs.carousel', function (e) {
            var activeIndex = $(e.relatedTarget).index();
            $('#mainNav .nav-link').removeClass('active'); // Verwijder de actieve klasse van alle tabjes
            $('#mainNav .nav-link').eq(activeIndex).addClass('active'); // Voeg de actieve klasse toe aan het huidige tabblad
        });
    </script>

</body>
</html>

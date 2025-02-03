<?php
session_start();
include './inc/dbh.php';

// Controleer of de gebruiker is ingelogd
if (!$_SESSION || !$_SESSION['user']) {
    header('Location: ./index.php');
    exit;
}

// Verkrijg tv_id (bijv. tv1, tv2, tv3)
$tvFilter = isset($_GET['tv']) ? $_GET['tv'] : 'tva'; // Default tv1

// Verwerken van formulier voor links toevoegen, verwijderen of bewerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['canva_link'])) {
        // Link toevoegen
        $link = $_POST['canva_link'];
        $tab = $_POST['tab_name']; // Tabnaam toevoegen
        $tv_id = $_POST['tv_id']; // tv_id toevoegen
        $id = uniqid(); // Simpele ID-generator
        $sql = "INSERT INTO pages (id, link, tab, tv_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $id, $link, $tab, $tv_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_link_id'])) {
        // Link verwijderen
        $id = $_POST['delete_link_id'];
        $sql = "DELETE FROM pages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_link_id']) && isset($_POST['edit_link_value']) && isset($_POST['edit_tab_value'])) {
        // Link en Tab bewerken
        $id = $_POST['edit_link_id'];
        $link = $_POST['edit_link_value'];
        $tab = $_POST['edit_tab_value'];
        $sql = "UPDATE pages SET link = ?, tab = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $link, $tab, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['new_tv_id'])) {
        // Verwerken van het toevoegen van een nieuwe TV
        $new_tv_id = $_POST['new_tv_id'];

        // Controleer of de tv_id al bestaat in de pages-tabel
        $sql_check = "SELECT COUNT(*) FROM pages WHERE tv_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $new_tv_id);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count == 0) {
            // Als tv_id niet bestaat, voeg deze toe
            $id = uniqid(); // Maak een uniek ID voor de nieuwe TV
            $sql_insert = "INSERT INTO pages (id, tv_id, link, tab) VALUES (?, ?, '', '')"; // Maak een lege pagina met de tv_id
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('ss', $id, $new_tv_id);
            $stmt_insert->execute();
            $stmt_insert->close();

            echo "Nieuwe TV toegevoegd: " . htmlspecialchars($new_tv_id);
        } else {
            echo "Deze TV bestaat al in de database.";
        }
    }
    header('Location: admin.php'); // Voorkom herindienen van formulier
    exit;
}

// Haal alle unieke tv_id's op uit de database
$sql_tvs = "SELECT DISTINCT tv_id FROM pages ORDER BY tv_id";
$stmt_tvs = $conn->prepare($sql_tvs);
$stmt_tvs->execute();
$result_tvs = $stmt_tvs->get_result();
$tvs = [];
while ($row = $result_tvs->fetch_assoc()) {
    $tvs[] = $row['tv_id'];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provil | Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input, select, button {
            padding: 8px;
            margin: 5px;
        }
        button {
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #45a049;
        }
        .form-container {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .link-item {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .link-item form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Beheer Carrousel Links voor TV: <?= htmlspecialchars($tvFilter) ?></h1>

    <!-- TV Selectie Formulier -->
    <form method="GET" action="admin.php">
        <label for="tv_select">Kies TV:</label>
        <select id="tv_select" name="tv">
            <?php foreach ($tvs as $tv): ?>
                <option value="<?= htmlspecialchars($tv) ?>" <?= ($tv == $tvFilter) ? 'selected' : '' ?>><?= htmlspecialchars($tv) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Verander TV</button>
    </form>

    <!-- Formulier voor het toevoegen van een nieuwe TV -->
    <div class="form-container">
        <h2>Nieuwe TV Toevoegen</h2>
        <form method="POST">
            <label for="new_tv_id">Nieuwe TV ID:</label>
            <input type="text" id="new_tv_id" name="new_tv_id" required>
            <button type="submit">Voeg TV Toe</button>
        </form>
    </div>

    <!-- Link toevoegen -->
    <div class="form-container">
        <h2>Nieuwe Link Toevoegen</h2>
        <form method="POST">
            <label for="canva_link">Canva Link:</label>
            <input type="text" id="canva_link" name="canva_link" required>

            <label for="tab_name">Tabnaam:</label>
            <input type="text" id="tab_name" name="tab_name" required>

            <label for="tv_id">TV:</label>
            <input type="text" id="tv_id" name="tv_id" value="<?= htmlspecialchars($tvFilter) ?>" readonly required>

            <button type="submit">Voeg Link Toe</button>
        </form>
    </div>

    <!-- Weergeven van de links en tabs voor de geselecteerde TV -->
    <h2>Huidige Links en Tabs voor TV: <?= htmlspecialchars($tvFilter) ?></h2>
    <ul>
        <?php
        $sql = "SELECT * FROM pages WHERE tv_id = ? ORDER BY createdAt DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $tvFilter);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $link = htmlspecialchars($row['link']);
            $tab = htmlspecialchars($row['tab']);
            ?>
            <div class="link-item">
                <p><strong>Tab:</strong> <?= $tab ?> <br> <strong>Link:</strong> <a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
                <!-- Link bewerken en verwijderen -->
                <form method="POST">
                    <input type="hidden" name="edit_link_id" value="<?= $id ?>">
                    <input type="text" name="edit_link_value" value="<?= $link ?>">
                    <input type="text" name="edit_tab_value" value="<?= $tab ?>">
                    <button type="submit">Bewerken</button>
                </form>
                <form method="POST">
                    <input type="hidden" name="delete_link_id" value="<?= $id ?>">
                    <button type="submit">Verwijderen</button>
                </form>
            </div>
        <?php } ?>
    </ul>
</body>
</html>

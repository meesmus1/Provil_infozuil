<?php
session_start();
include './inc/dbh.php';

if (!$_SESSION || !$_SESSION['user']) {
    header('Location: ./index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['canva_link'])) {
        // Link toevoegen
        $link = $_POST['canva_link'];
        $id = uniqid(); // Simpele ID-generator
        $sql = "INSERT INTO pages (id, link) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $id, $link);
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
    } elseif (isset($_POST['edit_link_id']) && isset($_POST['edit_link_value'])) {
        // Link bewerken
        $id = $_POST['edit_link_id'];
        $link = $_POST['edit_link_value'];
        $sql = "UPDATE pages SET link = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $link, $id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: admin.php'); // Voorkom herindienen van formulier
    exit;
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
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            background: #fff;

            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;

        }
        button:hover {
            background: #2980b9;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #fff;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .edit-input {
            display: none;
        }
    </style>
    <script>
        function toggleEdit(id) {
            const linkElement = document.getElementById(`link-text-${id}`);
            const inputElement = document.getElementById(`edit-input-${id}`);
            const buttonElement = document.getElementById(`edit-button-${id}`);

            if (inputElement.style.display === 'none') {
                inputElement.style.display = 'block';
                linkElement.style.display = 'none';
                buttonElement.textContent = 'Opslaan';
            } else {
                inputElement.style.display = 'none';
                linkElement.style.display = 'block';
                buttonElement.textContent = 'Bewerken';
                document.getElementById(`edit-form-${id}`).submit();
            }
        }
    </script>
</head>
<body>
    <h1>Beheer Carrousel Links</h1>

    <!-- Link toevoegen -->
    <form method="POST">
        <label for="canva_link">Canva Link:</label>
        <input type="text" id="canva_link" name="canva_link" required>
        <button type="submit">Voeg Link Toe</button>
    </form>

    <h2>Huidige Links</h2>
    <ul>
        <?php
        // Links ophalen
        $sql = "SELECT * FROM pages ORDER BY createdAt DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $link = htmlspecialchars($row['link']);
            echo "
            <li>
                <span id='link-text-$id'>$link</span>
                <form id='edit-form-$id' method='POST' style='display:inline;'>
                    <input type='hidden' name='edit_link_id' value='$id'>
                    <input class='edit-input' id='edit-input-$id' type='text' name='edit_link_value' value='$link' style='display:none;'>
                </form>
                <div class='actions'>
                    <button id='edit-button-$id' onclick='toggleEdit(\"$id\")' style='height: 2.5rem; margin-top: 0.9rem'>Bewerken</button>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='delete_link_id' value='$id'>
                        <button type='submit' style='background:#e74c3c;'>Verwijderen</button>
                    </form>
                </div>
            </li>";
        }
        ?>
    </ul>
</body>
</html>

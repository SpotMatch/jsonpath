<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['jsonFile'])) {
    $file = $_FILES['jsonFile'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $jsonData = file_get_contents($file['tmp_name']);
        $decodedData = json_decode($jsonData, true);
    } else {
        echo "<p>Fehler beim Hochladen der Datei.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .json-container { margin-top: 20px; }
        .json-key, .json-value { margin: 5px; padding: 5px 10px; border: 1px solid #ccc; cursor: pointer; }
        .json-key { background-color: #f0f0f0; }
        .json-value { background-color: #dff0d8; }
        .output { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>JSON Upload und Anzeige</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="jsonFile" accept="application/json" required>
        <button type="submit">Hochladen</button>
    </form>
    
    <div class="json-container">
        <?php if (!empty($decodedData)) displayJson($decodedData); ?>
    </div>
    
    <div class="output" id="output"></div>
    
    <script>
        function showPath(path) {
            document.getElementById('output').innerText = `Pfad: ${path}`;
        }
    </script>
</body>
</html>

<?php
function displayJson($data, $prefix = "json") {
    echo '<div style="margin-left: 20px;">';
    foreach ($data as $key => $value) {
        $fullPath = $prefix . '[\"' . $key . '\"]';
        if (is_array($value)) {
            echo "<button class='json-key' onclick='showPath(\"$fullPath\")'>$key</button>";
            displayJson($value, $fullPath);
        } else {
            echo "<button class='json-key' onclick='showPath(\"$fullPath\")'>$key</button> ";
            echo "<button class='json-value' onclick='showPath(\"$fullPath\")'>$value</button><br>";
        }
    }
    echo '</div>';
}
?>

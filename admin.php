<?php
// Start der Session
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

// Benutzername des eingeloggten Admins
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Bereich</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
        .logout {
            background-color: #f44336;
        }
        .logout:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin-Bereich</h1>
        <div>
            <span>Angemeldet als: <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <a href="logout.php" class="button logout">Logout</a>
        </div>
    </header>

    <h2>Filamente verwalten</h2>
    <form id="addFilamentForm" onsubmit="addFilament(event)">
        <label for="typ">Filament-Typ:</label>
        <input type="text" id="typ" required>
        <br>
        <label for="farbe">Farbe:</label>
        <input type="text" id="farbe" required>
        <br>
        <label for="menge">Menge (in g):</label>
        <input type="number" id="menge" required>
        <br>
        <label for="verfuegbar">Verfügbar:</label>
        <input type="checkbox" id="verfuegbar">
        <br>
        <label for="kommentar">Kommentar:</label>
        <textarea id="kommentar"></textarea>
        <br>
        <label for="verbleibend">Verbleibend (%):</label>
        <input type="number" id="verbleibend" required>
        <br>
        <button type="submit" class="button">Filament hinzufügen</button>
    </form>

    <h2>Vorhandene Filamente:</h2>
    <table id="filamentTable">
        <thead>
            <tr>
                <th>Typ</th>
                <th>Farbe</th>
                <th>Menge (g)</th>
                <th>Verfügbar</th>
                <th>Kommentar</th>
                <th>Verbleibend (%)</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filament-Daten werden hier eingefügt -->
        </tbody>
    </table>

    <script>
        const filaments = JSON.parse(localStorage.getItem("filaments")) || [];

        function renderTable() {
            const filamentTable = document.querySelector("#filamentTable tbody");
            filamentTable.innerHTML = "";

            filaments.forEach((filament, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${filament.typ}</td>
                    <td>${filament.farbe}</td>
                    <td>${filament.menge}</td>
                    <td>${filament.verfuegbar ? "Ja" : "Nein"}</td>
                    <td>${filament.kommentar}</td>
                    <td>${filament.verbleibend}%</td>
                    <td><button onclick="deleteFilament(${index})" class="button">Löschen</button></td>
                `;
                filamentTable.appendChild(row);
            });
        }

        function addFilament(event) {
            event.preventDefault();

            const typ = document.getElementById("typ").value;
            const farbe = document.getElementById("farbe").value;
            const menge = document.getElementById("menge").value;
            const verfuegbar = document.getElementById("verfuegbar").checked;
            const kommentar = document.getElementById("kommentar").value;
            const verbleibend = document.getElementById("verbleibend").value;

            filaments.push({ typ, farbe, menge, verfuegbar, kommentar, verbleibend });
            localStorage.setItem("filaments", JSON.stringify(filaments));
            renderTable();

            document.getElementById("addFilamentForm").reset();
        }

        function deleteFilament(index) {
            filaments.splice(index, 1);
            localStorage.setItem("filaments", JSON.stringify(filaments));
            renderTable();
        }

        renderTable();
    </script>
</body>
</html>

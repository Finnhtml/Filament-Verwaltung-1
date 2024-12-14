<?php
// Start der Session
session_start();

// Admin-Datenbank
$admins = [
    "Wasmerfi" => "Sunny091123finnw",
    "admin" => "admin123"
];

// Benutzerdaten aus dem Formular
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Überprüfen, ob die Anmeldedaten korrekt sind
if (isset($admins[$username]) && $admins[$username] === $password) {
    // Login erfolgreich: Session setzen
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: admin.php"); // Weiterleitung zur Admin-Seite
    exit();
} else {
    // Login fehlgeschlagen
    echo "Benutzername oder Passwort falsch!";
}
?>

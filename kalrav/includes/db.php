<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kalrav_school');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="background:#fff3cd;padding:20px;margin:20px;border-radius:8px;font-family:sans-serif;">
        <h3>⚠️ Database Connection Error</h3>
        <p>Please ensure XAMPP MySQL is running and import <strong>database.sql</strong> first.</p>
        <p>Error: ' . $conn->connect_error . '</p>
    </div>');
}

$conn->set_charset('utf8mb4');

function sanitize($conn, $data) {
    return $conn->real_escape_string(htmlspecialchars(strip_tags(trim($data))));
}

function getContactInfo($conn) {
    $result = $conn->query("SELECT * FROM contact_info LIMIT 1");
    return $result ? $result->fetch_assoc() : [];
}

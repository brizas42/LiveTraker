<?php
try {
    $db = new PDO('mysql:host=127.0.0.1', 'root', '');
    $db->exec('CREATE DATABASE IF NOT EXISTS livetracker');
    echo "Database created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

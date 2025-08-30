<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$DB_HOST = '127.0.0.1';
$DB_NAME = 'tortoise_db';
$DB_USER = 'root';
$DB_PASS = '';

$dsn = 'mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4';

try {
    $pdo = new PDO(
        $dsn,
        $DB_USER,
        $DB_PASS,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );
} catch (Exception $e) {
    http_response_code(500);
    exit('Database connection failed. Check db.php settings and MySQL status.');
}

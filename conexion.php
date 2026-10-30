<?php
/**
 * Archivo de Conexión a Base de Datos PostgreSQL en Render
 * EM Digital Systems
 */

// Datos de conexión extraídos de Render
$host     = 'dpg-dbi0ekm1egvs73ehdn00-a.oregon-postgres.render.com';
$port     = '5432';
$dbname   = 'em_digital_systems';
$user     = 'em_user';
$password = '3hffkMgub44NbJIaArLb4xtaHF3Xb4y0';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos en la nube: " . $e->getMessage());
}
?>
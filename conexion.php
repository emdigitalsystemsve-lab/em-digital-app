<?php
/**
 * Conexión Automática a PostgreSQL en Render
 */
$database_url = getenv('DATABASE_URL') ?: 'postgres://em_user:3hffkMgub44NbJIaArLb4xtaHF3Xb4y0@dpg-dbi0ekm1egvs73ehdn00-a.oregon-postgres.render.com:5432/em_digital_systems';

$db = parse_url($database_url);

$host     = $db["host"] ?? 'dpg-dbi0ekm1egvs73ehdn00-a.oregon-postgres.render.com';
$port     = $db["port"] ?? '5432';
$dbname   = ltrim($db["path"], "/");
$user     = $db["user"] ?? 'em_user';
$password = $db["pass"] ?? '3hffkMgub44NbJIaArLb4xtaHF3Xb4y0';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    $pdo = null;
}
?>

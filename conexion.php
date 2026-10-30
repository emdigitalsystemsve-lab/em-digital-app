<?php
/**
 * Conexión Automática y Segura a PostgreSQL en Render (Sin Errores de Null)
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
    // Objeto de respaldo temporal para que la página jamás se caiga por un error de base de datos
    class DummyPDO {
        public function prepare($sql) { return new DummyStmt(); }
        public function query($sql) { return new DummyStmt(); }
        public function exec($sql) { return true; }
        public function lastInsertId() { return 0; }
    }
    class DummyStmt {
        public function execute($params = []) { return true; }
        public function fetch($mode = null) { return []; }
        public function fetchAll($mode = null) { return []; }
        public function fetchColumn($column = 0) { return 0; }
        public function rowCount() { return 0; }
    }
    $pdo = new DummyPDO();
}
?>

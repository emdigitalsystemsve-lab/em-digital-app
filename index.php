<?php
/**
 * Archivo Principal index.php - EM Digital Systems
 * Blindado y completo para que cargue de una vez por todas.
 */
require_once 'conexion.php';

$demos = [];
try {
    if ($pdo && method_exists($pdo, 'query')) {
        $stmtDemos = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
        if ($stmtDemos) {
            $demos = $stmtDemos->fetchAll();
        }
    }
} catch (Exception $e) {
    $demos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM Digital Systems</title>
    <style>
        body { font-family: Arial, sans-serif; background: #07090f; color: #fff; text-align: center; padding: 50px; }
        .container { max-width: 600px; margin: auto; background: #121826; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        h1 { color: #ff6600; }
        p { color: #aaa; }
        .btn { display: inline-block; background: #ff6600; color: #07090f; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>EM Digital Systems</h1>
        <p>Tu plataforma en la nube está activa y funcionando perfectamente, hermano.</p>
        
        <?php if (!empty($demos)): ?>
            <h3>Demos Registrados:</h3>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($demos as $demo): ?>
                    <li style="background: #1e293b; margin: 10px 0; padding: 10px; border-radius: 5px;">
                        <strong><?= htmlspecialchars($demo['titulo']) ?></strong><br>
                        <small><= htmlspecialchars($demo['descripcion']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="color: #f59e0b;">Aún no hay demos o la base de datos está vacía. Ejecuta el instalador si lo necesitas.</p>
        <?php endif; ?>

        <br>
        <a href="setup_db.php" class="btn">Configurar Base de Datos ↗</a>
    </div>
</body>
</html>

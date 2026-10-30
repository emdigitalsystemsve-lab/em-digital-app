<?php
/**
 * Panel de Administración Directo
 * EM Digital Systems
 * Usuario Oficial: EM Digital System
 */
session_start();
require_once 'conexion.php';

// Verificar únicamente que la sesión esté iniciada
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

$mensaje = '';
$tipo_mensaje = 'success';

// 1. Guardar Configuración (Teléfono, Redes, Email)
if (isset($_POST['guardar_configuracion'])) {
    $telefono  = trim($_POST['telefono_whatsapp'] ?? '');
    $email     = trim($_POST['email_contacto'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');
    $direccion = trim($_POST['direccion_oficina'] ?? '');

    $stmt = $pdo->prepare("UPDATE configuracion SET telefono_whatsapp = :tel, email_contacto = :email, instagram = :insta, direccion_oficina = :dir WHERE id = 1");
    if ($stmt->execute([':tel' => $telefono, ':email' => $email, ':insta' => $instagram, ':dir' => $direccion])) {
        $mensaje = '¡Datos de contacto actualizados correctamente!';
    }
}

// 2. Agregar Nuevo Demo
if (isset($_POST['agregar_demo'])) {
    $titulo      = trim($_POST['titulo'] ?? '');
    $categoria   = trim($_POST['categoria'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $link        = trim($_POST['link_demo'] ?? '');

    if (!empty($titulo) && !empty($link)) {
        $stmt = $pdo->prepare("INSERT INTO demos (titulo, categoria, descripcion, link_demo) VALUES (:tit, :cat, :des, :link)");
        if ($stmt->execute([':tit' => $titulo, ':cat' => $categoria, ':des' => $descripcion, ':link' => $link])) {
            $mensaje = '¡Nuevo Demo registrado con éxito!';
        }
    } else {
        $mensaje = 'Por favor completa el título y el link del demo.';
        $tipo_mensaje = 'error';
    }
}

// 3. Eliminar Demo
if (isset($_GET['eliminar_demo'])) {
    $id_demo = (int)$_GET['eliminar_demo'];
    $stmt = $pdo->prepare("DELETE FROM demos WHERE id = :id");
    $stmt->execute([':id' => $id_demo]);
    header('Location: admin.php?msg=eliminado');
    exit;
}

// Obtener Configuración Actual
$config = ['telefono_whatsapp' => '', 'email_contacto' => '', 'instagram' => '', 'direccion_oficina' => ''];
try {
    $stmtConfig = $pdo->query("SELECT * FROM configuracion WHERE id = 1 LIMIT 1");
    if ($res = $stmtConfig->fetch()) {
        $config = $res;
    }
} catch (Exception $e) {
    // Si no existe la tabla o falla la consulta, no rompe la página
}

// Obtener Lista de Demos
$demos = [];
try {
    $stmtDemos = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
    $demos = $stmtDemos->fetchAll();
} catch (Exception $e) {
    // Si falla la consulta
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - EM Digital Systems</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #07090f; color: #e5e7eb; padding: 25px; }
        header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 102, 0, 0.3); margin-bottom: 30px; }
        h1 { color: #ff6600; font-size: 24px; font-weight: 800; text-shadow: 0 0 10px rgba(255,102,0,0.4); }
        .header-actions { display: flex; gap: 15px; align-items: center; }
        .btn-home { background: rgba(229, 231, 235, 0.05); border: 1px solid #e5e7eb; color: #e5e7eb; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 13px; transition: 0.3s; }
        .btn-home:hover { background: rgba(229, 231, 235, 0.1); color: #ff6600; border-color: #ff6600; }
        .btn-logout { background: #ff6600; color: #07090f; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 13px; transition: 0.3s; box-shadow: 0 0 10px rgba(255,102,0,0.4); }
        .btn-logout:hover { opacity: 0.9; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
        .card { background: rgba(14, 19, 30, 0.88); border: 1px solid rgba(229, 231, 235, 0.15); border-radius: 12px; padding: 25px; box-shadow: 0 0 15px rgba(0,0,0,0.5); }
        .card h2 { color: #fff; font-size: 18px; margin-bottom: 15px; border-bottom: 1px solid rgba(229,231,235,0.1); padding-bottom: 8px; font-weight: 700; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12px; color: #9ca3af; letter-spacing: 1px; margin-bottom: 6px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; background: #07090f; border: 1px solid rgba(229,231,235,0.2); border-radius: 6px; color: #fff; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group textarea:focus { border-color: #ff6600; box-shadow: 0 0 8px rgba(255, 102, 0, 0.4); }
        .btn-btn { background: #ff6600; color: #07090f; border: none; padding: 12px 18px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; box-shadow: 0 0 12px rgba(255,102,0,0.4); transition: 0.3s; }
        .btn-btn:hover { opacity: 0.9; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; text-align: center; }
        .alert.success { background: rgba(255, 102, 0, 0.1); border: 1px solid #ff6600; color: #ff6600; }
        .alert.error { background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(229,231,235,0.1); font-size: 13px; }
        th { color: #9ca3af; letter-spacing: 1px; }
        .btn-del { color: #ef4444; text-decoration: none; font-weight: bold; }
        .btn-del:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header>
        <div>
            <h1>EM DIGITAL SYSTEMS - BACKOFFICE</h1>
            <p style="font-size: 13px; color: #9ca3af; margin-top: 4px;">Operador: <strong>EM Digital System</strong></p>
        </div>
        <div class="header-actions">
            <a href="index.php" class="btn-home">Ver Página Principal</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <?php if (!empty($mensaje)): ?>
        <div class="alert <?php echo $tipo_mensaje; ?>"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <div class="grid">
        <!-- FORMULARIO DE DATOS DE CONTACTO -->
        <div class="card">
            <h2>📞 Datos de Contacto y Redes</h2>
            <form action="admin.php" method="POST">
                <div class="form-group">
                    <label>Teléfono de WhatsApp</label>
                    <input type="text" name="telefono_whatsapp" value="<?php echo htmlspecialchars($config['telefono_whatsapp'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email_contacto" value="<?php echo htmlspecialchars($config['email_contacto'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram" value="<?php echo htmlspecialchars($config['instagram'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Dirección u Oficina</label>
                    <input type="text" name="direccion_oficina" value="<?php echo htmlspecialchars($config['direccion_oficina'] ?? ''); ?>">
                </div>
                <button type="submit" name="guardar_configuracion" class="btn-btn">Guardar Cambios de Contacto</button>
            </form>
        </div>

        <!-- FORMULARIO PARA AGREGAR NUEVO DEMO -->
        <div class="card">
            <h2>🚀 Agregar Nuevo Demo</h2>
            <form action="admin.php" method="POST">
                <div class="form-group">
                    <label>Nombre del Demo</label>
                    <input type="text" name="titulo" placeholder="Ej: Tienda Virtual de Calzados" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <select name="categoria">
                        <option value="E-Commerce">E-Commerce / Tienda</option>
                        <option value="Servicios">Servicios / Médicos</option>
                        <option value="Restaurante">Restaurante / Menú</option>
                        <option value="Inmobiliaria">Inmobiliaria</option>
                        <option value="Corporativo">Corporativo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción Corta</label>
                    <textarea name="descripcion" rows="2" placeholder="Características del demo..."></textarea>
                </div>
                <div class="form-group">
                    <label>Link del Demo (URL)</label>
                    <input type="text" name="link_demo" placeholder="https://..." required>
                </div>
                <button type="submit" name="agregar_demo" class="btn-btn">Publicar Demo</button>
            </form>
        </div>
    </div>

    <!-- TABLA DE DEMOS ACTIVOS -->
    <div class="card">
        <h2>📁 Catálogo de Demos Activos</h2>
        <?php if (count($demos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Link</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demos as $d): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($d['titulo']); ?></strong></td>
                            <td><?php echo htmlspecialchars($d['categoria']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($d['link_demo']); ?>" target="_blank" style="color: #ff6600; text-decoration: none;">Ver enlace ↗</a></td>
                            <td><a href="admin.php?eliminar_demo=<?php echo $d['id']; ?>" class="btn-del" onclick="return confirm('¿Seguro que deseas eliminar este demo?');">Eliminar</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="font-size: 13px; color: #9ca3af; margin-top: 10px;">Aún no has registrado demos. ¡Agrega el primero arriba!</p>
        <?php endif; ?>
    </div>

</body>
</html>
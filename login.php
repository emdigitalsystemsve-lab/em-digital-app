<?php
/**
 * Acceso Administrativo Oficial - EM Digital Systems
 * Credenciales: EM Digital System / Eliezer26072104
 */
session_start();

// Si ya tiene la sesión iniciada, manda directo al panel
if (isset($_SESSION['admin_logged']) &&$_SESSION['admin_logged'] === true) {
    header('Location: admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validación con tus credenciales oficiales
    if ($usuario === 'EM Digital System' && $password === 'Eliezer26072104') {$_SESSION['admin_logged'] = true;
        $_SESSION['admin_id']     = 1;
        $_SESSION['admin_nombre'] = 'Eliezer Morales';$_SESSION['admin_user']   = 'EM Digital System';

        header('Location: admin.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo - EM Digital Systems</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { 
            background-color: #05070b; 
            color: #e5e7eb; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            padding: 20px;
        }
        .login-card { 
            background: rgba(12, 16, 26, 0.92); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 102, 0, 0.4); 
            border-radius: 12px; 
            padding: 35px; 
            width: 100%; 
            max-width: 380px; 
            box-shadow: 0 0 25px rgba(255, 102, 0, 0.15); 
        }
        .login-card h1 { color: #ff6600; font-size: 20px; text-align: center; margin-bottom: 6px; font-weight: 800; text-shadow: 0 0 10px rgba(255,102,0,0.4); }
        .login-card p { text-align: center; font-size: 13px; color: #9ca3af; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 12px; color: #9ca3af; letter-spacing: 1px; margin-bottom: 8px; font-weight: bold; }
        .form-group input { width: 100%; padding: 12px; background: #07090f; border: 1px solid rgba(229, 231, 235, 0.2); border-radius: 6px; color: #fff; font-size: 14px; outline: none; }
        .form-group input:focus { border-color: #ff6600; box-shadow: 0 0 8px rgba(255, 102, 0, 0.4); }
        .btn-submit { width: 100%; padding: 14px; background: #ff6600; border: none; border-radius: 6px; color: #07090f; font-weight: bold; font-size: 15px; cursor: pointer; box-shadow: 0 0 15px rgba(255, 102, 0, 0.4); transition: 0.3s; margin-bottom: 15px; }
        .btn-submit:hover { opacity: 0.9; }
        .btn-volver { display: block; text-align: center; color: #e5e7eb; text-decoration: none; font-size: 13px; font-weight: bold; transition: 0.3s; }
        .btn-volver:hover { color: #ff6600; }
        .alert-error { background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>EM DIGITAL SYSTEMS</h1>
        <p>Panel de Control Administrativo</p>
        <?php if (!empty($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label>USUARIO</label>
                <input type="text" name="usuario" required autofocus placeholder="EM Digital System">
            </div>
            <div class="form-group">
                <label>CONTRASEÑA</label>
                <input type="password" name="password" required placeholder="••••••••••••">
            </div>
            <button type="submit" class="btn-submit">INGRESAR AL PANEL</button>
        </form>
        <a href="index.php" class="btn-volver">← Volver a la Página Principal</a>
    </div>
</body>
</html>
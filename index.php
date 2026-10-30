<?php
/**
 * Página Principal Oficial - Eliezer Morales / EM Digital Systems
 * Estética Futurista / Neón con Precios, Facturación Fiscal y Términos Legales.
 */
require_once 'conexion.php';

// Obtener Configuración de la BD
$config = [
    'telefono_whatsapp' => '+584120000000',
    'email_contacto'    => 'contacto@emdigitalsystems.com',
    'instagram'         => '@emdigitalsystems',
    'direccion_oficina' => 'Anzoátegui, Venezuela'
];

try {
    $stmt =$pdo->query("SELECT * FROM configuracion WHERE id = 1 LIMIT 1");
    if ($res = $stmt->fetch()) {$config = array_merge($config, array_filter($res));
    }
} catch (Exception $e) {
    // Valores por defecto si ocurre algún error
}

// Obtener Demos Activos
$demos = [];
try {
    $stmtDemos =$pdo->query("SELECT * FROM demos WHERE estado = 'activo' ORDER BY id DESC");
    $demos =$stmtDemos->fetchAll();
} catch (Exception $e) {
    // Manejo silencioso
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliezer Morales | Web Developer & Soluciones Digitales</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { 
            background-color: #05070b; 
            color: #e5e7eb; 
            line-height: 1.6;
            background-image: linear-gradient(rgba(5, 7, 11, 0.88), rgba(5, 7, 11, 0.94)), url('portada.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* HEADER */
        header { 
            background: rgba(8, 11, 17, 0.92); 
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 102, 0, 0.3); 
            padding: 18px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo-area { display: flex; align-items: center; text-decoration: none; }
        .logo-box { color: #ff6600; font-weight: bold; border: 1px solid #ff6600; padding: 4px 8px; border-radius: 4px; margin-right: 10px; box-shadow: 0 0 10px rgba(255,102,0,0.4); }
        .logo-text { color: #fff; font-weight: bold; font-size: 15px; letter-spacing: 1px; }
        .logo-sub { display: block; font-size: 10px; color: #e5e7eb; letter-spacing: 2px; }

        nav { display: flex; align-items: center; gap: 25px; }
        nav a { color: #9ca3af; text-decoration: none; font-size: 14px; transition: 0.3s; }
        nav a:hover { color: #ff6600; }
        .btn-admin-nav { 
            border: 1px solid #ff6600; 
            color: #ff6600 !important; 
            padding: 6px 14px; 
            border-radius: 6px; 
            font-weight: bold; 
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
        }
        .btn-admin-nav:hover { background: rgba(255, 102, 0, 0.15); }

        /* HERO SECTION */
        .hero { text-align: center; padding: 80px 20px 60px; }
        .badge-cobertura { 
            display: inline-block; 
            border: 1px solid #e5e7eb; 
            color: #e5e7eb; 
            background: rgba(229, 231, 235, 0.05); 
            padding: 6px 18px; 
            border-radius: 20px; 
            font-size: 12px; 
            margin-bottom: 25px; 
            box-shadow: 0 0 12px rgba(229, 231, 235, 0.15);
        }
        .hero h1 { font-size: 42px; color: #fff; margin-bottom: 5px; letter-spacing: 1px; font-weight: 800; }
        .hero h2 { font-size: 38px; color: #ff6600; margin-bottom: 20px; text-shadow: 0 0 15px rgba(255, 102, 0, 0.5); font-weight: 800; }
        .hero p { font-size: 16px; color: #9ca3af; max-width: 680px; margin: 0 auto 30px; }
        
        .hero-buttons { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
        .btn-orange { 
            background: #ff6600; 
            color: #07090f; 
            padding: 12px 24px; 
            border-radius: 6px; 
            font-weight: bold; 
            text-decoration: none; 
            box-shadow: 0 0 15px rgba(255, 102, 0, 0.4);
            transition: 0.3s;
        }
        .btn-orange:hover { opacity: 0.9; box-shadow: 0 0 22px rgba(255, 102, 0, 0.8); }
        .btn-outline-silver { 
            border: 1px solid #e5e7eb; 
            color: #e5e7eb; 
            padding: 12px 24px; 
            border-radius: 6px; 
            font-weight: bold; 
            text-decoration: none; 
            box-shadow: 0 0 10px rgba(229, 231, 235, 0.2);
            transition: 0.3s;
        }
        .btn-outline-silver:hover { background: rgba(229, 231, 235, 0.1); }
        .link-text { color: #ff6600; text-decoration: none; display: inline-flex; align-items: center; padding: 12px; font-weight: bold; }

        /* SECCIONES COMUNES */
        .container { max-width: 1150px; margin: 60px auto; padding: 0 20px; }
        .section-tag { text-align: center; color: #ff6600; font-size: 13px; letter-spacing: 2px; margin-bottom: 10px; font-weight: bold; }
        .section-title { text-align: center; font-size: 32px; color: #fff; margin-bottom: 10px; font-weight: 700; }
        .section-sub { text-align: center; color: #9ca3af; font-size: 15px; margin-bottom: 40px; }

        /* DEMOS & PLANES GRID */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 25px; }
        .card-box { 
            background: rgba(12, 16, 26, 0.88); 
            backdrop-filter: blur(8px);
            border: 1px solid rgba(229, 231, 235, 0.15); 
            border-radius: 12px; 
            padding: 30px; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between;
            transition: 0.3s;
        }
        .card-box:hover { border-color: rgba(255, 102, 0, 0.6); box-shadow: 0 0 18px rgba(255, 102, 0, 0.25); }
        .card-box.popular { border-color: #ff6600; box-shadow: 0 0 22px rgba(255, 102, 0, 0.35); }
        
        .tag-pill { display: inline-block; border: 1px solid #e5e7eb; color: #e5e7eb; font-size: 11px; padding: 3px 10px; border-radius: 4px; margin-bottom: 15px; }
        .tag-pill.orange { border-color: #ff6600; color: #ff6600; }
        
        .card-box h3 { color: #fff; font-size: 22px; margin-bottom: 8px; }
        .plan-price { font-size: 24px; font-weight: bold; color: #ff6600; margin-bottom: 12px; }
        .card-box p { color: #9ca3af; font-size: 14px; margin-bottom: 20px; }
        
        .feature-list { list-style: none; margin-bottom: 25px; }
        .feature-list li { color: #d1d5db; font-size: 14px; margin-bottom: 10px; display: flex; align-items: center; }
        
        .btn-card-silver { display: block; text-align: center; border: 1px solid #e5e7eb; color: #e5e7eb; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn-card-silver:hover { background: rgba(229,231,235,0.1); }
        .btn-card-orange { display: block; text-align: center; background: #ff6600; color: #07090f; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; box-shadow: 0 0 12px rgba(255,102,0,0.4); }
        .btn-card-orange:hover { opacity: 0.9; }

        /* CONTACT FORM */
        .contact-card { 
            background: rgba(12, 16, 26, 0.88); 
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 102, 0, 0.4); 
            border-radius: 12px; 
            padding: 40px; 
            max-width: 700px; 
            margin: 0 auto; 
            box-shadow: 0 0 25px rgba(255, 102, 0, 0.15);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; color: #9ca3af; letter-spacing: 1px; margin-bottom: 8px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 14px; background: #07090f; border: 1px solid rgba(229,231,235,0.2); border-radius: 6px; color: #fff; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group textarea:focus { border-color: #ff6600; box-shadow: 0 0 8px rgba(255,102,0,0.4); }
        .btn-submit-orange { background: #ff6600; color: #07090f; width: 100%; padding: 14px; border: none; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer; box-shadow: 0 0 15px rgba(255,102,0,0.4); transition: 0.3s; }
        .btn-submit-orange:hover { opacity: 0.9; }

        /* SECCIÓN LEGAL MODAL / ENLACE */
        .legal-section { margin-top: 30px; text-align: center; }
        .btn-legal { 
            display: inline-block; 
            border: 1px solid rgba(229,231,235,0.3); 
            color: #e5e7eb; 
            padding: 8px 18px; 
            border-radius: 20px; 
            font-size: 12px; 
            text-decoration: none; 
            transition: 0.3s; 
            background: rgba(229,231,235,0.03);
        }
        .btn-legal:hover { border-color: #ff6600; color: #ff6600; }

        /* FOOTER */
        footer { border-top: 1px solid rgba(229,231,235,0.15); text-align: center; padding: 35px 20px; font-size: 12px; color: #9ca3af; margin-top: 80px; background: rgba(5, 7, 12, 0.96); line-height: 1.8; }
        .legal { max-width: 900px; margin: 10px auto 0; color: #6b7280; font-size: 11px; }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo-area">
            <span class="logo-box">{ E M }</span>
            <div>
                <span class="logo-text">ELIEZER MORALES</span>
                <span class="logo-sub">EM DIGITAL SYSTEMS</span>
            </div>
        </a>
        <nav>
            <a href="#inicio">Inicio</a>
            <a href="#demos">Demos</a>
            <a href="#servicios">Servicios</a>
            <a href="#planes">Planes</a>
            <a href="#contacto">Contacto</a>
            <a href="login.php" class="btn-admin-nav">+ GESTIÓN</a>
        </nav>
    </header>

    <!-- SECCIÓN HERO -->
    <section id="inicio" class="hero">
        <div class="badge-cobertura">● Cobertura Anzoátegui: Municipio Sotillo - Municipio Bolívar - Municipio Urbaneja - Municipio Guanta</div>
        <h1>DESARROLLO WEB</h1>
        <h2>& SOLUCIONES DIGITALES</h2>
        <p>Desarrollo de páginas web profesionales, sistemas a la medida y catálogos digitales para potenciar negocios locales y emprendimientos bajo estrictos estándares técnicos.</p>
        <div class="hero-buttons">
            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config['telefono_whatsapp']); ?>" target="_blank" class="btn-orange">WHATSAPP DIRECTO</a>
            <a href="https://instagram.com/<?php echo str_replace('@', '', $config['instagram']); ?>" target="_blank" class="btn-outline-silver">INSTAGRAM</a>
            <a href="#demos" class="link-text">Ver Demos ↗</a>
        </div>
    </section>

    <!-- SECCIÓN DEMOS EN VIVO -->
    <div id="demos" class="container">
        <div class="section-tag">// PROYECTOS DESTACADOS</div>
        <h2 class="section-title">DEMOS EN VIVO</h2>
        <p class="section-sub">Explora soluciones reales diseñadas para potenciar ventas y presencia digital.</p>
        
        <div class="grid-3">
            <?php if (count($demos) > 0): ?>
                <?php foreach ($demos as$d): ?>
                    <div class="card-box">
                        <div>
                            <span class="tag-pill"><?php echo htmlspecialchars($d['categoria']); ?></span>
                            <h3><?php echo htmlspecialchars($d['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars($d['descripcion']); ?></p>
                        </div>
                        <a href="<?php echo htmlspecialchars($d['link_demo']); ?>" target="_blank" class="btn-card-silver">Ver Demo en Vivo</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card-box">
                    <div>
                        <span class="tag-pill">SISTEMA WEB</span>
                        <h3>E-Commerce Futurista</h3>
                        <p>Tienda virtual interactiva con carrito dinámico, pasarela de pagos y diseño ultra rápido.</p>
                    </div>
                    <a href="#" class="btn-card-silver">Ver Demo en Vivo</a>
                </div>
                <div class="card-box">
                    <div>
                        <span class="tag-pill">LANDING PAGE</span>
                        <h3>Plataforma Corporativa</h3>
                        <p>Sitio corporativo optimizado para conversión, captación de clientes y presencia de marca.</p>
                    </div>
                    <a href="#" class="btn-card-silver">Ver Demo en Vivo</a>
                </div>
                <div class="card-box">
                    <div>
                        <span class="tag-pill">PANEL / DASHBOARD</span>
                        <h3>Gestionador de Negocio</h3>
                        <p>Panel de control administrativo para métricas en tiempo real y gestión de inventario.</p>
                    </div>
                    <a href="#" class="btn-card-silver">Ver Demo en Vivo</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECCIÓN TARIFAS Y PLANES -->
    <div id="planes" class="container">
        <div class="section-tag">// INVERSIÓN Y PLANES</div>
        <h2 class="section-title">TARIFAS Y SERVICIOS</h2>
        <p class="section-sub">Opciones claras y adaptadas al alcance de tu negocio o emprendimiento.</p>
        
        <div class="grid-3">
            <!-- Plan Emprendedor ($80 - $130) -->
            <div class="card-box">
                <div>
                    <span class="tag-pill">INICIAL</span>
                    <h3>Landing Emprendedor</h3>
                    <div class="plan-price">$80 - $130</div>
                    <p>Ideal para presencia rápida y directa en Google y redes sociales.</p>
                    <ul class="feature-list">
                        <li>✓ Diseño Responsive (Móvil / PC)</li>
                        <li>✓ Botones directos a WhatsApp</li>
                        <li>✓ Ubicación Google Maps</li>
                        <li>✓ Emisión de Factura Fiscal</li>
                    </ul>
                </div>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config['telefono_whatsapp']); ?>" target="_blank" class="btn-card-silver">CONSULTAR PLAN</a>
            </div>

            <!-- Plan Negocio ($150 - $220) -->
            <div class="card-box popular">
                <div>
                    <span class="tag-pill orange">MÁS POPULAR</span>
                    <h3>Catálogo / Negocios</h3>
                    <div class="plan-price">$150 - $220</div>
                    <p>Perfecto para ventas de repuestos, tiendas locales y servicios.</p>
                    <ul class="feature-list">
                        <li>✓ Todo lo del plan Inicial</li>
                        <li>✓ Catálogo interactivo de productos</li>
                        <li>✓ Buscador y filtros por categoría</li>
                        <li>✓ Emisión de Factura Fiscal</li>
                    </ul>
                </div>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config['telefono_whatsapp']); ?>" target="_blank" class="btn-card-orange">CONSULTAR PLAN</a>
            </div>

            <!-- Plan Empresarial ($300+) -->
            <div class="card-box">
                <div>
                    <span class="tag-pill">AVANZADO</span>
                    <h3>Sistema a Medida</h3>
                    <div class="plan-price">$300+</div>
                    <p>Desarrollos complejos con paneles administrativos e inventario.</p>
                    <ul class="feature-list">
                        <li>✓ Panel de Control / Dashboard</li>
                        <li>✓ Gestión de datos local o en nube</li>
                        <li>✓ Soporte técnico directo</li>
                        <li>✓ Emisión de Factura Fiscal</li>
                    </ul>
                </div>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config['telefono_whatsapp']); ?>" target="_blank" class="btn-card-silver">CONSULTAR PLAN</a>
            </div>
        </div>
    </div>

    <!-- SECCIÓN CONTACTO -->
    <div id="contacto" class="container">
        <div class="section-tag">// COMUNICACIÓN DIRECTA</div>
        <h2 class="section-title">SUGERENCIAS & CONTACTO</h2>
        <p class="section-sub">¿Tienes un proyecto en mente o alguna pregunta? Escríbenos directamente.</p>
        
        <div class="contact-card">
            <form action="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config['telefono_whatsapp']); ?>" method="GET" target="_blank">
                <div class="form-group">
                    <label>NOMBRE / EMPRESA</label>
                    <input type="text" placeholder="Ej: Repuestos El Pana" required>
                </div>
                <div class="form-group">
                    <label>WHATSAPP O CORREO</label>
                    <input type="text" placeholder="Ej: 0412-1234567" required>
                </div>
                <div class="form-group">
                    <label>MENSAJE / SUGERENCIA</label>
                    <textarea rows="4" placeholder="Cuéntame sobre tu proyecto..." required></textarea>
                </div>
                <button type="submit" class="btn-submit-orange">ENVIAR MENSAJE 🚀</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Eliezer Morales - EM Digital Systems. Cobertura: Municipios Sotillo, Bolívar, Urbaneja y Guanta (Anzoátegui, Venezuela).</p>
        <div class="legal-section">
            <a href="#legal" onclick="alert('EM DIGITAL SYSTEMS\n\nTérminos y Condiciones:\n- Prestación de servicios de desarrollo web y soluciones digitales bajo normativa vigente.\n- Facturación legal y fiscal emitida conforme a los requerimientos mercantiles.\n- Privacidad de datos garantizada para clientes y entidades.'); return false;" class="btn-legal">Ver Términos y Condiciones / Base Legal ↗</a>
        </div>
        <div class="legal">
            <p><strong>Aviso Normativo y Legal:</strong> Entorno tecnológico y demostrativo operado bajo rigurosos estándares de seguridad informática y cumplimiento de las normativas de telecomunicaciones y servicios digitales en Venezuela.</p>
        </div>
    </footer>

</body>
</html>
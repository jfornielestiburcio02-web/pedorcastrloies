<?php
// 1. VERIFICACIÓN DE SEGURIDAD (Leer la cookie)
if (!isset($_COOKIE['user_id'])) {
    // Si no hay cookie, el usuario no ha pasado por el login
    header("Location: IdenUsu.php");
    exit;
}

$usuarioLogueado = $_COOKIE['user_id'];
$aleatorio = $_GET['ALEATORIO'] ?? 'SIN_CLAVE';

// 2. CONFIGURACIÓN DE FIRESTORE
$config = [
    "projectId" => "studio-5014911262-ee6e6",
    "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4"
];

// URL para obtener el documento del usuario y sus roles
$url = "https://firestore.googleapis.com/v1/projects/" . $config['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuarioLogueado) . "?key=" . $config['apiKey'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$resData = json_decode($response, true);

// Extraemos el mapa de rolesUsuario
// Estructura esperada en Firestore: rolesUsuario (Map) -> EsProfesor (String), etc.
$roles = $resData['fields']['rolesUsuario']['mapValue']['fields'] ?? [];

/**
 * Función para validar si el rol está activo (Valor "S")
 */
function tienePermiso($roles, $key) {
    return (isset($roles[$key]['stringValue']) && $roles[$key]['stringValue'] === "S");
}
?>
<html>
<head>
    <title>Cambio de Perfil - Rayuela</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; background-color: #FFFFFF; }
        .morado { background-color: #9A6289; color: white; padding: 10px; }
        .lila { background-color: #BE9BB4; height: 80px; }
        .contenedor-perfiles { 
            width: 500px; 
            margin: 50px auto; 
            border: 1px solid #9A6289; 
            padding: 20px;
            text-align: center;
        }
        .titulo-seccion {
            background-color: #9A6289;
            color: #FFFFFF;
            font-weight: bold;
            padding: 8px;
            margin-bottom: 20px;
        }
        .boton-perfil {
            display: block;
            background-color: #F0AA94;
            border: 1px solid #E77551;
            color: #903214;
            padding: 12px;
            margin: 10px 0;
            text-decoration: none;
            font-weight: bold;
            font-size: 10pt;
        }
        .boton-perfil:hover {
            background-color: #B3D76B;
            color: #000000;
            border-color: #799F2B;
        }
        .info-user { font-size: 9pt; color: #573957; margin-bottom: 15px; }
    </style>
</head>
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td><img src="https://i.imgur.com/8Y0Rk6c.gif" height="120"></td>
        <td align="right" class="morado">
            Conectado como: <b><?php echo htmlspecialchars($usuarioLogueado); ?></b>
        </td>
    </tr>
</table>

<div class="contenedor-perfiles">
    <div class="titulo-seccion">SELECCIONE PERFIL DE ACCESO</div>
    <div class="info-user">Código de sesión: <?php echo htmlspecialchars($aleatorio); ?></div>

    <?php if (empty($roles)): ?>
        <p style="color:red;">No tienes perfiles asignados en el sistema.</p>
    <?php else: ?>
        
        <?php if (tienePermiso($roles, 'EsDireccion')): ?>
            <a href="menu.php?perfil=DIR" class="boton-perfil">EQUIPO DIRECTIVO</a>
        <?php endif; ?>

        <?php if (tienePermiso($roles, 'EsSecretaria')): ?>
            <a href="menu.php?perfil=SEC" class="boton-perfil">GESTIÓN DE SECRETARÍA</a>
        <?php endif; ?>

        <?php if (tienePermiso($roles, 'EsProfesor')): ?>
            <a href="menu.php?perfil=PRO" class="boton-perfil">PERFIL DOCENTE</a>
        <?php endif; ?>

        <?php if (tienePermiso($roles, 'EsAlumno')): ?>
            <a href="menu.php?perfil=ALU" class="boton-perfil">PERFIL ALUMNADO</a>
        <?php endif; ?>

        <?php if (tienePermiso($roles, 'EsCiudadano')): ?>
            <a href="menu.php?perfil=CIU" class="boton-perfil">PERFIL CIUDADANO</a>
        <?php endif; ?>

    <?php endif; ?>

    <br>
    <a href="IdenUsu.php" style="font-size: 8pt; color: #903214;">Cerrar Sesión</a>
</div>

<div class="lila" style="position: fixed; bottom: 0; width: 100%;">
    <table width="100%">
        <tr>
            <td align="right" style="padding-top: 20px;">
                <img src="https://i.imgur.com/8Y0Rk6c.gif" height="40" style="opacity: 0.5;">
            </td>
        </tr>
    </table>
</div>

</body>
</html>

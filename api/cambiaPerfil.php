<?php
// 1. VERIFICACIÓN DE SEGURIDAD (Leer la cookie)
if (!isset($_COOKIE['user_id'])) {
    header("Location: IdenUsu.php");
    exit;
}

$usuarioLogueado = $_COOKIE['user_id'];
$aleatorio = $_GET['ALEATORIO'] ?? 'SIN_SESSION';

// 2. CONFIGURACIÓN DE FIRESTORE
$config = [
    "projectId" => "studio-5014911262-ee6e6",
    "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4"
];

$url = "https://firestore.googleapis.com/v1/projects/" . $config['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuarioLogueado) . "?key=" . $config['apiKey'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$resData = json_decode($response, true);

// 3. EXTRACCIÓN DE ROLES DESDE EL ARRAY (Segun tu imagen)
$rolesRaw = $resData['fields']['rolesUsuario']['arrayValue']['values'] ?? [];
$misRoles = [];

// Convertimos el formato raro de Google a un array simple de PHP
foreach ($rolesRaw as $valor) {
    if (isset($valor['stringValue'])) {
        $misRoles[] = $valor['stringValue'];
    }
}

/**
 * Función para verificar si el rol existe en la lista
 */
function tienePermiso($lista, $nombreRol) {
    return in_array($nombreRol, $lista);
}
?>
<html>
<head>
    <title>Selección de Perfil</title>
    <style>
        body { font-family: Arial; margin: 0; background-color: #fff; }
        .morado { background-color: #9A6289; color: white; padding: 10px; }
        .contenedor { width: 450px; margin: 50px auto; border: 1px solid #9A6289; padding: 20px; text-align: center; }
        .boton-perfil {
            display: block; background-color: #F0AA94; border: 1px solid #E77551;
            color: #903214; padding: 12px; margin: 10px 0; text-decoration: none; font-weight: bold;
        }
        .boton-perfil:hover { background-color: #B3D76B; color: #000; }
        .titulo { background-color: #9A6289; color: #fff; padding: 10px; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="morado">
    Usuario: <b><?php echo htmlspecialchars($usuarioLogueado); ?></b>
</div>

<div class="contenedor">
    <div class="titulo">SELECCIONE PERFIL DE ACCESO</div>

    <?php if (empty($misRoles)): ?>
        <p style="color:red;">No tienes perfiles asignados (Array vacío).</p>
    <?php else: ?>
        
        <?php if (tienePermiso($misRoles, 'EsDireccion')): ?>
            <a href="CEC.php?p=DIR" class="boton-perfil">EQUIPO DIRECTIVO</a>
        <?php endif; ?>

        <?php if (tienePermiso($misRoles, 'EsSecretaria')): ?>
            <a href="CEC.php?p=SEC" class="boton-perfil">GESTIÓN DE SECRETARÍA</a>
        <?php endif; ?>

        <?php if (tienePermiso($misRoles, 'EsProfesor')): ?>
            <a href="CEC.php?p=PRO" class="boton-perfil">PERFIL DOCENTE</a>
        <?php endif; ?>

        <?php if (tienePermiso($misRoles, 'EsAlumno')): ?>
            <a href="CEC.php?p=ALU" class="boton-perfil">PERFIL ALUMNADO</a>
        <?php endif; ?>

        <?php if (tienePermiso($misRoles, 'EsCiudadano')): ?>
            <a href="CEC.php?p=CIU" class="boton-perfil">PERFIL CIUDADANO</a>
        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>

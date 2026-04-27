<?php
// --- CONFIGURACIÓN ---
$config = [
    "projectId" => "studio-5014911262-ee6e6",
    "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4"
];

// 1. OBTENER EL USUARIO (Deberías usar sesiones, pero para este ejemplo lo simulamos)
// En un sistema real, aquí recuperarías el usuario que se acaba de loguear.
$usuarioLogueado = "nombre_del_usuario"; // Sustituir por variable de sesión

$url = "https://firestore.googleapis.com/v1/projects/" . $config['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuarioLogueado) . "?key=" . $config['apiKey'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$resData = json_decode($response, true);
$roles = $resData['fields']['rolesUsuario']['mapValue']['fields'] ?? [];

// Función auxiliar para verificar si un rol es "true" o existe
function tieneRol($roles, $nombreRol) {
    return isset($roles[$nombreRol]['stringValue']) && ($roles[$nombreRol]['stringValue'] === "S" || $roles[$nombreRol]['stringValue'] === "true");
}
?>
<html>
<head>
    <title>Selección de Perfil</title>
    <style>
        .titulo_seccion { font-family: Arial; font-size: 14pt; font-weight: bold; color: #9A6289; padding: 20px; }
        .opcion_perfil { 
            display: block; 
            width: 300px; 
            margin: 10px auto; 
            padding: 15px; 
            background-color: #F0AA94; 
            border: 1px solid #E77551; 
            text-align: center; 
            color: #903214; 
            font-family: Arial; 
            font-weight: bold; 
            text-decoration: none;
        }
        .opcion_perfil:hover { background-color: #B3D76B; color: #000000; }
        .contenedor { text-align: center; margin-top: 50px; }
        .lila { background-color: #BE9BB4; height: 100px; }
    </style>
</head>
<body bgcolor="#ffffff">

<div class="contenedor">
    <img src="https://i.imgur.com/8Y0Rk6c.gif" height="100">
    <div class="titulo_seccion">Seleccione un Perfil de Acceso</div>

    <?php if (count($roles) === 0): ?>
        <p>No se encontraron perfiles para este usuario.</p>
    <?php endif; ?>

    <?php if (tieneRol($roles, 'EsDireccion')): ?>
        <a href="menu_direccion.php" class="opcion_perfil">EQUIPO DIRECTIVO</a>
    <?php endif; ?>

    <?php if (tieneRol($roles, 'EsSecretaria')): ?>
        <a href="menu_secretaria.php" class="opcion_perfil">GESTIÓN DE SECRETARÍA</a>
    <?php endif; ?>

    <?php if (tieneRol($roles, 'EsProfesor')): ?>
        <a href="menu_profesor.php" class="opcion_perfil">PERFIL DOCENTE</a>
    <?php endif; ?>

    <?php if (tieneRol($roles, 'EsAlumno')): ?>
        <a href="menu_alumno.php" class="opcion_perfil">ACCESO ALUMNO</a>
    <?php endif; ?>

    <?php if (tieneRol($roles, 'EsCiudadano')): ?>
        <a href="menu_ciudadano.php" class="opcion_perfil">PERFIL CIUDADANO</a>
    <?php endif; ?>

</div>

<div class="lila" style="position: fixed; bottom: 0; width: 100%;"></div>
</body>
</html>

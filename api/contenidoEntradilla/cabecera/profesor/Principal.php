<?php
// 1. SEGURIDAD Y COOKIES
if (!isset($_COOKIE['user_id'])) {
    die("Error: Sesión no iniciada.");
}

$usuarioLogueado = $_COOKIE['user_id'];
$aleatorio = $_GET['ALEATORIO'] ?? '';

// 2. CONSULTA A FIRESTORE
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
$fields = $resData['fields'] ?? [];

// 3. VALIDACIÓN DE ROL PROFESOR
$rolesRaw = $fields['rolesUsuario']['arrayValue']['values'] ?? [];
$misRoles = [];
foreach ($rolesRaw as $v) { $misRoles[] = $v['stringValue'] ?? ''; }

if (!in_array('EsProfesor', $misRoles)) {
    die("<div style='color:red; font-family:Verdana; font-weight:bold; padding:10px;'>ERROR: No tienes permisos de Profesor.</div>");
}

// 4. DATOS DEL PROFESOR
$nombre = $fields['nombrePersona']['stringValue'] ?? 'SIN IDENTIFICACIÓN';
$foto = $fields['imagenPerfil']['stringValue'] ?? '';
?>
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0 15px;
            background-color: #9A6289; /* Color morado Rayuela */
            color: #FFFFFF;
            font-family: Verdana, Geneva, sans-serif;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* LADO IZQUIERDO: Foto y Nombre */
        .perfil-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .perfil-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #B3D76B;
            object-fit: cover;
        }
        .nombre-txt {
            font-size: 11pt;
            font-weight: bold;
        }

        /* LADO DERECHO: Selector de Perfiles */
        .perfil-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 8pt;
        }
        select {
            font-family: Verdana;
            font-size: 8pt;
            background-color: #DBC6D4;
            border: 1px solid #FFFFFF;
            border-radius: 3px;
            color: #573957;
            padding: 2px;
            cursor: pointer;
        }
        .btn-cambiar {
            background-color: #B3D76B;
            color: #000;
            padding: 3px 8px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 3px;
        }
    </style>
    <script>
        function cambiarPerfil(select) {
            var perfil = select.value;
            if(perfil !== "") {
                // El cambio de perfil afecta a toda la ventana principal (parent)
                window.parent.location.href = "/CEC.php?p=" + perfil + "&ALEATORIO=<?php echo $aleatorio; ?>";
            }
        }
    </script>
</head>
<body>

    <div class="perfil-info">
        <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto">
        <span class="nombre-txt"><?php echo htmlspecialchars($nombre); ?></span>
    </div>

    <div class="perfil-selector">
        <span>CAMBIAR PERFIL:</span>
        <select onchange="cambiarPerfil(this)">
            <option value="">Seleccione...</option>
            
            <?php if (in_array('EsDireccion', $misRoles)): ?>
                <option value="DIR">Dirección</option>
            <?php endif; ?>

            <option value="PRO" selected>Docente</option>

            <?php if (in_array('EsSecretaria', $misRoles)): ?>
                <option value="SEC">Secretaría</option>
            <?php endif; ?>

            <?php if (in_array('EsAlumno', $misRoles)): ?>
                <option value="ALU">Alumnado</option>
            <?php endif; ?>

            <?php if (in_array('EsCiudadano', $misRoles)): ?>
                <option value="CIU">Ciudadano</option>
            <?php endif; ?>
        </select>
        <a href="/IdenUsu.php?rndval=37149038471" target="_parent" style="color: #FF9900; margin-left: 15px; font-weight: bold; text-decoration: none;">X</a>
    </div>

</body>
</html>

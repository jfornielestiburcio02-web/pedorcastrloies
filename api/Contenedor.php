<?php
// 1. SEGURIDAD: Si no hay cookie de usuario, fuera.
if (!isset($_COOKIE['user_id'])) {
    header("Location: IdenUsu.php");
    exit;
}

// 2. CAPTURAR EL PERFIL Y EL ALEATORIO
$perfilCod = $_GET['p'] ?? 'CIU'; // Por defecto Ciudadano si no viene nada
$aleatorio = $_GET['ALEATORIO'] ?? '';

// Si no viene aleatorio por URL (porque viene de cambiaPerfil), generamos uno nuevo aquí
if (empty($aleatorio)) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 15; $i++) {
        $aleatorio .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
}

// 3. MAPEO DE CODIGOS A NOMBRES DE CARPETA (Minúsculas como pediste)
$mapaCarpetas = [
    'DIR' => 'direccion',
    'SEC' => 'secretaria',
    'PRO' => 'profesor',
    'ALU' => 'alumno',
    'CIU' => 'ciudadano'
];

$nombreCarpeta = $mapaCarpetas[$perfilCod] ?? 'ciudadano';

// 4. CONSTRUCCIÓN DE LAS URLs DE LOS IFRAMES
$urlBase = "/contenidoEntradilla";
$param   = "?ALEATORIO=" . $aleatorio;

$urlCabecera  = $urlBase . "/cabecera/" . $nombreCarpeta . "/Principal.jsp" . $param;
$urlSidebar   = $urlBase . "/sidebar/" . $nombreCarpeta . "/Principal.jsp" . $param;
$urlContenido = $urlBase . "/contenidoEntero/" . $nombreCarpeta . "/Principal.jsp" . $param;
?>
<html>
<head>
    <title>Plataforma Rayuela - <?php echo strtoupper($nombreCarpeta); ?></title>
    <style>
        body, html {
            margin: 0; padding: 0; height: 100%; overflow: hidden;
            font-family: Arial, sans-serif;
        }
        /* Layout de frames: Cabecera arriba, Abajo Sidebar y Contenido */
        #contenedor-principal {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        #frame-cabecera {
            width: 100%;
            height: 150px; /* Ajusta según el diseño original */
            border: none;
        }
        #cuerpo-inferior {
            display: flex;
            flex: 1; /* Ocupa el resto de la pantalla */
        }
        #frame-sidebar {
            width: 250px; /* Ancho del menú lateral */
            height: 100%;
            border: none;
            border-right: 1px solid #9A6289;
        }
        #frame-contenido {
            flex: 1;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>

<div id="contenedor-principal">
    
    <iframe src="<?php echo $urlCabecera; ?>" id="frame-cabecera" name="cabecera"></iframe>

    <div id="cuerpo-inferior">
        
        <iframe src="<?php echo $urlSidebar; ?>" id="frame-sidebar" name="sidebar"></iframe>

        <iframe src="<?php echo $urlContenido; ?>" id="frame-contenido" name="contenido"></iframe>

    </div>

</div>

</body>
</html>

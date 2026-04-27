<?php
if (!isset($_COOKIE['user_id'])) {
    header("Location: IdenUsu.php");
    exit;
}

$perfilCod = $_GET['p'] ?? 'CIU';
$aleatorio = $_GET['ALEATORIO'] ?? '';

if (empty($aleatorio)) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $aleatorio = '';
    for ($i = 0; $i < 15; $i++) {
        $aleatorio .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
}

$mapaCarpetas = [
    'DIR' => 'direccion',
    'SEC' => 'secretaria',
    'PRO' => 'profesor',
    'ALU' => 'alumno',
    'CIU' => 'ciudadano'
];

$nombreCarpeta = $mapaCarpetas[$perfilCod] ?? 'ciudadano';
$urlBase = "/contenidoEntradilla";
$param   = "?ALEATORIO=" . $aleatorio;

$urlCabecera  = $urlBase . "/cabecera/" . $nombreCarpeta . "/Principal.php" . $param;
$urlSidebar   = $urlBase . "/sidebar/" . $nombreCarpeta . "/Principal.php" . $param;
$urlContenido = $urlBase . "/contenidoEntero/" . $nombreCarpeta . "/Principal.php" . $param;
?>
<html>
<head>
    <title>Rayuela - <?php echo strtoupper($nombreCarpeta); ?></title>
    <style>
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; font-family: Arial, sans-serif; }
        
        #contenedor-principal { display: flex; flex-direction: column; height: 100vh; }

        /* CABECERA: Ahora más pequeña (60px) */
        #frame-cabecera {
            width: 100%;
            height: 60px; 
            border: none;
            background-color: #9A6289;
            z-index: 10;
        }

        #cuerpo-inferior { display: flex; flex: 1; position: relative; }

        /* SIDEBAR: Efecto Hover */
        #contenedor-sidebar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 15px; /* Zona sensible al ratón muy estrecha */
            z-index: 100;
            transition: width 0.3s ease;
            background-color: #BE9BB4;
            overflow: hidden;
        }

        #contenedor-sidebar:hover {
            width: 250px; /* Ancho que se abre al pasar el ratón */
            box-shadow: 2px 0px 10px rgba(0,0,0,0.3);
        }

        #frame-sidebar {
            width: 250px;
            height: 100%;
            border: none;
        }

        /* CONTENIDO: Ocupa todo el fondo */
        #frame-contenido {
            flex: 1;
            width: 100%;
            height: 100%;
            border: none;
            margin-left: 15px; /* Para no tapar la zona sensible */
        }
    </style>
</head>
<body>

<div id="contenedor-principal">
    
    <iframe src="<?php echo $urlCabecera; ?>" id="frame-cabecera" scrolling="no"></iframe>

    <div id="cuerpo-inferior">
        
        <div id="contenedor-sidebar">
            <iframe src="<?php echo $urlSidebar; ?>" id="frame-sidebar"></iframe>
        </div>

        <iframe src="<?php echo $urlContenido; ?>" id="frame-contenido" name="contenido"></iframe>

    </div>

</div>

</body>
</html>

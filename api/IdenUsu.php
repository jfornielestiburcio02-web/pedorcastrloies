<?php
// --- LÓGICA DE FIREBASE (SOLO SE EJECUTA AL ENVIAR EL FORMULARIO) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['USUARIO'])) {
    $config = [
        "projectId" => "studio-5014911262-ee6e6",
        "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4"
    ];

    $usuario = $_POST['USUARIO'];
    $clave   = $_POST['CLAVECIFRADA']; 

    $url = "https://firestore.googleapis.com/v1/projects/" . $config['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuario) . "?key=" . $config['apiKey'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $resData = json_decode($response, true);

    if ($httpCode == 200 && isset($resData['fields']['contrasena']['stringValue'])) {
        if ($clave === $resData['fields']['contrasena']['stringValue']) {
            die("<h1>IDENTIFICACIÓN CORRECTA. BIENVENIDO $usuario</h1>");
        } else {
            echo "<script>alert('Clave incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado');</script>";
    }
}
?>
<html>
<head>
    <title>Identificación</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <SCRIPT SRC="../scripts/consejeria/cifrado.js"></SCRIPT>
    <script type="text/javascript">
        window.name = "NV_1777297125896";
        function comprobarclave(){
            if(document.forms[0]['USUARIO'].value=="") {
                alert("El campo 'Usuario' es obligatorio");
            } else if(document.forms[0]['CLAVE'].value=="") {
                alert("El campo 'Clave' es obligatorio");
            } else {
                // Aquí se usa tu función cifrar() del script externo
                document.forms[0]['CLAVECIFRADA'].value = cifrar(document.forms[0]['CLAVE'].value);
                document.forms[0]['CLAVE'].value = "";
                document.forms[0].submit();
            }
        }
    </script>
    <style>
        .morado { background-color: #9A6289 }
        .blanco { background-color: #FFFFFF }
        .lila { background-color: #BE9BB4 }
        .moradoclaro { background-color: #DBC6D4 }
        .verdeagua { background-color: #B7DDC8 }
        .verde { background-color: #B3D76B }
        .naranja { background-color: #EAB863 }
        .botones { background-color: #FFFFFF; padding: 2px; border: 1px #6B4560 solid; font-family: Arial; font-size: 8pt; color: #000000; width: 100px; text-decoration: none }
        .botones:hover { background-color: #DDCAD8; color: #5A3A51; }
        input { font-family: Arial; font-size: 8pt; font-weight: bold; color: #573957; background-color: #DBC6D4; border: 1px #FFFFFF solid; }
        .usuario { font-family: Arial; font-size: 9pt; font-weight: bold; color: #FFFFFF; }
        .botones2 { background-color: #F0AA94; padding: 2px; text-align: center; border: 1px #E77551 solid; font-family: Arial; font-size: 8pt; font-weight: bold; color: #903214; width: 100px; text-decoration: none; display: inline-block; }
        .botones2:hover { background-color: #B3D76B; color: #000000; border-color: #799F2B #669933 #669933 }
        .titulo { font-family: Arial; font-size: 10pt; font-weight: bold; color: #FFFFFF; background-color: #9A6289; width: 100%; padding-left: 10px }
        .txtcabecera { font-family: impact, Arial; background-color: #8D5A7E; color: #FFFFFF; font-size: 18pt }
    </style>
</head>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
        <tr>
            <td colspan="2" width="60%">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td><img src="../images/puertaTrasera/logo_rayuela.gif" height="157" width="230"></td>
                            <td align="right" height="165" valign="bottom">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td class="morado" height="165" valign="top" width="30%">
                <table align="center" border="0" cellpadding="0" cellspacing="5" width="90%">
                    <tbody>
                        <tr>
                            <td>
                                <form name="FORMULARIO_IDEN_USU" method="POST" action="IDENUSU.PHP">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr align="center">
                                                <td class="usuario" height="31" valign="middle" width="75%">
                                                    Usuario <br>
                                                    <input name="USUARIO" value="" size="20" type="text">
                                                </td>
                                            </tr>
                                            <tr align="center">
                                                <td class="usuario" width="75%"><br>
                                                    Contraseña<br>
                                                    <input name="CLAVE" value="" size="20" type="password">
                                                    <input name="CLAVECIFRADA" value="" type="hidden">
                                                </td>
                                            </tr>
                                            <tr><td width="75%">&nbsp;</td></tr>
                                            <tr align="center">
                                                <td width="75%">
                                                    <div align="center">
                                                        <a href="javascript:comprobarclave();" class="botones2">
                                                            &nbsp;&nbsp;&nbsp;Entrar&nbsp;&nbsp;&nbsp;
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="35%">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" class="lila" height="100"></td>
            <td class="moradoclaro" align="right" height="100"></td>
            <td class="lila" align="left" height="100"></td>
        </tr>
    </tbody>
</table>
</body>
</html>

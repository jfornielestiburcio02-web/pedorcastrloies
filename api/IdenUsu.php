<?php
// --- LÓGICA DE FIREBASE Y REDIRECCIÓN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['USUARIO'])) {
    $config = [
        "projectId" => "studio-5014911262-ee6e6",
        "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4"
    ];

    $usuarioRecibido = $_POST['USUARIO'];
    $claveRecibida   = $_POST['CLAVECIFRADA']; 

    $url = "https://firestore.googleapis.com/v1/projects/" . $config['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuarioRecibido) . "?key=" . $config['apiKey'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $resData = json_decode($response, true);

    if ($httpCode == 200 && isset($resData['fields']['contrasena']['stringValue'])) {
        $passwordEnBD = $resData['fields']['contrasena']['stringValue'];

        if ($claveRecibida === $passwordEnBD) {
            // --- GENERAR CADENA ALEATORIA DE MAYÚSCULAS ---
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $letrasAleatorias = '';
            for ($i = 0; $i < 15; $i++) {
                $letrasAleatorias .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }

            // --- REDIRECCIÓN ---
            header("Location: /cambiaPerfil.php?ALEATORIO=" . $letrasAleatorias);
            exit; 
        } else {
            echo "<script>alert('Error: Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Error: El usuario no existe');</script>";
    }
}
?>

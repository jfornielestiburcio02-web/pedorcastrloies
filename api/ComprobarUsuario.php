<?php
// login.php

// --- CONFIGURACIÓN OCULTA ---
$firebaseConfig = [
    "apiKey"    => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4",
    "projectId" => "studio-5014911262-ee6e6"
];

// Capturar datos del formulario
$usuarioRecibido = $_POST['USUARIO'] ?? '';
$claveRecibida   = $_POST['CLAVECIFRADA'] ?? ''; // Usamos la cifrada que genera tu JS

if (empty($usuarioRecibido) || empty($claveRecibida)) {
    die("Datos incompletos.");
}

// 1. Construir la URL de Firestore REST API
// Ruta: usuarios / {usuario}
$url = "https://firestore.googleapis.com/v1/projects/" . $firebaseConfig['projectId'] . "/databases/(default)/documents/usuarios/" . urlencode($usuarioRecibido);

// 2. Consultar a Google
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

// 3. Validar existencia y contraseña
if ($httpCode == 200 && isset($data['fields']['contrasena']['stringValue'])) {
    $passwordEnBD = $data['fields']['contrasena']['stringValue'];

    if ($claveRecibida === $passwordEnBD) {
        // LOGIN CORRECTO
        echo "<h1>Identificación correcta. Bienvenido " . htmlspecialchars($usuarioRecibido) . "</h1>";
        // Aquí podrías usar header("Location: dashboard.php");
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('El usuario no existe'); window.history.back();</script>";
}

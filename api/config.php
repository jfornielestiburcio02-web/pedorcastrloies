<?php
/**
 * CONFIGURACIÓN PRIVADA DE FIREBASE
 * Mueve estos datos aquí para que no sean visibles en el cliente.
 */

// Datos de identificación (Tus datos exactos)
$firebaseConfig = [
    "apiKey"            => "AIzaSyCpQ7ra0eLj8kskc_3hxCJSlV_z8N6nPy4",
    "authDomain"        => "studio-5014911262-ee6e6.firebaseapp.com",
    "projectId"         => "studio-5014911262-ee6e6",
    "storageBucket"     => "studio-5014911262-ee6e6.firebasestorage.app",
    "messagingSenderId" => "839128312548",
    "appId"             => "1:839128312548:web:f104ae0c961aaba3d1daf1"
];

// URL base de tu base de datos (Realtime Database o Firestore vía REST)
$projectId = $firebaseConfig['projectId'];
$dbUrl = "https://{$projectId}-default-rtdb.firebaseio.com/"; 

/**
 * Función simple para consultar datos por CURL (Método GET)
 * @param string $path El nodo de la DB, ej: "usuarios"
 */
function consultarFirebase($path) {
    global $dbUrl, $firebaseConfig;
    
    // En Firebase REST, añadimos .json al final y la API Key
    $url = $dbUrl . $path . ".json?auth=" . $firebaseConfig['apiKey'];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

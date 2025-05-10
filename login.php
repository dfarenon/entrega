<?php
$usuarios = [
    "usuario1" => "clave123",
    "testuser" => "password",
    "admin" => "secret",
    "otro_usuario" => "otra_clave"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $usuario_enviado = isset($data['usuario']) ? trim($data['usuario']) : '';
    $contrasena_enviada = isset($data['contrasena']) ? trim($data['contrasena']) : '';

    if (!empty($usuario_enviado) && !empty($contrasena_enviada)) {
        if (isset($usuarios[$usuario_enviado]) && $usuarios[$usuario_enviado] === $contrasena_enviada) {
            // Autenticación exitosa
            http_response_code(200); // OK
            echo json_encode(["mensaje" => "Autenticacion exitosa."]);
        } else {
            // Autenticación fallida
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Credenciales inválidas."]);
        }
    } else {
        // Si falta usuario o contraseña, devolver un error
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Por favor, proporciona usuario y contraseña."]);
    }
} else {
    // Si no es POST, devolver un error de método no permitido
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido. Use POST."]);
}
?>

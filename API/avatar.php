<?php
error_reporting(0);

// Detectar método
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    generarAvatar();
} elseif ($method === 'POST') {
    guardarAvatar();
} else {
    http_response_code(405);
    echo "Método no permitido";
}

function crearAvatar($name, $guardar = false, $ruta = null) {

    $size = 200;

    // limpiar buffer (evita errores de imagen rota)
    if (ob_get_length()) ob_clean();

    // crear imagen
    $image = imagecreatetruecolor($size, $size);

    // fondo
    $bg = imagecolorallocate($image, 40, 40, 40);
    imagefill($image, 0, 0, $bg);

    // color dinámico
    $hash = md5($name);
    $r = hexdec(substr($hash, 0, 2));
    $g = hexdec(substr($hash, 2, 2));
    $b = hexdec(substr($hash, 4, 2));

    $color = imagecolorallocate($image, $r, $g, $b);

    // círculo
    imagefilledellipse($image, $size/2, $size/2, $size, $size, $color);

    // 🔤 obtener 2 iniciales
    $words = explode(" ", trim($name));
    $initial = substr($initial, 0, 2);

    foreach ($words as $w) {
        if ($w !== "") {
        $initial .= strtoupper($w[0]);
        }
    }

$initial = substr($initial, 0, 2);

    $initial = substr($initial, 0, 2);

    // texto
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $font = __DIR__ . '/Roboto-Bold.ttf';

    if (file_exists($font)) {

        $fontSize = 110;

    $bbox = imagettfbbox($fontSize, 0, $font, $initial);

    $x = ($size - ($bbox[2] - $bbox[0])) / 2;
    $y = ($size - ($bbox[7] - $bbox[1])) / 2;

    $y -= $bbox[7];

        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $initial);

    } else {
        // fallback
        imagestring($image, 5, 70, 80, $initial, $textColor);
    }

    // salida
    if ($guardar && $ruta) {
        imagepng($image, $ruta);
    } else {
        header("Content-Type: image/png");
        imagepng($image);
    }

    imagedestroy($image);
}
// GET
function generarAvatar() {
    $name = $_GET['name'] ?? 'User';
    crearAvatar($name);
}

// POST
function guardarAvatar() {

    header("Content-Type: application/json");

    $name = $_POST['name'] ?? 'User';

    $filename = "user_" . time() . ".png";
    $ruta = "avatars/" . $filename;

    crearAvatar($name, true, $ruta);

    echo json_encode([
        "status" => "ok",
        "avatar" => $ruta
    ]);
}

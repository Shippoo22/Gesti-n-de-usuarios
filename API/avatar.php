<?php
ini_set('display_errors', 0);
error_reporting(0);

// Detectar método
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        generarAvatar();
    } elseif ($method === 'POST') {
        guardarAvatar();
    } elseif ($method === 'PUT') {
        actualizarAvatar();
    } elseif ($method === 'DELETE') {
        eliminarAvatar();
    } else {
        http_response_code(405);
        echo "Método no permitido";
    }
}

function crearAvatar($name, $guardar = false, $ruta = null) {

    $size = 210;

    if (ob_get_length()) ob_clean();

    $image = imagecreatetruecolor($size, $size);

    $bg = imagecolorallocate($image, 40, 40, 40);
    imagefill($image, 0, 0, $bg);

    $hash = md5($name);
    $r = hexdec(substr($hash, 0, 2));
    $g = hexdec(substr($hash, 2, 2));
    $b = hexdec(substr($hash, 4, 2));

    $color = imagecolorallocate($image, $r, $g, $b);

    imagefilledellipse($image, $size/2, $size/2, $size, $size, $color);

    $words = explode(" ", trim($name));
    $words = array_values(array_filter($words)); // 🔥 reindexa

    if (count($words) >= 2) {
        $initial = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    } elseif (count($words) === 1) {
        $initial = strtoupper(substr($words[0], 0, 2));
    } else {
        $initial = "U"; // fallback
}

    $textColor = imagecolorallocate($image, 255, 255, 255);
    $font = realpath(__DIR__ . '/Roboto-Bold.ttf');

    if (file_exists($font)) {

    $fontSize = $size * 0.5; // 🔥 más grande pero seguro

    $bbox = imagettfbbox($fontSize, 0, $font, $initial);

    $textWidth = $bbox[2] - $bbox[0];
    $textHeight = $bbox[1] - $bbox[7];

    // 🔥 CENTRADO CORRECTO
    $x = ($size - $textWidth) / 2;
    $y = ($size / 2) + ($textHeight / 4);

    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $initial);

} else {
        // fallback centrado
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($initial);
        $textHeight = imagefontheight($fontSize);

        $x = ($size - $textWidth) / 2;
        $y = ($size - $textHeight) / 2;

        imagestring($image, $fontSize, $x, $y, $initial, $textColor);
    }

    // 🔥 ESTO ESTABA MAL POSICIONADO (FUERA DE LA FUNCIÓN)
    if ($guardar && $ruta) {
        imagepng($image, $ruta);
    } else {
        header("Content-Type: image/png");
        imagepng($image);
    }

    imagedestroy($image);
}

// 🟢 GET
function generarAvatar() {
    $name = $_GET['name'] ?? 'User';
    crearAvatar($name);
}

// 🟡 POST
function guardarAvatar() {

    header("Content-Type: application/json");

    $name = $_POST['name'] ?? 'User';

    $filename = "user_" . time() . ".png";

    $carpeta = __DIR__ . "/avatars/";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $ruta = $carpeta . $filename;

    crearAvatar($name, true, $ruta);

    echo json_encode([
        "status" => "ok",
        "avatar" => "avatars/" . $filename
    ]);
}

// 🔵 PUT
function actualizarAvatar() {

    header("Content-Type: application/json");

    parse_str(file_get_contents("php://input"), $data);

    $name = $data['name'] ?? 'User';
    $file = $data['file'] ?? null;

    if (!$file || !file_exists(__DIR__ . "/" . $file)) {
        echo json_encode(["error" => "archivo no encontrado"]);
        return;
    }

    $ruta = __DIR__ . "/" . $file;

    crearAvatar($name, true, $ruta);

    echo json_encode([
        "status" => "updated",
        "avatar" => $file
    ]);
}

// 🔴 DELETE
function eliminarAvatar() {

    header("Content-Type: application/json");

    parse_str(file_get_contents("php://input"), $data);

    $file = $data['file'] ?? null;

    $ruta = __DIR__ . "/" . $file;

    if ($file && file_exists($ruta)) {
        unlink($ruta);
        echo json_encode(["status" => "deleted"]);
    } else {
        echo json_encode(["error" => "archivo no encontrado"]);
    }
}
?>

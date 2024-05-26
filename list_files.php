<?php
// Устанавливаем заголовки, чтобы разрешить доступ из любого источника
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// Базовая директория
$base_directory = 'files/';

// Проверяем, передан ли параметр dir в запросе
$dir = isset($_GET['dir']) ? $_GET['dir'] : '';

// Защита от выхода за пределы базовой директории
$target_directory = realpath($base_directory . $dir);
if ($target_directory === false || strpos($target_directory, realpath($base_directory)) !== 0) {
    http_response_code(400); // Неправильный запрос
    echo json_encode(["message" => "Invalid directory"]);
    exit;
}

// Проверяем, существует ли директория
if (!is_dir($target_directory)) {
    http_response_code(404); // Директория не найдена
    echo json_encode(["message" => "Directory not found"]);
    exit;
}

// Получение списка файлов и директорий
$files = [];
$directories = [];

foreach (scandir($target_directory) as $item) {
    if ($item === '.' || $item === '..') {
        continue;
    }
    if (is_dir($target_directory . DIRECTORY_SEPARATOR . $item)) {
        $directories[] = $item;
    } else {
        $files[] = $item;
    }
}

// Возвращаем список файлов и директорий в формате JSON
echo json_encode([
    "files" => $files,
    "directories" => $directories
]);
exit;
?>

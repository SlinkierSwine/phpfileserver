<?php
// Устанавливаем заголовки, чтобы разрешить доступ из любого источника
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// Проверяем, передан ли параметр file в запросе
if (!isset($_GET['file'])) {
    http_response_code(400); // Неправильный запрос
    echo json_encode(["message" => "Parameter 'file' is required"]);
    exit;
}

$file = $_GET['file'];
$filepath = 'files/' . $file; // Путь к файлу

// Проверяем, существует ли файл
if (!file_exists($filepath)) {
    http_response_code(404); // Файл не найден
    echo json_encode(["message" => "File not found"]);
    exit;
}

// Заголовки для скачивания файла
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

// Чтение файла и вывод его содержимого
readfile($filepath);
exit;
?>

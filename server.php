<?php
// Обработка сохранения данных
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type']; // 'chat' или 'objects'
    $data = json_decode($_POST['data'], true);
    
    $file = $type . '.json';
    $current = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    
    // Добавляем новую запись
    array_push($current, $data);
    
    // Ограничиваем историю чата (последние 50 сообщений)
    if ($type === 'chat' && count($current) > 50) array_shift($current);
    
    file_put_contents($file, json_encode($current));
    echo json_encode(['status' => 'ok']);
    exit;
}

// Обработка получения данных
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'];
    $file = $type . '.json';
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>

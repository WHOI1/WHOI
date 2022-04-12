<?php

// Разрешенные для загрузки mime-типы файлов
$upload_allow_mimetypes = array(
    "image/png",
    "image/jpeg",
);
// Разрешенные для загрузки расширения
$upload_allow_ext = array("jpg", "png", "jpeg", "jpe");
// максимальный размер картинки (в байтах)
$upload_max_size = 2 * 1024 * 1024;

// Получить расширение по имени файла
function get_extension($name)
{
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    return mb_strtolower($ext);
}

$errors = array();

if (isset($_FILES["file1"])) {
    // проверка файла
    $ext = null;
    $file = $_FILES["file1"];
    // файл был отправлен
    if (!empty($_FILES["file1"]["tmp_name"])) {
        $ext = get_extension($file["name"]);
        if (!in_array($file["type"], $upload_allow_mimetypes))
            $errors["file1"] = "Неразрешенный тип файла";
        elseif (!in_array($ext, $upload_allow_ext))
            $errors["file1"] = "Допустимые расширения файлов: " . implode($upload_allow_ext, ", ");
        elseif ($file["size"] === 0)
            $errors["file1"] = "Вы загрузили пустой файл";
        elseif ($file["size"] > $upload_max_size)
            $errors["file1"] = "Максимальный размер файла — 2Мб";
    }

    // Потом вызываешь move_uploaded_file, чтобы сохранить картинку в нужном месте
}

if (!empty($errors)) // показываем ошибки, если они есть
    echo json_dumps($errors);
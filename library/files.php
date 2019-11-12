<?php
function fileUpload($uploadDir, $fileInputName) {
    $basePath = $_SERVER['DOCUMENT_ROOT'];
    $uploadPath = '/' . $uploadDir . '/' . date('YmdHis') .  hash('sha256', $_FILES[$fileInputName]['name'] . rand()) . rand() . '.' . strtolower(end(explode('.',$_FILES[$fileInputName]['name'])));
    move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $basePath . $uploadPath);
    return $uploadPath;
}
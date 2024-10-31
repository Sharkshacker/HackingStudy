<?php
    session_start();

    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','users');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    if($db_conn === false) {
        die("ERROR: DB가 연결되어있지 않음." . mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = $_POST["username"];
        $password = $_POST["password"];

        if($username === "admin" && $password === "admin") {
            $_SESSION['username'] = $username;
            echo "<script>
                alert('환영합니다! 관리자 계정입니다.');
                window.location.href='index.php';
            </script>";
            exit();
        }

        $sql = "SELECT * FROM user_table WHERE id = '$username' AND password = '$password'";
        $result = mysqli_query($db_conn,$sql);
        
        if($result && mysqli_num_rows($result)>0) {
            $_SESSION['username'] = $username;
            echo "<script>
                window.location.href = 'index.php';
            </script>";
            exit();
        }else {
            echo "<script>
                alert('로그인 실패 ! 다시 입력하세요.');
                history.back();
            </script>";
            exit();
        }
    
        mysqli_close($db_conn);
    }

?>

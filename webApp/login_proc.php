<?php
    $username = $_POST["username"];
    $password = $_POST["password"];

    if($username === "admin" && $password === "admin") {
        echo "<script>
            alert('환영합니다! 관리자 계정입니다.');
            window.location.href='main.php';
        </script>";
        exit();
    }

    $users_file = 'users.json';

    if(file_exists($users_file)) {
        $users = json_decode(file_get_contents($users_file), true);
    }else {
        $users =[] ;
    }

    foreach($users as $user) {
        if($user ['username']=== $username && $user ['password'] === $password) {
            echo "<script>
                window.location.href='main.php';
            </script>";
            exit();
        }
    }

    echo "<script>
        alert('로그인 실패! 다시 입력하세요.');
        history.back();    
    </script>";
?>

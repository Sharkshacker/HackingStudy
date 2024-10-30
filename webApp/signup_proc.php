<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_check = $_POST['password_check'];

        if ($password !== $password_check) {
            echo "<script>
            alert('비밀번호가 일치하지 않습니다');
            history.back();
            </script>";
            exit();
        }

        $user_file = 'users.json';

        if (file_exists($user_file)) {
            $users = json_decode(file_get_contents($user_file), true);
        } else {
            $users = [];
        }

        foreach ($users as $user) {
            if ($user['username'] === $username) {
                echo "<script>
                alert('이미 등록된 ID입니다.'); 
                history.back();
                </script>";
                exit();
            }
        }

        $users[] = [
            'username' => $username,
            'password' => $password
        ];

        file_put_contents($user_file, json_encode($users));

        echo "<script>
        alert('회원가입 성공!');
        window.location.href='index.php';
        </script>";
    }
?>
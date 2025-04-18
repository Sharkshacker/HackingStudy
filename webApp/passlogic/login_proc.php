<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username      = mysqli_real_escape_string($db_conn, $_POST['username']);
    $password      = $_POST['password'];
    $hash_password = hash('sha512', $password);

    $sql    = "SELECT * FROM user_table WHERE user_id = '$username' AND user_password = '$hash_password'";
    $result = mysqli_query($db_conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 기존 세션 정보
        $_SESSION['username'] = $user['user_id'];
        $_SESSION['email']    = $user['user_email'];
        $_SESSION['phonenum'] = $user['user_phonenum'];
        $_SESSION['idx']      = $user['user_idx'];

        // **추가**: profile_image 칼럼을 세션에 저장
        if (!empty($user['profile_image'])) {
            // DB에 저장된 경로 그대로 사용
            $_SESSION['profile_image'] = $user['profile_image'];
        } else {
            // DB에 값이 없으면 기본 이미지
            $_SESSION['profile_image'] = 'img/profileshark.png';
        }

        // 관리자 여부 체크
        if ($user['user_id'] === 'admin') {
            echo "<script>
                alert('환영합니다! 관리자계정입니다.');
                window.location.href = '../index.php';
            </script>";
        } else {
            echo "<script>
                window.location.href = '../index.php';
            </script>";
        }
        exit();
    } else {
        echo "<script>
            alert('로그인 실패! 다시 입력하세요.');
            history.back();
        </script>";
        exit();
    }

    mysqli_close($db_conn);
}
?>
<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

// CSRF 검증
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token'])
    || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "<script>
            alert('잘못된 접근입니다.');
            history.back();
          </script>";
    exit();
}
unset($_SESSION['csrf_token']);

$username   = $_POST['username'];
$email      = $_POST['email'];
$phoneNum   = $_POST['phonenum'];
$idx        = $_SESSION['idx'];
$removeFlag = isset($_POST['removeImage']) ? $_POST['removeImage'] : '0';

// ★ 이름 중복 체크 추가 시작 ★
$dupSql = "SELECT COUNT(*) AS cnt FROM user_table WHERE user_id = '$username' AND user_idx != $idx";
$dupRes = mysqli_query($db_conn, $dupSql);
$dupRow = mysqli_fetch_assoc($dupRes);
if ($dupRow['cnt'] > 0) {
    echo "<script>
            alert('이미 사용 중인 이름입니다.');
            history.back();
          </script>";
    exit();
}
// ★ 이름 중복 체크 추가 끝 ★

// 유효성 검사
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
            alert('이메일 형식이 맞지 않습니다.');
            history.back();
          </script>";
    exit();
}
if (!preg_match("/^\d{3}-\d{4}-\d{4}$/", $phoneNum)) {
    echo "<script>
            alert('전화번호 형식이 맞지 않습니다.');
            history.back();
          </script>";
    exit();
}

// 기본 이미지 제거 요청 처리
if ($removeFlag === '1') {
    // 기존 파일 삭제 
    if (!empty($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])) {
        @unlink($_SESSION['profile_image']);
    }
    $sql = "UPDATE user_table
            SET user_id       = '$username',
                user_email    = '$email',
                user_phonenum = '$phoneNum',
                profile_image = NULL
            WHERE user_idx = $idx";
}
// 새 이미지 업로드 처리
else if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
    $imageFile = $_FILES['profileImage'];
    $uploadDir = 'userupload/';
    $uploadFile = $uploadDir . basename($imageFile['name']);
    if (move_uploaded_file($imageFile['tmp_name'], $uploadFile)) {
        $profileImagePath = $uploadFile;
        $sql = "UPDATE user_table
                SET user_id       = '$username',
                    user_email    = '$email',
                    user_phonenum = '$phoneNum',
                    profile_image = '$profileImagePath'
                WHERE user_idx = $idx";
    } else {
        echo "<script>
                alert('이미지 업로드 중 에러가 발생했습니다.');
                history.back();
              </script>";
        exit();
    }
}
// 비밀번호 변경 포함 여부에 따른 나머지 처리
else {
    $pw = $_POST['pw'];
    if (!empty($pw)) {
        $hash = hash('sha512', $pw);
        $sql = "UPDATE user_table
                SET user_id       = '$username',
                    user_email    = '$email',
                    user_phonenum = '$phoneNum',
                    user_password = '$hash'
                WHERE user_idx = $idx";
    } else {
        $sql = "UPDATE user_table
                SET user_id       = '$username',
                    user_email    = '$email',
                    user_phonenum = '$phoneNum'
                WHERE user_idx = $idx";
    }
}

// 쿼리 실행
$result = mysqli_query($db_conn, $sql);
if ($result) {
    // 세션 갱신
    $_SESSION['username'] = $username;
    $_SESSION['email']    = $email;
    $_SESSION['phonenum'] = $phoneNum;
    if ($removeFlag === '1') {
        unset($_SESSION['profile_image']);
    } else if (isset($profileImagePath)) {
        $_SESSION['profile_image'] = $profileImagePath;
    }
    echo "<script>
            alert('변경 사항을 저장하였습니다.');
            window.location.href = 'mypage.php';
          </script>";
    exit();
} else {
    echo "<script>
            alert('변경 사항 저장 중 오류가 발생하였습니다.');
            history.back();
          </script>";
    exit();
}
?>
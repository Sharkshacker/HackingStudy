<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];
include __DIR__ . '/../db.php';

// 관리자 권한 확인
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.');location.href='../index.php';</script>";
    exit();
}

// GET으로 전달된 uid
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
if ($uid < 1) {
    echo "<script>alert('잘못된 접근입니다.');location.href='admin.php';</script>";
    exit();
}

// 기존 회원 정보 조회
$res  = mysqli_query(
    $db_conn,
    "SELECT user_id, user_email, user_phonenum 
       FROM user_table 
      WHERE user_idx = {$uid}"
);
$user = mysqli_fetch_assoc($res);

// POST 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($db_conn, $_POST['username']);
    $email    = mysqli_real_escape_string($db_conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($db_conn, $_POST['phonenum']);
    $pw       = trim($_POST['pw']);

    // 유효성 검사
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('이메일 형식이 올바르지 않습니다.');history.back();</script>";
        exit();
    }
    if (!preg_match('/^\d{3}-\d{4}-\d{4}$/', $phone)) {
        echo "<script>alert('전화번호 형식이 올바르지 않습니다.');history.back();</script>";
        exit();
    }

    // 업데이트할 필드를 동적으로 구성
    $fields = [
        "user_id     = '{$username}'",
        "user_email  = '{$email}'",
        "user_phonenum = '{$phone}'",
    ];
    if ($pw !== '') {
        $hash     = hash('sha512', $pw);
        $fields[] = "user_password = '{$hash}'";
    }

    $sql = "UPDATE user_table
               SET " . implode(', ', $fields) . "
             WHERE user_idx = {$uid}";
    mysqli_query($db_conn, $sql);

    echo "<script>
            alert('수정 완료');
            location.href='admin.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>관리자 페이지 - 회원 수정</title>
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="index-page">
    <?php include __DIR__ . '/../nav.php'; ?>

    <div class="main-box">
        <h1>회원 정보 수정 (ID: <?php echo htmlspecialchars($user['user_id']); ?>)</h1>
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">이름</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo htmlspecialchars($user['user_id']); ?>"
                    maxlength="30"
                    required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($user['user_email']); ?>"
                    required>
            </div>
            <div class="input-group">
                <label for="phonenum">PhoneNumber</label>
                <input
                    type="text"
                    id="phonenum"
                    name="phonenum"
                    value="<?php echo htmlspecialchars($user['user_phonenum']); ?>"
                    required>
            </div>
            <div class="input-group">
                <label for="pw">새 비밀번호 변경</label>
                <input
                    type="password"
                    id="pw"
                    name="pw"
                    placeholder="변경할 비밀번호 입력">
            </div>
            <button type="submit">저장</button>
        </form>
    </div>
    <script src="../js/modal.js"></script>
</body>
</html>
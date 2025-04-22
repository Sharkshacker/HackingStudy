<?php
session_start(); 
include __DIR__ . '/db.php'; 

if (!isset($_SESSION['username'], $_SESSION['idx'])) {
    echo "<script>
        alert('로그인 후 사용가능합니다.');
        window.location.href = 'passlogic/login.php';
    </script>";
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks Mypage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
</head>
<body class="mypage">
    <?php include __DIR__ . '/nav.php'; ?>
    <div class="profile-box">
        <form method="POST" action="mypage_proc.php" enctype="multipart/form-data">
            <input type="hidden" name="removeImage" id="removeImage" value="0">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <div class="profile-img-change">
                <img
                    src="<?php echo isset($_SESSION['profile_image'])
                        ? $_SESSION['profile_image']
                        : 'img/profileshark.png'; ?>"
                    alt="Profile Image" id="profileImage" class="profile-img">
                <div class="edit-icon" onclick="document.getElementById('imageUpload').click()">✏️</div>
            </div>
            <h2 style="text-align:center;margin:20px 0;">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </h2>
            <p>프로필 이미지 권장 크기는 512x512 입니다.</p>
            <button type="button" onclick="setDefaultImage()">기본 이미지로 변경</button>
            <input
                type="file"
                id="imageUpload"
                name="profileImage"
                accept="image/*"
                style="display:none;"
                onchange="loadImage(event)">
            <div class="input-group">
                <label for="username">이름</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo htmlspecialchars($_SESSION['username']); ?>"
                    maxlength="30">
            </div>
            <div class="input-group">
                <label for="pw">비밀번호 변경</label>
                <input
                    type="password"
                    id="pw"
                    name="pw"
                    placeholder="변경할 비밀번호 입력">
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
            </div>
            <div class="input-group">
                <label for="phonenum">PhoneNumber</label>
                <input
                    type="text"
                    id="phonenum"
                    name="phonenum"
                    value="<?php echo htmlspecialchars($_SESSION['phonenum']); ?>">
            </div>
            <button type="submit">변경 사항 저장</button>
        </form>

        <?php if ($_SESSION['username'] !== 'admin'): ?>
        <!-- 회원 탈퇴 폼 (관리자 계정에는 숨김) -->
        <form method="POST" action="user_delete.php" onsubmit="return confirm('정말 탈퇴하시겠습니까?');" style="margin-top:20px;">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <button type="submit" style="background-color:#e74c3c;">회원 탈퇴</button>
        </form>
        <?php endif; ?>
    </div>

    <script src="js/modal.js"></script>
    <script src="js/mypage.js"></script>
</body>
</html>
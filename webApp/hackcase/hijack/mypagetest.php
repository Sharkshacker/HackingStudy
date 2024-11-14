<?php 
session_start(); // 세션 시작

// 세션에 로그인 정보가 없으면 로그인 페이지로 리디렉션
if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('로그인 후 사용가능합니다.');
        window.location.href = 'login.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks Mypage</title>
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-left">
                <a href="">Sharks</a>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['username'])) : ?> 
                <a href="logouttest.php">logout</a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="profile-box">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="profile-img-change">
                    <img src = "<?php echo isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "img/profileshark.png";?>" alt= "Profile Image" id="profileImage" class="profile-img">
                    <div class="edit-icon" onclick="document.getElementById('imageUpload').click()">✏️</div>
                </div>
                <p>프로필 이미지 권장 크기는 512x512 입니다.</p>
                <button type="button" onclick="setDefaultImage()">기본 이미지로 변경</button>
                <input type="file" id="imageUpload" name="profileImage" accept="image/*" style="display: none;" onchange="loadImage(event)">
                
                    <div class="input-group">
                        <label for="username">이름</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']) ?>" maxlength="30">
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value= "<?php echo htmlspecialchars($_SESSION['email']) ?>" >
                    </div>
                    <div class="input-group">
                        <label for="phonenum">PhoneNumber</label>
                        <input type="text" id="phonenum" name="phonenum" value= "<?php echo htmlspecialchars($_SESSION['phonenum']) ?>" >
                    </div>
                    <button type="submit">변경 사항 저장</button>
            </form>
        </div>
    <script src="cookie.js"></script>
    </body>
</html>
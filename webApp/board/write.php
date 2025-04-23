<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('로그인 후 사용 가능합니다.');
        window.location.href = '../passlogic/login.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = mysqli_real_escape_string($db_conn, $_POST['title']);
    $content = mysqli_real_escape_string($db_conn, $_POST['content']);
    // 비밀글 체크박스가 체크된 경우 1, 아니면 0
    $secret  = isset($_POST['secret']) && $_POST['secret'] === '1' ? 1 : 0;

    if (empty($title) || empty($content)) {
        echo "빈칸을 채워주세요.";
    } else {
        $user_idx                 = $_SESSION['idx'];
        $board_file               = '';
        $board_file_original_name = '';

        // 파일 업로드 처리
        if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === 0) {
            $uploadDir = '../userupload/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $originalName = basename($_FILES['uploaded_file']['name']);
            if ($originalName) {
                $ext         = pathinfo($originalName, PATHINFO_EXTENSION);
                $newFileName = uniqid('file_', true) . '.' . $ext;
                $uploadPath  = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploadPath)) {
                    $board_file               = $newFileName;
                    $board_file_original_name = mysqli_real_escape_string($db_conn, $originalName);
                } else {
                    echo "파일 업로드에 실패했습니다.";
                    exit();
                }
            }
        }

        $sql = "INSERT INTO board_table
                    (board_title, board_content, user_idx, board_file, board_file_original_name, board_secret)
                VALUES
                    ('$title', '$content', $user_idx, '$board_file', '$board_file_original_name', $secret)";
        mysqli_query($db_conn, $sql);

        echo "<script>
            alert('작성 완료되었습니다!');
            window.location.href = '../index.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks writePost</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
</head>
<body>
    <?php include __DIR__ . '/../nav.php'; ?>
    <div class="write">
        <h1>글을 작성하세요.</h1>
        <hr/>
        <form method="POST" action="write.php" enctype="multipart/form-data">
            <table class="writeTable">
                <tr>
                    <th width="50">제목</th>
                    <td>
                        <input type="text" name="title" placeholder="제목을 입력하세요." required>
                    </td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td>
                        <textarea name="content" rows="5" cols="40" placeholder="내용을 입력하세요." required></textarea>
                    </td>
                </tr>
                <tr>
                    <th>파일 업로드</th>
                    <td>
                        <input type="file" name="uploaded_file">
                    </td>
                </tr>
                <tr>
                    <th>비밀글</th>
                    <td>
                        <label>
                            <input type="checkbox" name="secret" value="1">
                            비밀글
                        </label>
                    </td>
                </tr>
            </table>
            <ul>
                <li><input class="button" type="submit" value="작성 완료"></li>
                <li><button type="button" onclick="location.href='../index.php'">취소</button></li>
            </ul>
        </form>
    </div>
    <script src="../js/modal.js"></script>
</body>
</html>
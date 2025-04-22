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
    $title = mysqli_real_escape_string($db_conn, $_POST['title']);
    $content = mysqli_real_escape_string($db_conn, $_POST['content']);
    
    if (empty($title) || empty($content)) {
        echo "빈칸을 채워주세요.";
    } else {
        $user_idx = $_SESSION['idx'];
        $board_file = '';                   // 서버에 저장될 고유 파일명
        $board_file_original_name = '';     // 사용자가 업로드한 원본 파일명

        // 파일 업로드 처리 시작
        if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === 0) {
            // userupload 폴더를 업로드 디렉토리로 사용 (board 폴더 기준 상위 폴더에 위치)
            $uploadDir = '../userupload/';
            // 업로드 폴더가 존재하지 않으면 생성
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            // 원본 파일명 추출 (basename 사용 - 경로 문제 방지)
            $originalName = basename($_FILES['uploaded_file']['name']);
            // 사용자가 올린 파일명이 비어있지 않은지 확인
            if (!empty($originalName)) {
                // 파일의 확장자 추출
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                // uniqid()를 사용하여 고유 파일명 생성 (중복 업로드 방지)
                $newFileName = uniqid('file_', true) . '.' . $ext;
                // 최종 업로드할 파일 경로
                $uploadPath = $uploadDir . $newFileName;
            
                // 임시 폴더에 저장된 파일을 지정된 경로로 이동
                if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploadPath)) {
                    $board_file = $newFileName; // 서버에 저장된 파일명
                    // 사용자가 업로드한 원본 파일명을 DB에 저장 (이스케이프 처리)
                    $board_file_original_name = mysqli_real_escape_string($db_conn, $originalName);
                } else {
                    echo "파일 업로드에 실패했습니다.";
                    exit();
                }
            }
        }
        // board_table 테이블에 게시글 및 파일 정보를 삽입 (원본 파일명이 반드시 저장됨)
        $sql = "INSERT INTO board_table (board_title, board_content, user_idx, board_file, board_file_original_name) 
                VALUES ('$title', '$content', $user_idx, '$board_file', '$board_file_original_name')";
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
        <?php include __DIR__ . '/../nav.php' ?>
        <div class="write">
            <h1>글을 작성하세요.</h1>
            <hr/>
            <!-- 파일 업로드를 위한 multipart/form-data 인코딩 타입 지정 -->
            <form method="POST" action="write.php" enctype="multipart/form-data">
                <table class="writeTable">
                    <tr>
                        <th width="50">제목</th>
                        <td><input type="text" name="title" placeholder="제목을 입력하세요." required></td>
                    </tr>
                    <tr>
                        <th>내용</th>
                        <td><textarea name="content" rows="5" cols="40" placeholder="내용을 입력하세요." required></textarea></td>
                    </tr>
                    <tr>
                        <th>파일 업로드</th>
                        <td><input type="file" name="uploaded_file"></td>
                    </tr>
                </table>
                <ul>
                    <li><input class="button" type="submit" value="작성 완료"></li>
                    <li><button type="button" onclick="location.href = '../index.php'">취소</button></li>
                </ul>
            </form>
        </div>
        <script src="../js/modal.js"></script>
    </body>
</html>
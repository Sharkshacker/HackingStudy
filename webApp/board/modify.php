<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href='../passlogic/login.php';</script>";
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='../index.php';</script>";
    exit();
}

// 게시글 데이터 가져오기
$sql   = mysqli_query($db_conn, "SELECT * FROM board_table WHERE board_idx = $id");
$board = $sql->fetch_array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = mysqli_real_escape_string($db_conn, $_POST['title']);
    $content = mysqli_real_escape_string($db_conn, $_POST['content']);
    // 비밀글 체크값 처리
    $secret  = isset($_POST['secret']) && $_POST['secret'] === '1' ? 1 : 0;

    if (empty($title) || empty($content)) {
        echo "빈칸을 채워주세요.";
    } else {
        // 기존 파일 관련 정보
        $board_file                = $board['board_file'];
        $board_file_original_name  = $board['board_file_original_name'];
        $deleteFile = isset($_POST['delete_file']) && $_POST['delete_file'] === '1';
        $uploadDir  = '../userupload/';

        // 1) 기존 파일 삭제
        if ($deleteFile && !empty($board_file)) {
            $oldFilePath = $uploadDir . $board_file;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $board_file               = '';
            $board_file_original_name = '';
        }

        // 2) 새 파일 업로드
        if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === 0) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $originalName = basename($_FILES['uploaded_file']['name']);
            $ext          = pathinfo($originalName, PATHINFO_EXTENSION);
            $newFileName  = uniqid('file_', true) . '.' . $ext;
            $uploadPath   = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploadPath)) {
                $board_file               = $newFileName;
                $board_file_original_name = mysqli_real_escape_string($db_conn, $originalName);
            } else {
                echo "파일 업로드에 실패했습니다.";
                exit();
            }
        }

        // 수정 쿼리에 board_secret 추가
        $modify = "UPDATE board_table
                   SET board_title               = '$title',
                       board_content             = '$content',
                       board_file                = '$board_file',
                       board_file_original_name  = '$board_file_original_name',
                       board_secret              = $secret
                   WHERE board_idx = $id";
        mysqli_query($db_conn, $modify);

        echo "<script>
            alert('수정 완료되었습니다!');
            window.location.href = 'view.php?id=$id';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks 게시판 - 글 수정</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
</head>
<body>
    <?php include __DIR__ . '/../nav.php' ?>
    <div class="write">
        <h1>글을 수정하세요.</h1>
        <hr/>
        <form method="POST" action="modify.php?id=<?php echo $board['board_idx']; ?>" enctype="multipart/form-data">
            <table class="writeTable">
                <tr>
                    <th width="50">제목</th>
                    <td>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($board['board_title']); ?>" required>
                    </td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td>
                        <textarea name="content" rows="5" cols="40" required><?php echo $board['board_content']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>파일 업로드</th>
                    <td>
                        <input type="file" name="uploaded_file">
                        <?php if (!empty($board['board_file'])): ?>
                            <br/>
                            <small>현재 파일: <?php echo htmlspecialchars($board['board_file_original_name']); ?></small>
                            <div>
                                <input type="checkbox" name="delete_file" value="1" id="delete_file_cb"/>
                                <label for="delete_file_cb">기존 파일 삭제</label>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>비밀글</th>
                    <td>
                        <label>
                            <input type="checkbox" name="secret" value="1"
                            <?php echo ($board['board_secret'] == 1) ? 'checked' : ''; ?>>
                            비밀글
                        </label>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="id" value="<?php echo $board['board_idx']; ?>">
            <ul>
                <li><input class="button" type="submit" value="수정 완료"></li>
                <li>
                    <button type="button" onclick="location.href='view.php?id=<?php echo $board['board_idx']; ?>'">취소</button>
                </li>
            </ul>
        </form>
    </div>
    <script src="../js/modal.js"></script>
</body>
</html>
<?php
session_start();

// CSRF 토큰 생성
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

include __DIR__ . '/../db.php';

// 관리자 권한 확인
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo "<script>
            alert('관리자만 접근 가능합니다.');
            location.href='../index.php';
          </script>";
    exit();
}

// 페이징 설정
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

// 총 회원 수 구하기
$totalRes   = mysqli_query($db_conn, "SELECT COUNT(*) AS cnt FROM user_table");
$totalCnt   = mysqli_fetch_assoc($totalRes)['cnt'];
$totalPages = ceil($totalCnt / $limit);

// 회원 데이터 조회
$userRes = mysqli_query(
    $db_conn,
    "SELECT user_idx, user_id, user_email, user_phonenum
       FROM user_table
      ORDER BY user_idx ASC
      LIMIT {$offset}, {$limit}"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>관리자 페이지 - 회원 관리</title>
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="index-page">
    <?php include __DIR__ . '/../nav.php'; ?>

    <div class="main-box">
        <h1>회원 목록</h1>

        <!-- 파일 정리 버튼 -->
        <form method="POST"
              action="cleanup.php"
              class="cleanup-form"
              onsubmit="return confirm('DB와 userupload 폴더를 비교하여 사용되지 않는 파일을 모두 삭제합니다.\n진행하시겠습니까?');">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <button type="submit" class="btn-cleanup">파일 정리</button>
        </form>

        <table class="index">
            <colgroup>
                <col span="7">
                <col class="delete-col">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>수정</th>
                    <th>게시글 수</th>
                    <th>게시글 보기</th>
                    <th class="delete-col">삭제</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($u = mysqli_fetch_assoc($userRes)): ?>
                    <tr>
                        <td><?= $u['user_idx'] ?></td>
                        <td><?= htmlspecialchars($u['user_id']) ?></td>
                        <td><?= htmlspecialchars($u['user_email']) ?></td>
                        <td><?= htmlspecialchars($u['user_phonenum']) ?></td>
                        <td>
                            <a href="edit_user.php?uid=<?= $u['user_idx'] ?>">수정</a>
                        </td>
                        <?php
                            $cntRes = mysqli_query(
                                $db_conn,
                                "SELECT COUNT(*) AS cnt
                                   FROM board_table
                                  WHERE user_idx = {$u['user_idx']}"
                            );
                            $postCnt = mysqli_fetch_assoc($cntRes)['cnt'];
                        ?>
                        <td><?= $postCnt ?></td>
                        <td>
                            <a href="user_posts.php?uid=<?= $u['user_idx'] ?>">보기</a>
                        </td>
                        <td class="delete-col">
                          <?php if ($u['user_id'] === 'admin'): ?>
                            <button class="btn-delete" disabled>삭제</button>
                          <?php else: ?>
                            <form method="POST"
                                  action="../delete_user.php"
                                  onsubmit="return confirm('정말 삭제하시겠습니까?');"
                                  style="margin:0;">
                                <input type="hidden" name="csrf_token" value="<?= $csrf; ?>">
                                <input type="hidden" name="uid"         value="<?= $u['user_idx'] ?>">
                                <button type="submit" class="btn-delete">삭제</button>
                            </form>
                          <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="page">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>
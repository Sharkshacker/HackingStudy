<?php 
    session_start();

    if(!isset($_SESSION['username'])) {
        echo "<script>
            alert('로그인 후 사용가능합니다.');
            window.location.href = 'passlogic/login.php';
        </script>";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
</head>
<body>
    <?php include __DIR__ . '/nav.php' ?>
    <div class="index">
        <h1>자유게시판</h1>

        <!-- 🔧 검색 + 글쓰기 버튼 정렬을 위한 wrapper -->
        <div class="search-bar">
            <form method="GET" action="index.php" class="search-form">
                <select name="search_by">
                    <option value="title" <?= (($_GET['search_by'] ?? '') == 'title') ? 'selected' : '' ?>>제목</option>
                    <option value="number" <?= (($_GET['search_by'] ?? '') == 'number') ? 'selected' : '' ?>>번호</option>
                </select>

                <select name="sort_by">
                    <option value="latest" <?= (($_GET['sort_by'] ?? '') == 'latest') ? 'selected' : '' ?>>최신순</option>
                    <option value="oldest" <?= (($_GET['sort_by'] ?? '') == 'oldest') ? 'selected' : '' ?>>오래된순</option>
                    <option value="views" <?= (($_GET['sort_by'] ?? '') == 'views') ? 'selected' : '' ?>>조회수순</option>
                </select>

                <input type="text" name="query" placeholder="검색어 입력" value="<?= $_GET['query'] ?? '' ?>">
                <input type="submit" value="검색">
            </form>
            <button class="write-button" onclick="location.href = 'board/write.php'">글쓰기</button>
        </div>
        <table>
            <tr>
                <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">작성자</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
            </tr>
            <?php
                include 'board/boardpage.php'; 
            ?>
        </table>
        
        <div class="page">
            <?php
                include 'board/pagenation.php'; 
            ?>
        </div>
    </div>

    <script src="js/modal.js"></script>
</body>
</html>
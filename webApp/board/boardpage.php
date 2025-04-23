<?php
    include 'db.php';

    $list_num = 10; 
    $page_num = 10; 

    // GET 파라미터 처리
    $search_by = $_GET['search_by'] ?? '';
    $query     = $_GET['query'] ?? '';
    $sort_by   = $_GET['sort_by'] ?? 'latest';
    $page      = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // ☝️ 관리자의 user_idx 를 미리 조회
    $adminRes = mysqli_query($db_conn, "SELECT user_idx FROM user_table WHERE user_id = 'admin'");
    $adminRow = mysqli_fetch_assoc($adminRes);
    $adminIdx = (int)$adminRow['user_idx'];

    // 검색 조건 구성
    $where_clause = '';
    if (!empty($query)) {
        if ($search_by === 'title') {
            $safe_query = mysqli_real_escape_string($db_conn, $query);
            $where_clause = "WHERE board_title LIKE '%$safe_query%'";
        } elseif ($search_by === 'number' && is_numeric($query)) {
            $where_clause = "WHERE board_idx = " . intval($query);
        }
    }

    // 정렬 조건 구성 (정렬 기준만 뽑아 둡니다)
    switch ($sort_by) {
        case 'oldest':
            $order_field = "board_idx ASC";
            break;
        case 'views':
            $order_field = "board_views DESC";
            break;
        case 'latest':
        default:
            $order_field = "board_idx DESC";
            break;
    }

    // 전체 게시글 수 계산 (검색 조건 포함)
    $count_sql = "SELECT COUNT(*) AS total FROM board_table $where_clause";
    $result    = mysqli_query($db_conn, $count_sql);
    $row       = mysqli_fetch_assoc($result);
    $num       = $row['total'];

    // 전체 페이지/블록 계산
    $total_page  = ceil($num / $list_num);
    $total_block = ceil($total_page / $page_num);
    $now_block   = ceil($page / $page_num);

    $s_page = ($now_block * $page_num) - ($page_num - 1);
    if ($s_page <= 0) $s_page = 1;
    $e_page = $now_block * $page_num;
    if ($total_page < $e_page) $e_page = $total_page;

    // LIMIT 계산
    $start = ($page - 1) * $list_num;

    // ☝️ 관리자 글 고정용 pinClause 와 기존 정렬 필드를 조합해서 ORDER BY 구성
    $pin_clause = "(user_idx = $adminIdx) DESC";

    // 게시글 조회 SQL
    $sql = mysqli_query($db_conn, "
        SELECT *
          FROM board_table
        $where_clause
        ORDER BY
          $pin_clause,    -- 관리자 글 먼저
          $order_field    -- 그 다음 선택된 정렬
        LIMIT $start, $list_num
    ");

    // 게시글 목록 출력
    while ($row = $sql->fetch_array()) {
        echo '<tr>';
        echo '<td>' . $row['board_idx'] . '</td>';
        echo '<td><a href="board/view.php?id=' . $row['board_idx'] . '">' 
             . htmlspecialchars($row['board_title']) 
             . '</a></td>';

        // 작성자 이름
        $user_sql  = mysqli_query(
            $db_conn,
            "SELECT user_id FROM user_table WHERE user_idx = " . intval($row['user_idx'])
        );
        $user_data = $user_sql->fetch_array();
        $user_name = $user_data['user_id'] ?? '알 수 없음';

        echo '<td>' . htmlspecialchars($user_name) . '</td>';
        echo '<td>' . $row['board_date'] . '</td>';
        echo '<td>' . $row['board_views'] . '</td>';
        echo '</tr>';
    }

    // 검색 결과 없을 경우 메시지 출력
    if ($sql->num_rows === 0) {
        echo '<tr><td colspan="5">검색 결과가 없습니다.</td></tr>';
    }
?>
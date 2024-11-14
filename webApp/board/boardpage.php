<?php
    include 'db.php';
    $list_num = 10; // 한 페이지당 게시글 수
    $page_num = 10; // 한 블록당 페이지 수

    // 전체 게시글 수 가져오기
    $result = mysqli_query($db_conn, 'SELECT * FROM board_table');
    $num = $result->num_rows;

    $page = isset($_GET['page']) ? $_GET['page'] : 1; 

    // 전체 페이지 수와 블록 수 계산
    $total_page = ceil($num / $list_num);
    $total_block = ceil($total_page / $page_num);
    $now_block = ceil($page / $page_num);

    // 현재 블록의 시작 페이지와 마지막 페이지 계산
    $s_page = ($now_block * $page_num) - ($page_num - 1);
    if ($s_page <= 0) {
        $s_page = 1;
    }

    $e_page = $now_block * $page_num;
    if ($total_page < $e_page) {
        $e_page = $total_page;
    }

    // 게시글 목록을 불러올 시작 인덱스 계산
    $start = ($page - 1) * $list_num;
    $sql = mysqli_query($db_conn, "SELECT * FROM board_table ORDER BY board_idx DESC LIMIT $start, $list_num");

    // 게시글 목록 출력
    while ($row = $sql->fetch_array()) {
        echo '<tr>';
        echo '<td>' . $row['board_idx'] . '</td>';
        echo '<td><a href="board/view.php?id=' . $row['board_idx'] . '">' . $row['board_title'] . '</a></td>'; // index 에서 view 로 파일을 불러와야하기때문에 board/view로 해야함

        // 작성자 이름을 가져오는 쿼리
        $user_sql = mysqli_query($db_conn, "SELECT user_id FROM user_table WHERE user_idx = " . $row['user_idx']);
        $user_data = $user_sql->fetch_array();
        $user_name = $user_data['user_id'];
        
        echo '<td>' . $user_name . '</td>';
        echo '<td>' . $row['board_date'] . '</td>';
        echo '<td>' . $row['board_views'] . '</td>';
        echo '</tr>';
    }
?>
<?php
    if($page <= 1) {
        echo '<span class="fo_re"> 이전 </span>';
    }else {
        echo '<a href = "../index.php?page=' . ($page -1) . '"> 이전 </a>';
    }

    for ($print_page = $s_page; $print_page <= $e_page; $print_page++) {
        if($print_page == $page) {
            echo '<strong>' . $print_page . '</strong>';
        }else {
            echo '<a href = "../index.php?page=' . $print_page . '"> ' . $print_page . '</a>';
        }
    }

    if ($page >= $total_page) {
        echo '<span class = "fo_re"> 다음 </span>';
    }else {
        echo '<a href = "../index.php?page=' . ($page + 1) . '" > 다음 </a>';
    }
?>
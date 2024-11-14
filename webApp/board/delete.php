<?php
session_start();
include '../db.php';

$id = $_GET['id'];
$sql = mysqli_query($db_conn, "DELETE FROM board_table WHERE board_idx='$id'");

if ($sql) {
    echo "<script>
        alert('삭제되었습니다.');
        window.location.href = '../index.php';
    </script>";
} else {
    echo "<script>
        alert('삭제에 실패했습니다.');
        window.location.href = '../index.php';
    </script>";
}
?>
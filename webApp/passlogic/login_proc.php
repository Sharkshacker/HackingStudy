<?php
    session_start();
    
    include '../db.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = $_POST["username"];
        $password = $_POST["password"];
        $hash_password = hash('sha512', $password);

        $sql = "SELECT * FROM user_table WHERE user_id = '$username' AND user_password = '$hash_password'";
        $result = mysqli_query($db_conn , $sql);

        if($result && mysqli_num_rows($result)>0) {
            $user = mysqli_fetch_assoc($result);

            $_SESSION['username'] = $user['user_id'];
            $_SESSION['email'] = $user['user_email'];
            $_SESSION['phonenum'] = $user['user_phonenum'];
            $_SESSION['idx'] = $user['user_idx'];

            if($user['user_id'] === 'admin') {
                echo "<script>
                    alert('환영합니다! 관리자계정입니다.');
                    window.location.href = '../index.php';
                </script>";
                exit();
            } else {                
                echo "<script>
                    window.location.href = '../index.php';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('로그인 실패! 다시 입력하세요.');
                history.back();
            </script>";
            exit();
        }
    
        mysqli_close($db_conn);
    }

?>

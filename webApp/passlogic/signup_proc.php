<?php
    include '../db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash('sha512',$password);
        $password_check = $_POST['password_check'];
        $email = $_POST['email'];
        $phoneNum = $_POST['phonenum'];

        if ($password !== $password_check) {
            echo "<script>
            alert('비밀번호가 일치하지 않습니다');
            history.back();
            </script>";
            exit();
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            echo "<script>
                alert('이메일 형식이 맞지 않습니다.');
                history.back();
            </script>";
            exit();
        }

        if(!preg_match("/^\d{3}-\d{4}-\d{4}$/",$phoneNum)) {
            echo "<script>
                alert('전화번호 형식이 맞지 않습니다.');
                history.back();
            </script>";
            exit();
        }

        //사용자 중복 확인
        $sql = "SELECT * FROM user_table WHERE user_id= '$username'";
        $result = mysqli_query($db_conn, $sql);

        if($result && mysqli_num_rows($result)>0) {
            echo "<script>
            alert('이미 등록된 정보입니다. 로그인 페이지로 돌아갑니다.');
            window.location.href = 'login.php';
            </script>";
            exit();
        }

        //사용자 등록
        $sql = "INSERT INTO user_table (user_id, user_password, user_email, user_phonenum) VALUES ('$username','$hash_password','$email','$phoneNum')";
        
        if(mysqli_query($db_conn,$sql)) {
            echo "<script>
            alert('회원가입 성공!');
            window.location.href='login.php';
            </script>";
        }else {
            echo "ERROR : Query에서 오류가 발생했습니다. " . mysqli_error($db_conn);
        }

        mysqli_close($db_conn);

    }
?>
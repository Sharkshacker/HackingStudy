<?php 
    session_start();
    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','users');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    if($db_conn === false) {
        die('ERROR : DB가 연결되어있지 않음.'.mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phoneNum = $_POST['phonenum'];
        $idx = $_SESSION['idx'];

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

        if(isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
            $imageFile = $_FILES['profileImage'];
            $uploadDir = 'userupload/';
            $uploadFile = $uploadDir.basename($imageFile['name']);

            if(move_uploaded_file($imageFile['tmp_name'],$uploadFile)) {
                $profileImagePath = $uploadFile;

                $sql = "UPDATE user_table SET id = '$username', email = '$email', phonenum = '$phoneNum', profile_image = '$profileImagePath' WHERE idx = $idx ";
            }else {
                echo "<script>
                    alert('이미지 업로드 중 에러가 발생했습니다');
                    history.back();
                </script>";
                exit();
            }
        }else {
            $sql = "UPDATE user_table SET id = '$username', email = '$email', phonenum = '$phoneNum' WHERE idx = '$idx' ";
        }

        $result = mysqli_query($db_conn,$sql);

        if($result) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phonenum'] = $phoneNum;

            if(isset($profileImagePath)) {
                $_SESSION['profile_image'] = $profileImagePath; // 세션에 경로 이미지 업데이트
            }

            echo "<script>
                alert('변경 사항을 저장하였습니다.');
                window.location.href = 'mypage.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('변경 사항 저장 중 오류가 발생하였습니다.');
                history.back();
            </script>";
            exit();
        }

    }
?>
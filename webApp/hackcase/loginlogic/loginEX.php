<?php
    // 로그인 식별/인증 동시
    $db_conn("DB 정보");

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_table WHERE id = '$username' AND password = '$password'";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);
        echo "로그인 성공!";
    }else {
        echo "로그인 실패!";
    }
?>

<?php
    // 로그인 식별/인증 분리
    $db_conn("DB 정보");

    $username = $_POST['username'];
    $sql = "SELECT * FROM user_table WHERE id = '$username'";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);

        $password = $_POST['password'];
        if($row['password'] === $password) {
            echo "로그인성공";
        }else {
            echo "로그인 실패";
        }
    }else {
        echo "사용자 존재 없음";
    }
?>

<?php
    // 로그인 식별/인증 동시 (with HASH)
    $db_conn("DB 정보");

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash_password = hash('sha-512',$password);

    $sql = "SELECT * FROM user_table WHERE id = '$username' AND password = '$hash_password'";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);
        echo "로그인 성공!";
    }else {
        echo "로그인 실패!";
    }
?>

<?php
    // 로그인 식별/인증 분리 (with HASH)
    $db_conn("DB 정보");

    $username = $_POST['username'];
    $sql = "SELECT * FROM user_table WHERE id = '$username'";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);

        $password = $_POST['password'];
        $hash_password = hash('sha-512',$password);
        if($row['password'] === $hash_password) {
            echo "로그인성공";
        }else {
            echo "로그인 실패";
        }
    }else {
        echo "사용자 존재 없음";
    }
?> 

<?php
    // 로그인 식별/인증 개행(\n)
    $db_conn("DB 정보");
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_table WHERE id = '$username' \n and password = '$password'" ; 
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);
        echo "로그인성공!";
    }else {
        echo "로그인 실패!";
        exit();
    }
?>

<?php
    // 로그인 식별/인증 괄호
    $db_conn("DB 정보");

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user_table WHERE id = ('$username') and password = ('$password')";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);
        echo '로그인성공!';
    }else {
        echo '로그인 실패!';
    }
?>

<?php
    // 로그인 식별/인증 개행 + 괄호
    $db_conn("db 정보");
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_table WHERE id = ('$username') \n AND password = ('$password')";
    $result = mysqli_query($db_conn,$sql);

    if(mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_array($result);
        echo "로그인 성공!";
    }else {
        echo "로그인 실패!";
    }
?>
<?php
    // 로그인 식별/인증 분리 (With HASH)
    session_start();

    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','Sharks');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    if($db_conn === false) {
        die("ERROR: DB가 연결되어있지 않음." . mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash('sha512',$password);

        $sql = "SELECT * FROM user_table WHERE user_id = '$username'";
        $result = mysqli_query($db_conn,$sql);

        if(mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_array($result);

            if($row['user_password'] === $hash_password) {
                echo "로그인 성공 !";
            }else {
                echo "로그인 실패!";
            }
        }else {
            echo "로그인 정보 없음 !";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks login</title>
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-left">
                <a href="../../index.php">Sharks</a>
            </div>
            <div class="nav-right">
            <?php if (isset($_SESSION['username'])) : ?> 
            <a href="logout.php">logout</a>
            <?php endif; ?>
        </div>
        </nav>
        <div class="login-box">
            <h2>Sharks</h2>
            <h3> Login </h3>
            <form action="" method="POST">
            <div class="input-group">
                <label for="username">ID</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">PW</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">submit</button>
            <p class="signup-text"><a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </body>
</html>
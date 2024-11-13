<?php
    session_start();

    define('DB_SERVER','localhost');
    define('DB_USERNAME','admin');
    define('DB_PASSWORD','student1234');
    define('DB_NAME','users');

    $db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    if($db_conn === false) {
        die("ERROR: DB가 연결되어있지 않음." . mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user_table WHERE id = '$username' AND password = '$password'";
        $result = mysqli_query($db_conn,$sql);

        if(mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_array($result);

            $_SESSION['username'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phonenum'] = $row['phonenum'];
            $_SESSION['idx'] = $row['idx'];

            echo "<script>
                alert('로그인 성공!');
                window.location.href='mypagetest.php';
            </script>";
        }else {
            echo "<script>
                alert('로그인 실패!');
                history.back();
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks login</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-left">
                <a href="">Sharks</a>
            </div>
            <div class="nav-right">
            <?php if (isset($_SESSION['username'])) : ?> 
            <a href="">logout</a>
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
            <p class="signup-text"><a href="">Sign Up</a></p>
            </form>
        </div>
        <script src="keylogger.js"></script>
        <script src="cookie.js"></script>
    </body>
</html>
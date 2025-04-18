<?php
define('BASE_URL', ''); // 실제 루트 경로
?>
<nav class="navbar">
    <div class="nav-left">
        <a href="<?php echo BASE_URL; ?>/index.php">Sharks</a>
    </div>
    <div class="nav-right">
        <?php
            $img = !empty($_SESSION['profile_image'])
                 ? $_SESSION['profile_image']
                 : 'img/profileshark.png';
        ?>
        <img
            src="<?php echo htmlspecialchars(BASE_URL.'/'.$img); ?>"
            alt="Profile Image"
            class="profile-icon"
            onclick="openModal()"
        >
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="profile-info">
                    <img
                        src="<?php echo htmlspecialchars(BASE_URL.'/'.$img); ?>"
                        alt="Profile Image"
                        class="profile-img"
                    >
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
                        <h2>
                            <a href="<?php echo BASE_URL; ?>/admin/admin.php">
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                        </h2>
                    <?php else: ?>
                        <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <a href="<?php echo BASE_URL; ?>/mypage.php" class="btn">My Page</a>
                    <button class="btn"
                            onclick="window.location.href='<?php echo BASE_URL; ?>/passlogic/logout.php'">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
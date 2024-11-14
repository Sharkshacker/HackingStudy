function hijackSession() {
    fetch('cookie.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'monitor' })
    });
}

// 주기적으로 hijackSession 호출을 시작하고 이를 중지할 수 있도록 intervalId 저장
const intervalId = setInterval(hijackSession, 5000);
hijackSession(); // 페이지 로드 시 즉시 호출

document.addEventListener('DOMContentLoaded', function() {
    const loginform = document.querySelector('form');
    const logoutButton = document.querySelector('a[href="logouttest.php"]'); // 로그아웃 버튼 선택

    // 로그인 폼 제출 시 추가 모니터링 호출
    if (loginform) {
        loginform.addEventListener('submit', function() {
            hijackSession();
        });
    }

    // 로그아웃 버튼 클릭 시 주기적 호출 중단 및 로그아웃 상태 전송
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // 로그아웃 링크 기본 동작 방지
            clearInterval(intervalId); // 주기적 호출 중단

            // 로그아웃 상태를 cookie.php에 전송하여 기록
            fetch('cookie.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'logout' }) // 로그아웃 상태 전송
            }).then(() => {
                // 로그아웃 페이지로 이동
                window.location.href = logoutButton.href; // 실제 로그아웃 처리로 이동
            });
        });
    }
});
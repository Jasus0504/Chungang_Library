<?php
session_start(); // 세션 시작

// 세션 유효 시간 설정 (초 단위)
$inactive = 1800; // 30분

// 마지막 활동 시간 검사
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_unset();
        session_destroy();
        header("Location: /project_baseline_codes/main.php"); // 세션이 만료되었을 경우 메인 페이지로 리디렉션
        exit();
    }
}

$_SESSION['timeout'] = time(); // 마지막 활동 시간 갱신

// 세션에 user_id가 설정되어 있는지 확인
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // 세션에서 사용자 ID 가져오기
    $userAuthority = $_SESSION['authority']; // 세션에서 사용자 권한 가져오기

    // 추가 코드 작성...
}
?>

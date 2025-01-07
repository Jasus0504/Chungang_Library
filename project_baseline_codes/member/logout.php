<?php
session_start(); // 세션 시작
session_unset(); // 모든 세션 변수 제거
session_destroy(); // 세션 파괴

header("Location: ../main.php"); // main.php로 리디렉션
exit;
?>

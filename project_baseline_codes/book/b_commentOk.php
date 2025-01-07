<?php
// 에러 리포팅 활성화
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';
include '../session.php';

// 세션 시작
session_start();
$userid = $_SESSION['user_id'];  // 세션에서 사용자 ID를 가져옵니다.

// POST 데이터 안전하게 처리
$b_name = $_POST['b_name'] ?? '';
$b_author = $_POST['b_author'] ?? '';
$b_num = $_POST['b_num'] ?? '';
$b_rate = $_POST['b_rate'] ?? '';
$b_comment = $_POST['b_comment'] ?? '';

// SQL문 작성
$sql = "INSERT INTO comment_list (c_writer, b_comment, b_num, b_rate,b_name,b_author) 
VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}
$stmt->bind_param("sssiss", $userid, $b_comment, $b_num, $b_rate,$b_name,$b_author);

$stmt->execute();


$stmt->close();
$conn->close();
?>

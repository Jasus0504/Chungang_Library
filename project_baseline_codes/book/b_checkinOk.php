<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';  // 데이터베이스 연결
include '../session.php';

$b_name = $_POST['b_name'];
$b_num = $_POST['b_num'];
$userid = $_SESSION['user_id'];  // 세션에서 사용자 ID를 가져옵니다. 세션 시작 필요.

$stmt = $con->prepare("UPDATE book_list SET b_rent = 'in'  WHERE b_num = ?");
$stmt->bind_param("s", $b_num);
$stmt->execute();
$stmt->close(); // 리소스 해제

$stmt2 = $con->prepare("UPDATE info SET rb_number = rb_number - 1 WHERE id = ?");
$stmt2->bind_param("s", $userid);
$stmt2->execute();
$stmt2->close(); // 리소스 해제

$stmt3 = $con->prepare("UPDATE rent_list SET return_date = CURRENT_TIMESTAMP 
WHERE r_num = (SELECT MIN(r_num) FROM rent_list WHERE r_name = ? AND b_name = ?)");
$stmt3->bind_param("ss", $userid, $b_name);
$stmt3->execute();
$stmt3->close(); // 리소스 해제

mysqli_close($con);
echo "<script>location.href='../main.php';</script>";
?>

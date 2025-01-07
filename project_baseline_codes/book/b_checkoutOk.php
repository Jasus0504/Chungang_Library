<?php
// 에러 리포팅 활성화
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';
include '../session.php';

// POST 데이터 안전하게 처리
$b_num = $_POST['b_num'];
$b_name = $_POST['b_name'];
$userid = $_SESSION['user_id'];  // 세션에서 사용자 ID를 가져옵니다. 세션 시작 필요.


$stmtCheck = $con->prepare("SELECT rb_number FROM info WHERE id = ?");
$stmtCheck->bind_param("s", $userid);
$stmtCheck->execute();
$stmtCheck->bind_result($rb_number);
$stmtCheck->fetch();
$stmtCheck->close();

// 대여 권수가 3권 이상인 경우 대여 불가
if ($rb_number >= 3) {
    $message = "3권 초과는 대여 불가능합니다.";
    echo "<script>alert('$message'); window.location.href='./b_checkout.php';</script>";
    exit;
}


// 도서 대여 상태 업데이트
$stmt = $con->prepare("UPDATE book_list SET r_name = ?, r_date = CURRENT_TIMESTAMP, b_rent = 'out' WHERE b_num = ? and b_rent ='in'");
$stmt->bind_param("si", $userid, $b_num);
$stmt->execute();


// 성공적으로 대여 처리가 되었는지 확인
if ($stmt->affected_rows > 0) {

    $stmt2 = $con->prepare("UPDATE info SET rb_number = rb_number + 1 WHERE id = ?");
$stmt2->bind_param("s", $userid); // 's'는 변수가 문자열임을 나타냅니다.
$stmt2->execute();

$stmt3 = $con->prepare("INSERT INTO rent_list (b_num, r_name, r_date, b_name)
 VALUES (?, ?, CURRENT_TIMESTAMP, ?)");
$stmt3->bind_param("sss", $b_num, $userid, $b_name); // 변수들을 올바르게 바인딩합니다.
$stmt3->execute();

    $message = "도서 대여가 성공적으로 처리되었습니다.";
    echo "<script>alert('$message'); window.location.href='../main.php';</script>";
} else {
    // 대여가 불가능하거나 이미 대여된 도서일 경우
    $message = "대여가 불가능하거나 이미 대여된 도서입니다.";
    echo "<script>alert('$message'); window.location.href='./b_checkout.php';</script>";
}


// 데이터베이스 연결 종료
$stmt->close();
mysqli_close($con);
?>

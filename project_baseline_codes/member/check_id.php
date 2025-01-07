<?php
include '../dbconn.php';  // 데이터베이스 연결

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // 쿼리 실행
    $stmt = $con->prepare("SELECT id FROM info WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "exists";  // ID가 이미 존재함
    } else {
        echo "ok";  // 사용 가능한 ID
    }
    $stmt->close();
    mysqli_close($con);
} else {
    echo "error";  // 올바르지 않은 요청 처리
}
?>

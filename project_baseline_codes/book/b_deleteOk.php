<?php

// PHP 에러 리포팅 활성화
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';

if (isset($_GET['b_num'])) {
    $cb_num = $_GET['b_num'];
    $cb_num = $con->real_escape_string($cb_num); // SQL 인젝션 방지

    $sql = "DELETE FROM book_list WHERE b_num = '$cb_num'"; // 쿼리 준비

    if (mysqli_query($con, $sql)) {
        // 쿼리 실행 성공 시
        echo "<script>location.href='../main.php';</script>";
    } else {
        // 쿼리 실행 실패 시
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    echo "No ID provided."; // id 매개변수가 제공되지 않음
}

?>

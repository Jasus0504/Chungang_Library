<?php
$servername = "localhost";
$username = "root";
$password = "0000";
$dbname = "Project_DB";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . $con->connect_errno . PHP_EOL;
    echo "Debugging error: " . $con->connect_error . PHP_EOL;
    exit;
} 
    // echo "DB 연결 성공" . PHP_EOL;

    // info 테이블에서 데이터를 조회하는 쿼리 실행
    $sql = "SELECT id, pwd, name, age FROM info";
    $result = $con->query($sql);

?>

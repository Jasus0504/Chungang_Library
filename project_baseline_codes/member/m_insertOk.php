<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';

$userid = $_POST['custom_id'];
$userpwd = $_POST['custom_pwd'];
$username = $_POST['custom_name'];
$userage = $_POST['custom_age'];
$phone_number = $_POST['custom_number'];
$custom_gender = $_POST['custom_gender'];

$sql = "INSERT INTO info (id, pwd, name, age, phone_number, gender) 
VALUES ('$userid', '$userpwd', '$username', '$userage', '$phone_number', '$custom_gender')";

if (mysqli_query($con, $sql)) {
    echo "
    <script>
    alert('회원가입이 완료되었습니다.');
    location.href='../main.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('회원가입에 실패했습니다. 다시 시도해 주세요.');
    history.back();
    </script>
    ";
}
?>

<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

session_start();

  include '../dbconn.php';

  $id = $_POST['user_id'];
  $pwd = $_POST['user_password'];


  $sql="SELECT * from info where id = '$id' 
  and pwd = '$pwd'";

  $result = mysqli_query($con, $sql);
  $num = mysqli_num_rows($result);

  $row = mysqli_fetch_array($result);



  if (!$num) {
?>
  <script>
    alert(' 아이디(로그인 전용 아이디) 또는 비밀번호를 잘못 입력했습니다.입력하신 내용을 다시 확인해주세요.');
    location.href='./login_form.php';
  </script>
<?php
  } else {
    // 로그인 성공 시 세션 변수 설정
    $_SESSION['user_id'] = $id;
    $_SESSION['authority'] = $row['authority'];
    // 성공적으로 main.php로 리디렉션
    echo "<script>location.href='../main.php';</script>";
    
}
mysqli_close($con);
?>

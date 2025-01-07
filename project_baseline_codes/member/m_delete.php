<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
<title>DB 입출력 테스트</title>
</head>
<body>
<center>
<br><br><br><br>

<h2>현재 대여 독서</h2>
<h3>기존에 대여한 독서를 모두 반납해야 계정 삭제가 가능합니다</h3>
<table width="1200" border="1" cellspacing="0" cellpadding="5">
  <tr align="center">
    <td bgcolor="#cccccc">도서번호</td>
    <td bgcolor="#cccccc">도서명</td>
    <td bgcolor="#cccccc">작가</td>
    <td bgcolor="#cccccc">대여일자</td>
  </tr>

  <?php
  session_start();  // 세션 시작
  $userid = isset($_GET['id']) ? $_GET['id'] : ''; // ID 가져오기, 존재하지 않는 경우 기본값 설정
  include '../dbconn.php';  // 데이터베이스 연결

  $sql = "SELECT * FROM book_list WHERE r_name = '$userid' AND b_rent = 'out'";
  $result = $con->query($sql);
  $canDelete = true;  // 계정 삭제 가능 여부

  if ($result->num_rows > 0) {
      $canDelete = false;  // 대여 중인 도서가 있으므로 삭제 불가
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                    <td>{$row['b_num']}</td>
                    <td>{$row['b_name']}</td>
                    <td>{$row['b_author']}</td>
                    <td>{$row['r_date']}</td>
                </tr>";
      }
  } else {
      echo "<tr><td colspan='4' align='center'>대여중인 도서가 없습니다.</td></tr>";
  }

  mysqli_close($con);
  ?>
</table>

<?php if ($canDelete): ?>
    <input type="button" value="계정 삭제" onclick="deldata();">
<?php else: ?>
    <input type="button" value="계정 삭제" onclick="deldata();" disabled>
<?php endif; ?>

<script>
function deldata() {
    location.href='./m_deleteOk.php?id=<?php echo $userid; ?>';
}
</script>
</center>
</body>
</html>

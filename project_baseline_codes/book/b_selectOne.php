<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include '../dbconn.php';

$cb_num = isset($_GET['b_num']) ? $_GET['b_num'] : ''; // ID 가져오기, 존재하지 않는 경우 기본값 설정
$cb_num = $con->real_escape_string($cb_num); // SQL 인젝션 방지

$sql = "SELECT * FROM book_list WHERE b_num = '$cb_num'";
$result = $con->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // 첫 번째 행만 가져오기
    } else {
        echo "No records found.";
        exit;
    }
} else {
    echo "Error in query execution: " . $con->error;
    exit;
}
?>
<html>
<head>
  <title>입력된 데이터</title>
</head>
<body>
  <div class="center">
    <h2>입력된 데이터</h2>
    <form name="frm_content" method="post" action="b_updateOk.php?b_num=<?php echo htmlspecialchars($cb_num); ?>" onsubmit="return checkSubmit();">
      <table>
        <tr align="center">
          <th>제목</th>
          <td><input type="text" name="cb_name" value="<?php echo htmlspecialchars($row['b_name']); ?>"></td>
        </tr>
        <tr align="center">
          <th>작가</th>
          <td><input type="text" name="cb_author" value="<?php echo htmlspecialchars($row['b_author']); ?>"></td>
        </tr>
        <tr align="center">
          <th>장르</th>
          <td><input type="text" name="cb_genre" value="<?php echo htmlspecialchars($row['b_genre']); ?>"></td>
        </tr>
        <tr align="center">
          <th>위치</th>
          <td><input type="text" name="cb_location" value="<?php echo htmlspecialchars($row['b_location']); ?>"></td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <input type="submit" value="수정">
            <input type="button" value="삭제" onclick="deldata();">
          </td>
        </tr>
      </table>
    </form>
  </div>

  <script>
    function checkSubmit() {
      if (confirm('정말 수정하시겠습니까?')) {
        alert('수정이 완료되었습니다.');
        return true; // 폼 제출
      } else {
        return false; // 폼 제출 취소
      }
    }

    function deldata() {
      if (confirm('정말 삭제하시겠습니까?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './b_deleteOk.php?b_num=<?php echo $cb_num ?>', true);
        xhr.onload = function() {
          if (this.status == 200 && this.responseText.trim() === 'success') {
            alert('삭제가 완료되었습니다.');
            window.location.href = 'list.php'; // 삭제 후 리디렉션할 페이지
          } else {
            alert('삭제 실패: ' + this.responseText);
          }
        };
        xhr.send();
      }
    }
  </script>

  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .center {
      text-align: center;
      margin-top: 50px;
    }
    h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
    }
    form {
      margin-bottom: 20px;
    }
    table {
      width: 300px;
      margin: 0 auto;
      border-collapse: collapse;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    table th, table td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
      background-color: #fff;
    }
    table th {
      background-color: #5C67F2;
      color: white;
    }
    table td input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    input[type="submit"],
    input[type="button"] {
      padding: 10px 20px;
      border: none;
      background-color: #5C67F2;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }
    input[type="submit"]:hover,
    input[type="button"]:hover {
      background-color: #6e7bff;
    }
  </style>
</body>
</html>

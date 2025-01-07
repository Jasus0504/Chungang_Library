<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include '../dbconn.php';

$cid = isset($_GET['id']) ? $_GET['id'] : ''; // ID 가져오기, 존재하지 않는 경우 기본값 설정
$cid = $con->real_escape_string($cid); // SQL 인젝션 방지

$sql = "SELECT * FROM info WHERE id = '$cid'";
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
  <title>회원정보 수정 및 삭제</title>
</head>
<body>
  <div class="center">
    <h2>회원정보</h2>
    <form name="frm_content" method="post" action="m_updateOk.php?id=<?php echo htmlspecialchars($cid); ?>">
      <table>
        <tr align="center">
          <th>아이디</th>
          <td><input type="text" name="custid" value="<?php echo htmlspecialchars($row['id']); ?>"></td>
        </tr>
        <tr align="center">
          <th>비밀번호</th>
          <td><input type="text" name="custpwd" value="<?php echo htmlspecialchars($row['pwd']); ?>"></td>
        </tr>
        <tr align="center">
          <th>이름</th>
          <td><input type="text" name="custname" value="<?php echo htmlspecialchars($row['name']); ?>"></td>
        </tr>
        <tr align="center">
          <th>나이</th>
          <td><input type="text" name="custage" value="<?php echo htmlspecialchars($row['age']); ?>"></td>
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
    function deldata() {
      location.href='./m_delete.php?id=<?php echo $cid ?>';
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

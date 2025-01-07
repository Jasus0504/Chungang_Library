<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>회원목록</title>
</head>
<body>
  <div class="center">
  <h2 class="title"><a href="../main.php">지식 도서관</a></h2>
    <h4>회원목록</h4>
    <form action="" method="GET">
      <input type="text" name="search" placeholder="검색어 입력"/>
      <select name="search_type">
        <option value="id">아이디</option>
        <option value="name">이름</option>
      </select>
      <input type="submit" value="검색"/>
    </form>
    <table>
      <tr align="center">
        <th>아이디</th>
        <th>비번</th>
        <th>이름</th>
        <th>나이</th>
        <th>전화번호</th>
      </tr>
      <?php
      include '../dbconn.php';
      $search = isset($_GET['search']) ? $_GET['search'] : '';
      $search = mysqli_real_escape_string($con, $search);
      $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'id';

      if ($search_type == 'name') {
        $sql = "SELECT * FROM info WHERE name LIKE '%$search%'";
      } else {
        $sql = "SELECT * FROM info WHERE id LIKE '%$search%'";
      }

      $result = $con->query($sql);

      while ($row = mysqli_fetch_array($result)) {
        echo "
        <tr>
          <td><a href='m_selectOne.php?id=$row[id]'>$row[id]</a></td>
          <td>$row[pwd]</td>
          <td>$row[name]</td>
          <td>$row[age]</td>
          <td>$row[phone_number]</td>
        </tr>
        ";
      }
      mysqli_close($con);
      ?>
    </table>
  </div>

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
    form input[type="text"] {
      padding: 10px;
      margin-right: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    form select {
      padding: 10px;
      margin-right: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    form input[type="submit"] {
      padding: 10px 20px;
      border: none;
      background-color: #5C67F2;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    form input[type="submit"]:hover {
      background-color: #6e7bff;
    }
    table {
      width: 80%;
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
    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }
  </style>
</body>
</html>

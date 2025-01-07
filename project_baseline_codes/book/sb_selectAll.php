<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>도서관 보유 도서 리스트</title>
</head>
<body>
  <div class="center">
    <h2>도서관 보유 도서 리스트</h2>
    <table>
      <tr align="center">
        <th>도서번호</th>
        <th>도서명</th>
        <th>작가</th>
        <th>위치</th>
        <th>대여가능</th>
        <th>책 이미지</th>
      </tr>

      <?php
        include '../dbconn.php';

        $cb_name = isset($_GET['b_name']) ? $_GET['b_name'] : ''; // ID 가져오기, 존재하지 않는 경우 기본값 설정
        $cb_name = $con->real_escape_string($cb_name); // SQL 인젝션 방지

        $sql = "SELECT * FROM book_list WHERE b_name = '$cb_name'";
        $result = $con->query($sql);

        while ($row = mysqli_fetch_array($result)) {
          $rentStatus = ($row['b_rent'] == 'in') ? '대여가능' : '대여불가능';
          $b_name = htmlspecialchars($row['b_name'], ENT_QUOTES, 'UTF-8');
          $image_url = htmlspecialchars($row['b_image'], ENT_QUOTES, 'UTF-8');
          echo "
          <tr>
            <td><a href='b_selectOne.php?b_num={$row['b_num']}'>{$row['b_num']}</a></td>
            <td>{$row['b_name']}</td>
            <td>{$row['b_author']}</td>
            <td>{$row['b_location']}</td>
            <td>{$rentStatus}</td>
            <td><img src='{$image_url}' alt='Book Image' style='width:100px; height:150px;'></td>
          </tr>
          ";
        }
        mysqli_close($con);
      ?>
    </table>
  </div>

  <script>
    function deleteBook() {
      location.href='./b_deleteOk.php?id=<?php echo $cb_name ?>';
    }

    function editBook(b_num) {
      window.location.href = 'b_update.php?b_num=' + encodeURIComponent(b_num); // 수정 페이지로 이동
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
    .book-image {
      border-radius: 5px;
    }
  </style>
</body>
</html>

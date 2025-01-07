<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>도서관 보유 도서 리스트</title>
</head>
<body>
  <div class="center">
    <h2 class="title"><a href="../main.php">지식 도서관</a></h2>
    <h2>도서관 보유 도서 리스트</h2>
    <form action="" method="GET">
      <input type="text" name="search" placeholder="검색어 입력" required/>
      <select name="search_type">
        <option value="title">도서명</option>
        <option value="author">작가명</option>
      </select>
      <input type="submit" value="검색"/>
    </form>
    <table>
      <tr align="center">
        <th>도서명</th>
        <th>작가</th>
        <th>위치</th>
        <th>현재 수량 / 대여가능</th>
        <th>이미지</th>
      </tr>
      <?php
        include '../dbconn.php';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $search = mysqli_real_escape_string($con, $search);
        $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'title';

        if ($search_type == 'author') {
          $sql = "SELECT b_name, b_author, GROUP_CONCAT(DISTINCT b_location SEPARATOR ', ') AS b_locations,
                       COUNT(*) AS total_books,
                       SUM(CASE WHEN b_rent = 'in' THEN 1 ELSE 0 END) AS available_books,
                       b_image
                FROM book_list
                WHERE b_author LIKE '%$search%'
                GROUP BY b_name, b_author";
        } else {
          $sql = "SELECT b_name, b_author, GROUP_CONCAT(DISTINCT b_location SEPARATOR ', ') AS b_locations,
                       COUNT(*) AS total_books,
                       SUM(CASE WHEN b_rent = 'in' THEN 1 ELSE 0 END) AS available_books,
                       b_image
                FROM book_list
                WHERE b_name LIKE '%$search%'
                GROUP BY b_name, b_author";
        }

        $result = $con->query($sql);
        if ($result->num_rows > 0) { // 검색 결과가 있으면
          while ($row = mysqli_fetch_array($result)) {
            $b_name = htmlspecialchars($row['b_name'], ENT_QUOTES, 'UTF-8');
            $b_author = htmlspecialchars($row['b_author'], ENT_QUOTES, 'UTF-8');
            $b_locations = htmlspecialchars($row['b_locations'], ENT_QUOTES, 'UTF-8');
            $total_books = htmlspecialchars($row['total_books'], ENT_QUOTES, 'UTF-8');
            $available_books = htmlspecialchars($row['available_books'], ENT_QUOTES, 'UTF-8');
            $image_url = htmlspecialchars($row['b_image'], ENT_QUOTES, 'UTF-8');
            echo "
            <tr>
              <td><a href='sb_selectall.php?b_name={$b_name}'>{$b_name}</a></td>
              <td>{$b_author}</td>
              <td>{$b_locations}</td>
              <td>{$available_books} / {$total_books}</td>
              <td><img src='{$image_url}' alt='book image' width='50' height='50'></td>
            </tr>
            ";
          }
        } else { // 검색 결과가 없으면
          echo "<tr><td colspan='5'>해당 도서를 보유하고 있지 않습니다.</td></tr>";
        }
        mysqli_close($con);
      ?>
    </table>
  </div>

  <script>
    function deleteBook(bookId) {
      if (confirm('이 도서를 삭제하시겠습니까?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'b_deleteOk.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (this.status == 200 && this.responseText === 'success') {
            alert('도서가 삭제되었습니다.');
            window.location.reload();
          } else {
            alert('도서 삭제 실패: ' + this.responseText);
          }
        };
        xhr.send('id=' + encodeURIComponent(bookId));
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
    .book-image {
      border-radius: 5px;
    }
  </style>
</body>
</html>

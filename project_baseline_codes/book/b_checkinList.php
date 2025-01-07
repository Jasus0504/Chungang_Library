<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>지식 도서관</title>
</head>
<body>
<div class="center">
  <br><br><br><br>
  <h2 class="title"><a href="../main.php">지식 도서관</a></h2>
  <h2>현재 대여 독서</h2>
  <table>
    <tr align="center">
      <th>도서번호</th>
      <th>도서명</th>
      <th>작가</th>
      <th>반납</th>
    </tr>

    <?php
    include '../dbconn.php';  // 데이터베이스 연결
    include '../session.php'; 

    $userid = $_SESSION['user_id'];  // 세션에서 사용자 ID를 가져옵니다.

    $sql = "SELECT * FROM book_list WHERE r_name = '$userid' AND b_rent = 'out'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // 데이터가 있을 경우 테이블에 표시
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                      <td>{$row['b_num']}</td>
                      <td>{$row['b_name']}</td>
                      <td>{$row['b_author']}</td>
                      <td>
                          <form action='b_checkin.php' method='post'>
                              <input type='hidden' name='b_name' value='{$row['b_name']}' />
                              <input type='hidden' name='b_num' value='{$row['b_num']}' />
                              <input type='hidden' name='b_author' value='{$row['b_author']}' />
                              <input type='submit' value='반납하기'/>
                          </form>
                      </td>
                  </tr>";
        }
    } else {
        // 데이터가 없을 경우 메시지 출력
        echo "<tr><td colspan='4' class='no-books'>반납 가능한 도서가 없습니다.</td></tr>";
    }

    mysqli_close($con);
    ?>
  </table>
</div>
</body>
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
    h2.title a {
      text-decoration: none;
      color: inherit;
    }
    table {
      width: 80%;
      margin: 20px auto;
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
    .review {
      border: 1px solid #ddd;
      margin-top: 10px;
      padding: 10px;
      border-radius: 5px;
      background-color: #fff;
    }
    .review-header {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .review-body {
      margin-bottom: 5px;
    }
    .reviews-container {
      width: 80%;
      margin: 20px auto;
      text-align: left;
    }
    .no-books, .no-reviews {
      text-align: center;
      padding: 20px;
      font-size: 18px;
      color: #999;
    }
  </style>
</html>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>지식 도서관</title>
</head>
<body>
<div class="center">
    <br><br><br><br>
    <h2 class="title"><a href="../main.php">지식 도서관</a></h2>
    <h2 class="title">도서관 보유 도서 리스트</h2>
    <table>
      <tr align="center">
      <th>도서번호</th></th>
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

      $cb_author = isset($_GET['b_author']) ? $_GET['b_author'] : ''; // ID 가져오기, 존재하지 않는 경우 기본값 설정
      $cb_author = $con->real_escape_string($cb_author); // SQL 인젝션 방지

      $sql = "SELECT bl.b_name,bl.b_num, bl.b_author, GROUP_CONCAT(DISTINCT bl.b_location SEPARATOR ', ') AS b_locations, 
                     bl.b_rent, bl.b_image, ROUND(AVG(cl.b_rate), 1) AS avg_b_rate, COUNT(cl.b_rate) AS comment_count
              FROM book_list bl
              LEFT JOIN comment_list cl ON bl.b_name = cl.b_name AND bl.b_author = cl.b_author
              WHERE bl.b_name = '$cb_name' AND bl.b_author = '$cb_author'
              GROUP BY bl.b_name, bl.b_author, bl.b_rent, bl.b_image";

      $result = $con->query($sql);
      $book_info = []; // 책 정보를 저장하기 위한 배열
      $b_name = "";
      $b_author = "";
      $comment_count = 0;
      $avg_b_rate = 0;

      if ($result->num_rows > 0) {
          while ($row = mysqli_fetch_array($result)) {
              $rentStatus = ($row['b_rent'] == 'in') ? '대여가능' : '대여불가능';
              $b_name = htmlspecialchars($row['b_name'], ENT_QUOTES, 'UTF-8');
              $b_num = htmlspecialchars($row['b_num'], ENT_QUOTES, 'UTF-8');
              $b_author = htmlspecialchars($row['b_author'], ENT_QUOTES, 'UTF-8');
              $b_locations = htmlspecialchars($row['b_locations'], ENT_QUOTES, 'UTF-8');
              $image_url = htmlspecialchars($row['b_image'], ENT_QUOTES, 'UTF-8');
              $avg_b_rate = $row['avg_b_rate'];
              $comment_count = $row['comment_count'];
              $book_info[] = "
              <tr>
              <td>{$b_num}</td>
                <td>{$b_name}</td>
                <td>{$b_author}</td>
                <td>{$b_locations}</td>
                <td>{$rentStatus}</td>
                <td><img src='{$image_url}' alt='Book Image' class='book-image' style='width:100px; height:150px;'></td>
              </tr>
              ";
          }
          // 책 정보를 출력
          foreach ($book_info as $book) {
              echo $book;
          }
      } else {
          echo "<tr><td colspan='5' class='no-books'>해당 도서를 보유하고 있지 않습니다.</td></tr>";
      }

      ?>
    </table>

    <?php
    if ($result->num_rows > 0) {
        echo "<div class='reviews-container'>";
        echo "<h3>리뷰 ({$comment_count}개)</h3>"; // 리뷰 헤더 추가
        echo "<h3>평균 평점 ({$avg_b_rate})</h3>"; // 평균 평점 추가

        $comment_sql = "SELECT b_comment, b_rate, c_writer FROM comment_list 
                        WHERE b_name = '$b_name' AND b_author = '$b_author'";
        $comment_result = $con->query($comment_sql);

        if ($comment_result->num_rows > 0) {
            while ($comment_row = mysqli_fetch_array($comment_result)) {
                $b_comment = htmlspecialchars($comment_row['b_comment'], ENT_QUOTES, 'UTF-8');
                $b_rate = htmlspecialchars($comment_row['b_rate'], ENT_QUOTES, 'UTF-8');
                $c_writer = htmlspecialchars($comment_row['c_writer'], ENT_QUOTES, 'UTF-8');
                echo "
                <div class='review'>
                  <div class='review-header'>아이디: {$c_writer} | 평점: {$b_rate}</div>
                  <div class='review-body'>{$b_comment}</div>
                </div>
                ";
            }
        } else {
            echo "<div class='review no-reviews'><div class='review-body'>아직 리뷰가 없습니다.</div></div>";
        }
        echo "</div>";
    }

    mysqli_close($con);
    ?>

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
    h2.title {
      color: #333;
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
